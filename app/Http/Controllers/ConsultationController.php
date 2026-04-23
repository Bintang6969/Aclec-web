<?php

namespace App\Http\Controllers;

use App\Models\ConsultationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ConsultationController extends Controller
{
    public function index()
    {
        $messages = ConsultationMessage::where('user_id', Auth::id())
            ->orderBy('created_at')
            ->get();

        return view('consultation.index', compact('messages'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        ConsultationMessage::create([
            'user_id' => Auth::id(),
            'sender'  => 'user',
            'message' => $data['message'],
        ]);

        $aiReply = $this->askGemini(Auth::user(), $data['message']);

        ConsultationMessage::create([
            'user_id' => Auth::id(),
            'sender'  => 'ai',
            'message' => $aiReply,
        ]);

        return redirect()->route('consultation.index');
    }

    public function clear(Request $request)
    {
        ConsultationMessage::where('user_id', Auth::id())->delete();
        return redirect()->route('consultation.index')->with('success', 'Riwayat chat dihapus.');
    }

    /**
     * JSON endpoint for the SPA dashboard AI chat widget.
     */
    public function askGeminiJson(Request $request)
    {
        $data = $request->validate([
            'prompt' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        // Save user message before calling AI (so context is available)
        ConsultationMessage::create([
            'user_id' => Auth::id(),
            'sender'  => 'user',
            'message' => $data['prompt'],
        ]);

        $answer = $this->askGemini(Auth::user(), $data['prompt']);

        ConsultationMessage::create([
            'user_id' => Auth::id(),
            'sender'  => 'ai',
            'message' => $answer,
        ]);

        return response()->json(['answer' => $answer]);
    }

    private function askGemini($user, string $userMessage): string
    {
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return 'Maaf, layanan AI belum siap.';
        }

        // 1. Ambil riwayat chat terakhir (misal 6 pesan terakhir) agar AI punya konteks
        $history = \App\Models\ConsultationMessage::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        $contents = [];
        foreach ($history as $msg) {
            $contents[] = [
                'role' => $msg->sender === 'user' ? 'user' : 'model',
                'parts' => [['text' => $msg->message]]
            ];
        }

        // Jika pesan terbaru belum masuk $history, tambahkan manual
        // (Tergantung apakah kamu memanggil askGemini setelah/sebelum simpan ke DB)

        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    // Gunakan system_instruction agar persona lebih kuat
                    'system_instruction' => [
                        'parts' => [
                            ['text' => "Kamu adalah FitBot, asisten kesehatan FitLife. User: {$user->name}, Goal: {$user->goal}. Hangat, empati, maks 3 paragraf. Bukan dokter."]
                        ]
                    ],
                    'contents' => $contents, 
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 500,
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text') ?? 'Maaf, saya sedang melamun...';
            }

            // Handle Quota Limit (429)
            if ($response->status() === 429) {
                return 'FitBot sedang ramai pengunjung, coba lagi sebentar ya!';
            }

        } catch (\Exception $e) {
            \Log::error('Gemini Error: ' . $e->getMessage());
        }

        return 'Maaf, ada gangguan koneksi ke otak AI saya.';
    }
}


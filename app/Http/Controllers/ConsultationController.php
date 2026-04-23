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

    private function askGemini($user, string $userMessage): string
    {
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return 'Maaf, layanan AI saat ini belum dikonfigurasi. Silakan coba lagi nanti.';
        }

        $systemPrompt = "Kamu adalah asisten kesehatan dan teman curhat bernama FitBot di platform FitLife. "
            . "Tugasmu adalah memberikan dukungan psikologis ringan, motivasi, dan saran kesehatan dasar kepada pengguna. "
            . "Pengguna bernama {$user->name}, memiliki tujuan: {$user->goal}. "
            . "Selalu berikan respons dalam Bahasa Indonesia yang hangat, empatik, dan mendukung. "
            . "Jangan memberikan diagnosis medis. Anjurkan konsultasi dokter untuk masalah medis serius. "
            . "Batasi jawaban maksimal 3 paragraf singkat.";

        try {
            $response = Http::timeout(20)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nPesan pengguna: " . $userMessage],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 512,
                        'temperature'     => 0.7,
                    ],
                ]
            );

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text')
                    ?? 'Maaf, saya tidak dapat merespons saat ini.';
            }
        } catch (\Exception) {
            // fall through
        }

        return 'Maaf, terjadi kesalahan saat menghubungi layanan AI. Silakan coba lagi.';
    }
}

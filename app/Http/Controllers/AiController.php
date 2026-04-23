<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function ask(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = env('GEMINI_API_KEY'); 

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey;

        $response = Http::post($url, [
            'contents' => [['parts' => [['text' => $prompt]]]]
        ]);

        if ($response->successful()) {
            return response()->json([
                'answer' => $response->json()['candidates'][0]['content']['parts'][0]['text']
            ]);
        }

        return response()->json(['answer' => 'Gagal: ' . $response->body()], 500);
    } 

    public function listModels()
    {
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;
        
        $response = Http::get($url);
        return $response->json(); 
    }
}
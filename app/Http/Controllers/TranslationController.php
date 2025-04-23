<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class TranslationController extends Controller
{
    public function translate_bk(Request $request) {
        $text = $request->text;
        $targetLang = $request->lang ?? Cookie::get('user_language', 'en');

        // Save language in cookie (1-year expiration)
        Cookie::queue('user_language', $targetLang, 60 * 24 * 365);

        $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
        $url = "https://translation.googleapis.com/language/translate/v2";

        $response = Http::post($url, [
            'q' => $text,
            'target' => $targetLang,
            'format' => 'text',
            'key' => $apiKey
        ]);

        return response()->json($response->json());
    }
    
    public function translate(Request $request) {
        $textNodes = $request->input('text', []); // Get text array safely

        // Ensure textNodes is an array and not empty
        if (!is_array($textNodes) || empty($textNodes)) {
            return response()->json(['error' => 'No text provided for translation.'], 400);
        }

        // Get the target language (Middleware already set this in a cookie)
        $targetLang = $request->input('lang', Cookie::get('user_language', 'en'));

        // If language is English, return original text (no translation needed)
        if ($targetLang === 'en') {
            return response()->json(['translatedText' => $textNodes]);
        }

        $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
        if (empty($apiKey)) {
            Log::error('Google Translate API Key is missing.');
            return response()->json(['error' => 'Translation service unavailable.'], 500);
        }

        $url = "https://translation.googleapis.com/language/translate/v2?key={$apiKey}";

        // Use a separator that is unlikely to appear in normal text
        $separator = "|||"; 
        $mergedText = implode($separator, $textNodes);

        try {
            $response = Http::post($url, [
                'q' => $mergedText,
                'target' => $targetLang,
                'format' => 'text'
            ]);

            $data = $response->json();

            if (!isset($data['data']['translations'][0]['translatedText'])) {
                Log::error('Google Translate API Response Error:', ['response' => $data]);
                return response()->json(['error' => 'Translation failed'], 500);
            }

            // Split translated text back into separate parts
            $translatedText = explode($separator, $data['data']['translations'][0]['translatedText']);

            return response()->json(['translatedText' => $translatedText]);
        } catch (\Exception $e) {
            Log::error('Google Translate API Request Failed:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Translation service is currently unavailable.'], 500);
        }
    }
    
    
    

    public function getLanguage() {
        return response()->json(['lang' => Cookie::get('user_language', 'en')]);
    }
}

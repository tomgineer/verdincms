<?php namespace App\Libraries;

/**
 * ****************************************************
 * OpenAIService Library — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Provides a static interface to communicate with OpenAI's API.
 * Designed for simple, direct GPT-4.1 integration with minimal setup.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Features
 * --------
 * • Sends a user message to the OpenAI GPT-4.1 model
 * • Handles CURL requests with proper headers and error handling
 * • Parses multi-part responses to return assistant-generated text
 *
 * Requirements
 * ------------
 * - An `openai.apiKey` must be defined in your `.env` file
 * - PHP cURL and JSON extensions must be enabled
 *
 * ****************************************************
 */

class OpenAIService {
    public static function chat(string $userMessage): ?string {
        $apiKey = env('openai.apiKey');
        if (!$apiKey) {
            throw new \RuntimeException('API key not configured');
        }

        $payload = [
            "model" => "gpt-4.1",
            "tools" => [
                ["type" => "web_search_preview"]
            ],
            "input" => $userMessage
        ];

        $ch = curl_init("https://api.openai.com/v1/responses");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \RuntimeException("OpenAI API error ($httpCode): $err - Response: $response");
        }

        $data = json_decode($response, true);

        // Loop through the API response's 'output' array to find the assistant's message.
        // The response may contain various types (e.g., web_search_call, message, etc.).
        // We specifically look for a 'message' entry with 'output_text' content
        // and return the first available assistant reply text.

        foreach ($data['output'] ?? [] as $item) {
            if ($item['type'] === 'message') {
                foreach ($item['content'] ?? [] as $content) {
                    if ($content['type'] === 'output_text' && isset($content['text'])) {
                        return $content['text'];
                    }
                }
            }
        }
        return null;

    }
}

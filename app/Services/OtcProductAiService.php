<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OtcProductAiService
{
    public function generate(array $data): array
    {
        $prompt = $this->buildPrompt($data);

        $response = Http::withoutVerifying()
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . config('services.gemini.key'),
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            );

        // dd($response->json());

        $text = $response->json('candidates.0.content.parts.0.text');

        preg_match('/\{.*\}/s', $text, $matches);

        $json = $matches[0] ?? '{}';

        return json_decode($json, true);
    }

    protected function buildPrompt(array $data): string
    {
        return "
            Generate professional OTC product information for the following product.

            Product Name: {$data['name']}
            Category: {$data['category']}
            Market: {$data['market']}

            Requirements:
            - Write in a clear, regulatory-compliant, non-salesy tone
            - Suitable for product catalog, ERP, or admin panel
            - Avoid hype or marketing words
            - Keep descriptions factual and precise

            Output strictly in JSON format with these fields and more fields if necessary:

            {
            \"product_code\": \"\",
            \"sku\": \"\",
            \"short_description\": \"\",
            \"long_description\": \"\",
            \"key_features\": [],
            \"indications\": \"\",
            \"dosage_instructions\": \"\",
            \"warnings\": \"\",
            \"storage_instructions\": \"\"
            }
            ";
    }
}

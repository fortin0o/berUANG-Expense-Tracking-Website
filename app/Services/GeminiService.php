<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $endpoint;

    public function __construct()
    {
        $this->apiKey   = config('services.gemini.key');
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
    }

    /**
     * Generate a financial insight for the dashboard.
     */
    public function dashboardInsight(
        float $balance,
        float $totalIncome,
        float $totalExpense,
        array $topCategories
    ): string {
        $categoryList = collect($topCategories)
            ->map(fn($c) => "{$c['name']}: Rp " . number_format($c['total'], 0, ',', '.'))
            ->implode(', ');

        $prompt = <<<PROMPT
Kamu adalah asisten keuangan pribadi. Analisis data keuangan berikut dan berikan 1-2 kalimat insight yang spesifik, actionable, dan dalam Bahasa Indonesia. Jangan gunakan formatting markdown, cukup teks biasa.

Data keuangan:
- Total Pemasukan: Rp {$this->fmt($totalIncome)}
- Total Pengeluaran: Rp {$this->fmt($totalExpense)}
- Saldo: Rp {$this->fmt($balance)}
- Kategori pengeluaran terbesar: {$categoryList}

Berikan insight singkat yang relevan berdasarkan data di atas.
PROMPT;

        return $this->ask($prompt, $this->fallbackDashboard($balance, $totalIncome, $totalExpense));
    }

    /**
     * Generate a financial insight for the PDF export report.
     */
    public function reportInsight(
        float $balance,
        float $totalIncome,
        float $totalExpense,
        int $transactionCount
    ): string {
        $prompt = <<<PROMPT
Kamu adalah analis keuangan. Buat ringkasan evaluasi keuangan dalam 2-3 kalimat berdasarkan data berikut. Gunakan Bahasa Indonesia yang profesional. Jangan gunakan formatting markdown.

Ringkasan laporan:
- Total Pemasukan: Rp {$this->fmt($totalIncome)}
- Total Pengeluaran: Rp {$this->fmt($totalExpense)}
- Saldo Akhir: Rp {$this->fmt($balance)}
- Jumlah Transaksi: {$transactionCount}
- Rasio Pengeluaran/Pemasukan: {$this->ratio($totalIncome, $totalExpense)}%

Berikan evaluasi singkat dan rekomendasi untuk ke depannya.
PROMPT;

        return $this->ask($prompt, $this->fallbackReport($balance, $totalIncome, $totalExpense));
    }

    /**
     * Analyze a receipt image and return extracted data as JSON.
     */
    public function analyzeReceipt(string $base64Image, string $mimeType): ?array
    {
        if (empty($this->apiKey)) {
            return null;
        }

        $prompt = <<<PROMPT
Anda adalah asisten AI yang ahli dalam membaca struk belanja/pembayaran (OCR). 
Ekstrak informasi dari gambar struk berikut dan kembalikan HANYA dalam format JSON yang valid, tanpa tambahan teks apapun di luar JSON.

Format JSON yang dibutuhkan:
{
    "title": "Nama Toko / Judul Singkat Transaksi",
    "amount": Angka Total (integer, hilangkan Rp/titik/koma, misal 50000),
    "date": "Tanggal transaksi dalam format YYYY-MM-DD. Jika tidak ada, gunakan tanggal hari ini",
    "description": "Catatan singkat atau daftar item utama (maksimal 1-2 kalimat)",
    "category_name": "Satu kata yang paling cocok untuk kategori (misal: Makanan, Transportasi, Belanja, Tagihan, Kesehatan, Hiburan)"
}
PROMPT;

        try {
            $response = Http::timeout(15)
                ->post("{$this->endpoint}?key={$this->apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                                [
                                    'inlineData' => [
                                        'mimeType' => $mimeType,
                                        'data'     => $base64Image,
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.2, // Low temp for more accurate extraction
                        'maxOutputTokens' => 300,
                        'responseMimeType' => 'application/json', // Force JSON output
                    ],
                ]);

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text');
                if ($text) {
                    return json_decode($text, true);
                }
            }

            Log::warning('Gemini API Vision error: ' . $response->status() . ' ' . $response->body());
        } catch (\Throwable $e) {
            Log::warning('Gemini Vision request failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Send a prompt to Gemini and return the text response.
     */
    private function ask(string $prompt, string $fallback): string
    {
        if (empty($this->apiKey)) {
            return $fallback;
        }

        try {
            $response = Http::timeout(8)
                ->post("{$this->endpoint}?key={$this->apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 150,
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text', $fallback);
            }

            Log::warning('Gemini API error: ' . $response->status() . ' ' . $response->body());
        } catch (\Throwable $e) {
            Log::warning('Gemini request failed: ' . $e->getMessage());
        }

        return $fallback;
    }

    // ============================
    // HELPERS
    // ============================

    private function fmt(float $amount): string
    {
        return number_format($amount, 0, ',', '.');
    }

    private function ratio(float $income, float $expense): int
    {
        if ($income <= 0) return 100;
        return (int) round(($expense / $income) * 100);
    }

    private function fallbackDashboard(float $balance, float $income, float $expense): string
    {
        if ($balance < 0) {
            return '🚨 Defisit! Pengeluaran melebihi pemasukan, segera kurangi pengeluaran tidak perlu.';
        }
        if ($income > 0 && $expense > $income * 0.8) {
            return '💸 Pengeluaran sudah melebihi 80% pemasukan. Waspadai pengeluaran berlebih.';
        }
        if ($balance < 50000) {
            return '⚠️ Saldo hampir habis. Hindari pengeluaran yang tidak mendesak.';
        }
        return '✅ Keuangan kamu stabil. Pertahankan pola ini!';
    }

    private function fallbackReport(float $balance, float $income, float $expense): string
    {
        $ratio = $this->ratio($income, $expense);
        return "Rasio pengeluaran terhadap pemasukan sebesar {$ratio}%. "
            . ($balance >= 0
                ? "Secara keseluruhan keuangan dalam kondisi positif."
                : "Terdapat defisit yang perlu segera diatasi.");
    }
}

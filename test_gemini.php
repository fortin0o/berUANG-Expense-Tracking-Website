<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\GeminiService;

$g = new GeminiService();
$result = $g->dashboardInsight(
    500000,
    2000000,
    1500000,
    [
        ['name' => 'Makanan', 'total' => 800000],
        ['name' => 'Transportasi', 'total' => 400000],
    ]
);

echo "=== Gemini Response ===\n";
echo $result . "\n";

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => 'ayam123'
        ]);

        // Default categories for the test user
        $this->seedDefaultCategories($user->id);
    }

    /**
     * Seed default income & expense categories for a user.
     */
    public static function seedDefaultCategories(int $userId): void
    {
        $defaults = [
            // Income
            ['name' => 'Gaji',          'type' => 'income'],
            ['name' => 'Freelance',     'type' => 'income'],
            ['name' => 'Investasi',     'type' => 'income'],
            ['name' => 'Bonus',         'type' => 'income'],
            ['name' => 'Lainnya',       'type' => 'income'],

            // Expense
            ['name' => 'Makanan',       'type' => 'expense'],
            ['name' => 'Transportasi',  'type' => 'expense'],
            ['name' => 'Belanja',       'type' => 'expense'],
            ['name' => 'Kesehatan',     'type' => 'expense'],
            ['name' => 'Hiburan',       'type' => 'expense'],
            ['name' => 'Tagihan',       'type' => 'expense'],
            ['name' => 'Pendidikan',    'type' => 'expense'],
            ['name' => 'Lainnya',       'type' => 'expense'],
        ];

        foreach ($defaults as $cat) {
            Category::firstOrCreate(
                ['user_id' => $userId, 'name' => $cat['name'], 'type' => $cat['type']],
                ['user_id' => $userId, 'name' => $cat['name'], 'type' => $cat['type']]
            );
        }
    }
}

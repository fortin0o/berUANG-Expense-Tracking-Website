<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register'); // Tetap pakai view custom Anda
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create default categories
        $defaultCategories = [
            // Income
            ['name' => 'Gaji',         'type' => 'income'],
            ['name' => 'Freelance',    'type' => 'income'],
            ['name' => 'Investasi',    'type' => 'income'],
            ['name' => 'Bonus',        'type' => 'income'],
            ['name' => 'Lainnya',      'type' => 'income'],
            // Expense
            ['name' => 'Makanan',      'type' => 'expense'],
            ['name' => 'Transportasi', 'type' => 'expense'],
            ['name' => 'Belanja',      'type' => 'expense'],
            ['name' => 'Kesehatan',    'type' => 'expense'],
            ['name' => 'Hiburan',      'type' => 'expense'],
            ['name' => 'Tagihan',      'type' => 'expense'],
            ['name' => 'Pendidikan',   'type' => 'expense'],
            ['name' => 'Lainnya',      'type' => 'expense'],
        ];

        foreach ($defaultCategories as $cat) {
            $user->categories()->create($cat);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
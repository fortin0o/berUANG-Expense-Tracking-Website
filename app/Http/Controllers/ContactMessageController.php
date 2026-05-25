<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($validated);

        try {
            // Read admin email from .env or use a default one for now
            $adminEmail = env('MAIL_FROM_ADDRESS', 'admin@beruang.com');
            Mail::to($adminEmail)->send(new ContactMessageMail($message));
        } catch (\Exception $e) {
            // Log the error but don't fail the user interaction
            \Illuminate\Support\Facades\Log::error('Failed to send contact message: ' . $e->getMessage());
        }

        // Return back directly to the footer anchor so it doesn't jump to the top
        return redirect('/#footer-contact')
            ->with('success', 'Your message has been sent successfully!');
    }
}

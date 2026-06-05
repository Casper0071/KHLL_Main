<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Log de data in console
        Log::info('Contact form submitted', [
            'timestamp' => now(),
            'data' => $validated,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
    }
}

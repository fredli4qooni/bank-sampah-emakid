<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatbotService;
use App\Models\ChatbotSetting;

class ChatbotController extends Controller
{
    protected ChatbotService $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function query(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $setting = ChatbotSetting::first();
        if ($setting && !$setting->is_active) {
            return response()->json([
                'status' => 'success',
                'reply' => '⛔ Maaf, layanan Chatbot saat ini sedang dinonaktifkan oleh Pengelola Sistem.'
            ]);
        }

        $message = $request->input('message');
        $reply = $this->chatbotService->processMessage($message);

        return response()->json([
            'status' => 'success',
            'reply' => $reply
        ]);
    }
}
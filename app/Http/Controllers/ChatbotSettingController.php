<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSetting;
use Illuminate\Http\Request;
use App\Models\ChatbotRule;

class ChatbotSettingController extends Controller
{
    public function index()
    {
        $setting = ChatbotSetting::firstOrCreate(
            ['id' => 1],
            [
                'system_prompt' => '',
                'welcome_message' => 'Halo, Admin! Chatbot Assistant siap membantu.',
                'is_active' => true
            ]
        );

        $rules = ChatbotRule::where('jenis_aksi', 'teks')->orderBy('created_at', 'desc')->get();

        return view('chatbot.setting', compact('setting', 'rules'));
    }

    public function storeRule(Request $request)
    {
        $request->validate([
            'nama_aturan' => 'required',
            'keywords' => 'required',
            'jenis_aksi' => 'required|in:sistem,teks',
        ]);

        ChatbotRule::create($request->all());
        return back()->with('success', 'Aturan Chatbot baru berhasil ditambahkan!');
    }

    public function updateRule(Request $request, int $id)
    {
        $rule = ChatbotRule::findOrFail($id);
        $rule->update([
            'keywords' => $request->keywords,
            'balasan_teks' => $request->balasan_teks,
        ]);
        return back()->with('success', 'Kata kunci aturan berhasil diubah!');
    }

    public function destroyRule(int $id)
    {
        $rule = ChatbotRule::findOrFail($id);
        if($rule->jenis_aksi === 'sistem') {
            return back()->with('error', 'Aturan sistem bawaan tidak boleh dihapus, Anda hanya boleh mengubah kata kuncinya.');
        }
        $rule->delete();
        return back()->with('success', 'Aturan berhasil dihapus!');
    }
}
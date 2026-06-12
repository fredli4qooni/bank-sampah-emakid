<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotRule;

class ChatbotRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = config('chatbot_rules.intents');
        
        if($rules) {
            foreach ($rules as $intentId => $rule) {
                ChatbotRule::firstOrCreate(
                    ['nama_aturan' => $intentId],
                    [
                        'keywords' => implode(', ', $rule['keywords']),
                        'jenis_aksi' => 'sistem',
                        'handler_sistem' => $rule['handler'],
                        'balasan_teks' => null
                    ]
                );
            }
        }
    }
}
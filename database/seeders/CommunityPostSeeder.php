<?php

namespace Database\Seeders;

use App\Models\CommunityPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommunityPostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $posts = [
            [
                'user_id' => $users[0]->id,
                'content' => 'Hari ini saya berhasil mencapai score 85! 🎉 Ternyata dengan rajin tracking makanan dan olahraga, target bisa tercapai. Semangat semua!',
            ],
            [
                'user_id' => $users[1]->id,
                'content' => 'Sudah 2 minggu konsisten dengan program bulking. Berat badan naik 2kg dan terasa lebih kuat saat latihan. Konsistensi adalah kunci! 💪',
            ],
            [
                'user_id' => $users[2]->id,
                'content' => 'Tadi pagi lari 5km dalam 35 menit. Feeling accomplished! 🏃‍♂️ Teman-teman, jangan lupa untuk warm-up dan cool-down ya.',
            ],
            [
                'user_id' => $users[3]->id,
                'content' => 'Udah try konsultasi dengan FitBot dan sangat helpful! Recommended banget untuk yang bingung soal menu diet. 👍',
            ],
            [
                'user_id' => $users[4]->id,
                'content' => 'Akhirnya bisa turun 5kg dalam sebulan! Rahasianya: tracking kalori yang ketat dan olahraga teratur. Kalian juga bisa!',
            ],
            [
                'user_id' => $users[0]->id,
                'content' => 'Ada yang punya rekomendasi olahraga yang fun dan bisa dimulai dari rumah? Lagi mencari variasi dari routine biasanya.',
            ],
            [
                'user_id' => $users[1]->id,
                'content' => 'Tidur 8 jam per malam ternyata beneran ngubah performa latihan saya. Jangan underestimate pentingnya istirahat! 😴',
            ],
            [
                'user_id' => $users[2]->id,
                'content' => 'Kombinasi HIIT dan strength training adalah game changer untuk saya. Hasil lebih cepat, waktu latihan lebih efisien. Coba deh! 🔥',
            ],
        ];

        foreach ($posts as $post) {
            CommunityPost::create($post);
        }
    }
}

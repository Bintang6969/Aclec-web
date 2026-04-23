<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'budi@fitlife.com')->first();

        $articles = [
            [
                'title' => 'Panduan Lengkap Menghitung TDEE untuk Pemula',
                'excerpt' => 'TDEE (Total Daily Energy Expenditure) adalah jumlah kalori yang Anda butuhkan setiap hari. Pelajari cara menghitungnya dengan akurat.',
                'content' => 'TDEE merupakan landasan penting dalam program diet dan fitness Anda. TDEE dihitung berdasarkan metabolisme basal (BMR) Anda dikali dengan faktor aktivitas harian. Semakin akurat perhitungan TDEE Anda, semakin efektif program diet dan olahraga Anda akan berjalan. Faktor-faktor yang mempengaruhi TDEE termasuk usia, jenis kelamin, berat badan, tinggi badan, dan tingkat aktivitas fisik. Untuk program diet, Anda harus menciptakan defisit kalori dengan mengonsumsi kalori lebih sedikit dari TDEE Anda. Sebaliknya, untuk program bulking, Anda harus mengonsumsi kalori lebih banyak dari TDEE Anda. Ingat, konsistensi dan disiplin adalah kunci kesuksesan Anda.',
                'category' => 'nutrition',
                'author_id' => $admin->id,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => '5 Jenis Olahraga Terbaik untuk Membakar Lemak',
                'excerpt' => 'Tidak semua olahraga memiliki efektivitas yang sama dalam membakar lemak. Ketahui 5 jenis olahraga paling efektif di sini.',
                'content' => 'Jenis olahraga yang Anda pilih sangat mempengaruhi hasil yang akan Anda dapatkan. HIIT (High Intensity Interval Training) adalah olahraga terbaik untuk membakar lemak karena dapat meningkatkan metabolisme Anda hingga 48 jam setelah latihan. Lari atau jogging adalah olahraga kardio klasik yang efektif dan dapat dilakukan siapa saja. Swimming adalah olahraga full body yang melibatkan seluruh otot tubuh Anda. Cycling atau bersepeda juga sangat baik untuk membakar kalori dan memperkuat otot kaki. Terakhir, rope jumping atau skipping adalah olahraga murah dan efektif yang dapat dilakukan di mana saja. Pilih olahraga yang Anda sukai agar konsistensi Anda meningkat.',
                'category' => 'workout',
                'author_id' => $admin->id,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Pentingnya Tidur Berkualitas untuk Kesehatan Fisik',
                'excerpt' => 'Tidur bukan hanya untuk istirahat. Tidur berkualitas sangat penting untuk memulihkan dan memperkuat tubuh Anda.',
                'content' => 'Tidur adalah periode pemulihan penting bagi tubuh Anda. Saat Anda tidur, tubuh Anda memproduksi hormon pertumbuhan yang penting untuk membangun otot dan merepair jaringan yang rusak. Kurang tidur dapat meningkatkan kadar kortisol (hormon stres) yang dapat menyebabkan penumpukan lemak di perut. Kualitas tidur yang buruk juga dapat mengurangi metabolisme dan meningkatkan nafsu makan Anda. Idealnya, Anda harus tidur 7-9 jam setiap malam untuk kesehatan optimal. Hindari kafein 6 jam sebelum tidur, jaga suhu kamar tetap sejuk, dan hindari gadget 30 menit sebelum tidur untuk meningkatkan kualitas tidur Anda.',
                'category' => 'lifestyle',
                'author_id' => $admin->id,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Manfaat Meditasi untuk Kesehatan Mental dan Fisik',
                'excerpt' => 'Meditasi bukan hanya untuk spiritual, tetapi juga memiliki manfaat kesehatan fisik dan mental yang terbukti secara ilmiah.',
                'content' => 'Meditasi adalah praktik kuno yang telah terbukti secara ilmiah dapat mengurangi stres dan kecemasan. Saat Anda bermeditasi, aktivitas di amigdala (pusat rasa takut di otak) berkurang, sementara aktivitas di prefrontal cortex (pusat kontrol diri) meningkat. Meditasi rutin dapat menurunkan tekanan darah, mengurangi detak jantung yang berlebihan, dan meningkatkan fokus. Untuk pemula, mulai dengan meditasi 5-10 menit setiap hari di tempat yang tenang. Fokuskan perhatian Anda pada napas Anda dan biarkan pikiran yang mengganggu lewat tanpa menghakimi. Konsistensi adalah kunci untuk merasakan manfaat meditasi.',
                'category' => 'mental_health',
                'author_id' => $admin->id,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Nutrisi Optimal: Makanan Sehat yang Lezat',
                'excerpt' => 'Makan sehat tidak harus membosankan. Berikut adalah resep makanan bergizi yang lezat dan mudah dibuat.',
                'content' => 'Banyak orang berpikir diet sehat harus membosankan dan tidak lezat. Padahal, ada banyak makanan bergizi yang sangat lezat. Ayam panggang dengan sayuran adalah pilihan yang sempurna untuk diet dan bulking. Nasi merah lebih bergizi daripada nasi putih karena memiliki lebih banyak serat dan mineral. Telur adalah sumber protein lengkap yang murah dan terjangkau. Ikan salmon kaya akan omega-3 yang baik untuk kesehatan jantung. Buah-buahan berwarna cerah seperti blueberry mengandung antioksidan tinggi. Hindari makanan olahan dan gula tambahan sebanyak mungkin. Fokus pada whole foods (makanan alami) untuk hasil maksimal.',
                'category' => 'nutrition',
                'author_id' => $admin->id,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Program Latihan Strength Training untuk Pemula',
                'excerpt' => 'Ingin memulai strength training? Panduan ini akan membantu Anda memulai dengan aman dan efektif.',
                'content' => 'Strength training atau latihan beban adalah cara terbaik untuk membangun otot dan meningkatkan metabolisme. Sebagai pemula, mulai dengan beban yang ringan agar Anda dapat mempelajari teknik yang benar. Latihan compound seperti squat, deadlift, dan bench press sangat efektif karena melibatkan banyak kelompok otot. Istirahat 48 jam antara sesi latihan otot yang sama untuk memungkinkan pemulihan optimal. Konsumsi protein yang cukup (1,6-2,2g per kg berat badan) untuk mendukung pertumbuhan otot. Fokus pada peningkatan progresif dengan menambah beban atau repetisi secara bertahap. Jangan terburu-buru, kesabaran dan konsistensi adalah kunci kesuksesan.',
                'category' => 'workout',
                'author_id' => $admin->id,
                'published_at' => now(),
            ],
        ];

        foreach ($articles as $article) {
            $article['slug'] = Str::slug($article['title']);
            Article::create($article);
        }
    }
}

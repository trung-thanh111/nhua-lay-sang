<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JapaneseLesson;
use App\Models\JapaneseVocabulary;
use App\Models\JapaneseGrammar;
use App\Models\JapaneseKanji;
use App\Models\JapaneseJlptQuestion;

class JapaneseSampleSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. MINNA NO NIHONGO LESSONS (Bài 1, 2, 3)
        // ==========================================
        $lessonsData = [
            [
                'code' => 'minna-bai-01',
                'title' => 'Bài 1: Giới thiệu bản thân (自己紹介)',
                'category' => 'minna',
                'level' => 'N5',
                'lesson_number' => 1,
                'audio_url' => 'https://res.cloudinary.com/demo/video/upload/sample_audio.mp3',
                'description' => 'Học các mẫu câu cơ bản để giới thiệu bản thân, quốc tịch, nghề nghiệp và tuổi tác.',
                'kaiwa_content' => "SANTOSU: 初めまして。サントスです。ブラジルから来ました。どうぞよろしく。\nYAMADA: 山田です。どうぞよろしく。",
                'publish' => 2,
            ],
            [
                'code' => 'minna-bai-02',
                'title' => 'Bài 2: Đồ vật xung quanh (これ・それ・あれ)',
                'category' => 'minna',
                'level' => 'N5',
                'lesson_number' => 2,
                'audio_url' => 'https://res.cloudinary.com/demo/video/upload/sample_audio.mp3',
                'description' => 'Học cách chỉ định đồ vật xung quanh với これ, それ, あれ, この, その, あの và sở hữu の.',
                'kaiwa_content' => "YAMADA: これは何ですか。\nSANTOSU: それは日本の本です。\nYAMADA: ありがとうございます。",
                'publish' => 2,
            ],
            [
                'code' => 'minna-bai-03',
                'title' => 'Bài 3: Địa điểm & Nơi chốn (ここ・そこ・あそこ)',
                'category' => 'minna',
                'level' => 'N5',
                'lesson_number' => 3,
                'audio_url' => 'https://res.cloudinary.com/demo/video/upload/sample_audio.mp3',
                'description' => 'Học cách hỏi và chỉ đường, vị trí đồ vật, phòng ốc và giá cả hàng hóa.',
                'kaiwa_content' => "SANTOSU: すみません、トイレはどこですか。\nCLERK: あそこです。\nSANTOSU: どうも。",
                'publish' => 2,
            ],
        ];

        $lessons = [];
        foreach ($lessonsData as $data) {
            $lessons[$data['lesson_number']] = JapaneseLesson::updateOrCreate(['code' => $data['code']], $data);
        }

        // ==========================================
        // 2. TỪ VỰNG (VOCABULARY)
        // ==========================================
        $vocabs = [
            // Bài 1
            ['lesson_number' => 1, 'word' => 'わたし', 'kanji' => '私', 'romaji' => 'watashi', 'meaning' => 'Tôi', 'word_type' => 'Đại từ', 'example_sentence' => 'わたしはアンです。', 'example_meaning' => 'Tôi là An.'],
            ['lesson_number' => 1, 'word' => 'あなた', 'kanji' => null, 'romaji' => 'anata', 'meaning' => 'Bạn, anh/chị', 'word_type' => 'Đại từ', 'example_sentence' => 'あなたはがくせいですか。', 'example_meaning' => 'Bạn có phải là học sinh không?'],
            ['lesson_number' => 1, 'word' => 'せんせい', 'kanji' => '先生', 'romaji' => 'sensei', 'meaning' => 'Thầy/Cô giáo', 'word_type' => 'Danh từ', 'example_sentence' => 'たなかさんはせんせいです。', 'example_meaning' => 'Anh Tanaka là giáo viên.'],
            ['lesson_number' => 1, 'word' => 'がくせい', 'kanji' => '学生', 'romaji' => 'gakusei', 'meaning' => 'Học sinh, sinh viên', 'word_type' => 'Danh từ', 'example_sentence' => 'わたしはがくせいです。', 'example_meaning' => 'Tôi là học sinh.'],
            ['lesson_number' => 1, 'word' => 'にほんじん', 'kanji' => '日本人', 'romaji' => 'nihonjin', 'meaning' => 'Người Nhật Bản', 'word_type' => 'Danh từ', 'example_sentence' => 'やまださんはにほんじんです。', 'example_meaning' => 'Anh Yamada là người Nhật.'],

            // Bài 2
            ['lesson_number' => 2, 'word' => 'これ', 'kanji' => null, 'romaji' => 'kore', 'meaning' => 'Cái này (gần người nói)', 'word_type' => 'Chỉ định từ', 'example_sentence' => 'これはじしょです。', 'example_meaning' => 'Đây là quyển từ điển.'],
            ['lesson_number' => 2, 'word' => 'それ', 'kanji' => null, 'romaji' => 'sore', 'meaning' => 'Cái đó (gần người nghe)', 'word_type' => 'Chỉ định từ', 'example_sentence' => 'それは傘ですか。', 'example_meaning' => 'Đó có phải là cái ô không?'],
            ['lesson_number' => 2, 'word' => 'あれ', 'kanji' => null, 'romaji' => 'are', 'meaning' => 'Cái kia (xa cả hai)', 'word_type' => 'Chỉ định từ', 'example_sentence' => 'あれは車です。', 'example_meaning' => 'Kia là ô tô.'],
            ['lesson_number' => 2, 'word' => 'ほん', 'kanji' => '本', 'romaji' => 'hon', 'meaning' => 'Quyển sách', 'word_type' => 'Danh từ', 'example_sentence' => 'これはにほんごのほんです。', 'example_meaning' => 'Đây là sách tiếng Nhật.'],
            ['lesson_number' => 2, 'word' => 'じしょ', 'kanji' => '辞書', 'romaji' => 'jisho', 'meaning' => 'Từ điển', 'word_type' => 'Danh từ', 'example_sentence' => 'このじしょはいいです。', 'example_meaning' => 'Cuốn từ điển này rất tốt.'],

            // Bài 3
            ['lesson_number' => 3, 'word' => 'ここ', 'kanji' => null, 'romaji' => 'koko', 'meaning' => 'Chỗ này, đây', 'word_type' => 'Chỉ định vị trí', 'example_sentence' => 'ここはきょうしつです。', 'example_meaning' => 'Đây là phòng học.'],
            ['lesson_number' => 3, 'word' => 'そこ', 'kanji' => null, 'romaji' => 'soko', 'meaning' => 'Chỗ đó, đó', 'word_type' => 'Chỉ định vị trí', 'example_sentence' => 'そこはしょくどうです。', 'example_meaning' => 'Đó là nhà ăn.'],
            ['lesson_number' => 3, 'word' => 'あそこ', 'kanji' => null, 'romaji' => 'asoko', 'meaning' => 'Chỗ kia, kia', 'word_type' => 'Chỉ định vị trí', 'example_sentence' => 'あそこはうけつけです。', 'example_meaning' => 'Kia là quầy lễ tân.'],
            ['lesson_number' => 3, 'word' => 'どこ', 'kanji' => null, 'romaji' => 'doko', 'meaning' => 'Ở đâu (nghi vấn)', 'word_type' => 'Nghi vấn từ', 'example_sentence' => 'おてあらいはどこですか。', 'example_meaning' => 'Nhà vệ sinh ở đâu ạ?'],
            ['lesson_number' => 3, 'word' => 'きょうしつ', 'kanji' => '教室', 'romaji' => 'kyoushitsu', 'meaning' => 'Phòng học, lớp học', 'word_type' => 'Danh từ', 'example_sentence' => 'きょうしつは２かいです。', 'example_meaning' => 'Lớp học ở tầng 2.'],
        ];

        foreach ($vocabs as $item) {
            $lessonId = $lessons[$item['lesson_number']]->id;
            unset($item['lesson_number']);
            JapaneseVocabulary::updateOrCreate(
                ['lesson_id' => $lessonId, 'word' => $item['word']],
                array_merge($item, ['level' => 'N5'])
            );
        }

        // ==========================================
        // 3. NGỮ PHÁP (GRAMMAR)
        // ==========================================
        $grammars = [
            // Bài 1
            [
                'lesson_number' => 1,
                'title' => 'Khẳng định: N1 は N2 です',
                'structure' => 'N1 [Danh từ 1] + は + N2 [Danh từ 2] + です',
                'meaning' => 'N1 là N2',
                'explanation' => '「は」là trợ từ chỉ chủ đề của câu (đọc là WA). 「です」đặt ở cuối câu để biểu thị phán đoán lịch sự.',
                'examples' => [
                    ['ja' => 'わたしはマイク・ミラーです。', 'vi' => 'Tôi là Mike Miller.'],
                    ['ja' => 'サントスさんはブラジルじんです。', 'vi' => 'Anh Santos là người Brazil.'],
                ],
            ],
            [
                'lesson_number' => 1,
                'title' => 'Phủ định: N1 は N2 じゃありません',
                'structure' => 'N1 は N2 じゃ（では）ありません',
                'meaning' => 'N1 không phải là N2',
                'explanation' => 'Dạng phủ định của 「です」. Văn nói dùng 「じゃありません」, văn viết dùng 「ではありません」.',
                'examples' => [
                    ['ja' => 'サントスさんはがくせいじゃありません。', 'vi' => 'Anh Santos không phải là sinh viên.'],
                ],
            ],
            // Bài 2
            [
                'lesson_number' => 2,
                'title' => 'Chỉ định đồ vật: これ / それ / あれ は N です',
                'structure' => 'これ / それ / あれ + は + N + です',
                'meaning' => 'Cái này / Cái đó / Cái kia là N',
                'explanation' => 'これ: gần người nói. それ: gần người nghe. あれ: xa cả hai người.',
                'examples' => [
                    ['ja' => 'これはじしょです。', 'vi' => 'Đây là cuốn từ điển.'],
                    ['ja' => 'それはだれの傘ですか。', 'vi' => 'Đó là cái ô của ai thế?'],
                ],
            ],
            // Bài 3
            [
                'lesson_number' => 3,
                'title' => 'Chỉ định địa điểm: N [Địa điểm] は ここ / そこ / あそこ です',
                'structure' => 'N (Địa điểm) + は + ここ / そこ / あそこ です',
                'meaning' => 'N ở chỗ này / chỗ đó / chỗ kia',
                'explanation' => 'Dùng để diễn đạt vị trí nơi chốn, phòng ốc hoặc trụ sở.',
                'examples' => [
                    ['ja' => 'おてあらいはあそこです。', 'vi' => 'Nhà vệ sinh ở đằng kia.'],
                    ['ja' => 'じむしょはここです。', 'vi' => 'Văn phòng ở đây.'],
                ],
            ],
        ];

        foreach ($grammars as $item) {
            $lessonId = $lessons[$item['lesson_number']]->id;
            unset($item['lesson_number']);
            JapaneseGrammar::updateOrCreate(
                ['lesson_id' => $lessonId, 'title' => $item['title']],
                array_merge($item, ['level' => 'N5'])
            );
        }

        // ==========================================
        // 4. BỘ HÁN TỰ KANJI N5
        // ==========================================
        $kanjis = [
            ['character' => '日', 'hanviet' => 'NHẬT', 'onyomi' => 'NICHI, JITSU', 'kunyomi' => 'hi, bi, ka', 'strokes' => 4, 'radical' => '日 (Nhật)', 'meaning' => 'Mặt trời, ngày', 'compound_words' => [['word' => '日本', 'meaning' => 'Nhật Bản'], ['word' => '日曜日', 'meaning' => 'Chủ nhật']]],
            ['character' => '月', 'hanviet' => 'NGUYỆT', 'onyomi' => 'GETSU, GATSU', 'kunyomi' => 'tsuki', 'strokes' => 4, 'radical' => '月 (Nguyệt)', 'meaning' => 'Mặt trăng, tháng', 'compound_words' => [['word' => '月曜日', 'meaning' => 'Thứ hai'], ['word' => '一月', 'meaning' => 'Tháng 1']]],
            ['character' => '火', 'hanviet' => 'HỎA', 'onyomi' => 'KA', 'kunyomi' => 'hi', 'strokes' => 4, 'radical' => '火 (Hỏa)', 'meaning' => 'Lửa', 'compound_words' => [['word' => '火曜日', 'meaning' => 'Thứ ba'], ['word' => '火事', 'meaning' => 'Hỏa hoạn']]],
            ['character' => '水', 'hanviet' => 'THỦY', 'onyomi' => 'SUI', 'kunyomi' => 'mizu', 'strokes' => 4, 'radical' => '水 (Thủy)', 'meaning' => 'Nước', 'compound_words' => [['word' => '水曜日', 'meaning' => 'Thứ tư'], ['word' => '水泳', 'meaning' => 'Bơi lội']]],
            ['character' => '木', 'hanviet' => 'MỘC', 'onyomi' => 'MOKU, BOKU', 'kunyomi' => 'ki', 'strokes' => 4, 'radical' => '木 (Mộc)', 'meaning' => 'Cây, gỗ', 'compound_words' => [['word' => '木曜日', 'meaning' => 'Thứ năm'], ['word' => '大木', 'meaning' => 'Cây lớn']]],
            ['character' => '金', 'hanviet' => 'KIM', 'onyomi' => 'KIN, KON', 'kunyomi' => 'kane', 'strokes' => 8, 'radical' => '金 (Kim)', 'meaning' => 'Vàng, tiền', 'compound_words' => [['word' => '金曜日', 'meaning' => 'Thứ sáu'], ['word' => 'お金', 'meaning' => 'Tiền bạc']]],
            ['character' => '土', 'hanviet' => 'THỔ', 'onyomi' => 'DO, TO', 'kunyomi' => 'tsuchi', 'strokes' => 3, 'radical' => '土 (Thổ)', 'meaning' => 'Đất', 'compound_words' => [['word' => '土曜日', 'meaning' => 'Thứ bảy'], ['word' => '土地', 'meaning' => 'Đất đai']]],
            ['character' => '本', 'hanviet' => 'BẢN', 'onyomi' => 'HON', 'kunyomi' => 'moto', 'strokes' => 5, 'radical' => '木 (Mộc)', 'meaning' => 'Sách, gốc rễ', 'compound_words' => [['word' => '本', 'meaning' => 'Sách'], ['word' => '日本語', 'meaning' => 'Tiếng Nhật']]],
            ['character' => '人', 'hanviet' => 'NHÂN', 'onyomi' => 'JIN, NIN', 'kunyomi' => 'hito', 'strokes' => 2, 'radical' => '人 (Nhân)', 'meaning' => 'Người', 'compound_words' => [['word' => '日本人', 'meaning' => 'Người Nhật'], ['word' => '大人', 'meaning' => 'Người lớn']]],
            ['character' => '学', 'hanviet' => 'HỌC', 'onyomi' => 'GAKU', 'kunyomi' => 'mana(bu)', 'strokes' => 8, 'radical' => '子 (Tử)', 'meaning' => 'Học tập', 'compound_words' => [['word' => '学生', 'meaning' => 'Học sinh'], ['word' => '大学', 'meaning' => 'Đại học']]],
            ['character' => '生', 'hanviet' => 'SINH', 'onyomi' => 'SEI, SHOU', 'kunyomi' => 'i(kiru), u(mareru)', 'strokes' => 5, 'radical' => '生 (Sinh)', 'meaning' => 'Sinh ra, sống', 'compound_words' => [['word' => '先生', 'meaning' => 'Thầy giáo'], ['word' => '誕生日', 'meaning' => 'Sinh nhật']]],
            ['character' => '先', 'hanviet' => 'TIÊN', 'onyomi' => 'SEN', 'kunyomi' => 'saki', 'strokes' => 6, 'radical' => '儿 (Nhi)', 'meaning' => 'Trước', 'compound_words' => [['word' => '先生', 'meaning' => 'Giáo viên'], ['word' => '先週', 'meaning' => 'Tuần trước']]],
        ];

        foreach ($kanjis as $k) {
            JapaneseKanji::updateOrCreate(['character' => $k['character']], array_merge($k, ['level' => 'N5']));
        }

        // ==========================================
        // 5. CÂU HỎI THI THỬ JLPT
        // ==========================================
        $questions = [
            [
                'level' => 'N5',
                'section' => 'grammar',
                'question' => 'わたしは＿＿＿ではありません。せんせいです。',
                'option_a' => 'がくせい',
                'option_b' => 'にほん',
                'option_c' => 'なまえ',
                'option_d' => 'ほん',
                'correct_option' => 'A',
                'explanation' => 'Vế sau là "せんせいです" (Tôi là giáo viên) nên vế trước phủ định là "Tôi không phải học sinh" (がくせい).',
            ],
            [
                'level' => 'N5',
                'section' => 'vocabulary',
                'question' => 'これは「本」です。Chữ trong ngoặc đọc là gì?',
                'option_a' => 'ほん',
                'option_b' => 'き',
                'option_c' => 'ひと',
                'option_d' => 'みず',
                'correct_option' => 'A',
                'explanation' => 'Chữ 「本」 (BẢN) có âm đọc Kunyomi/Onyomi thông dụng là ほん (sách).',
            ],
            [
                'level' => 'N5',
                'section' => 'grammar',
                'question' => 'ミラーさんはアメリカ＿＿＿です。',
                'option_a' => 'ひと',
                'option_b' => 'じん',
                'option_c' => 'さん',
                'option_d' => 'くん',
                'correct_option' => 'B',
                'explanation' => 'Để nói quốc tịch: [Tên nước] + じん (nhân). Người Mỹ là アメリカじん.',
            ],
            [
                'level' => 'N5',
                'section' => 'reading',
                'question' => 'たなかさん：「あそこはきょうしつですか。」\nすずきさん：「いいえ、あそこは＿＿＿です。」',
                'option_a' => 'しょくどう',
                'option_b' => 'なん',
                'option_c' => 'だれ',
                'option_d' => 'どれ',
                'correct_option' => 'A',
                'explanation' => 'Phủ định lớp học và chỉ ra địa điểm thực tế là "nhà ăn" (しょくどう).',
            ],
        ];

        foreach ($questions as $q) {
            JapaneseJlptQuestion::updateOrCreate(['question' => $q['question']], $q);
        }
    }
}

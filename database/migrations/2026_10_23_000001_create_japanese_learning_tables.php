<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Bài học (Minna no Nihongo 50 bài, JLPT levels)
        Schema::create('japanese_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // vd: minna-bai-01, jlpt-n5-bai-01
            $table->string('title'); // Bài 1: Giới thiệu bản thân
            $table->string('category')->default('minna'); // minna, jlpt, conversation
            $table->string('level', 10)->default('N5'); // N5, N4, N3, N2, N1
            $table->integer('lesson_number')->default(1);
            $table->string('audio_url')->nullable();
            $table->text('description')->nullable();
            $table->longText('kaiwa_content')->nullable(); // Nội dung hội thoại
            $table->longText('mondai_content')->nullable(); // Bài tập Mondai
            $table->tinyInteger('publish')->default(2); // 2: publish, 1: draft
            $table->timestamps();
        });

        // 2. Từ vựng (Vocabulary)
        Schema::create('japanese_vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained('japanese_lessons')->nullOnDelete();
            $table->string('word'); // わたし, がくせい
            $table->string('kanji')->nullable(); // 私, 学生
            $table->string('romaji')->nullable(); // watashi, gakusei
            $table->string('meaning'); // Tôi, Học sinh
            $table->string('word_type')->nullable(); // Danh từ, Động từ nhóm 1...
            $table->string('audio_url')->nullable();
            $table->text('example_sentence')->nullable(); // わたしはベトナムじんです。
            $table->text('example_meaning')->nullable(); // Tôi là người Việt Nam.
            $table->string('level', 10)->default('N5');
            $table->timestamps();
        });

        // 3. Ngữ pháp (Grammar)
        Schema::create('japanese_grammars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained('japanese_lessons')->nullOnDelete();
            $table->string('title'); // ~ は ~ です
            $table->string('structure'); // N1 は N2 です
            $table->text('meaning'); // N1 là N2
            $table->longText('explanation')->nullable(); // Giải thích cách dùng chi tiết
            $table->json('examples')->nullable(); // Mảng ví dụ câu tiếng Nhật + Furigana + Dịch
            $table->string('level', 10)->default('N5');
            $table->timestamps();
        });

        // 4. Hán tự (Kanji & 214 Bộ thủ)
        Schema::create('japanese_kanjis', function (Blueprint $table) {
            $table->id();
            $table->string('character', 10)->unique(); // 日, 本, 人
            $table->string('hanviet'); // NHẬT, BẢN, NHÂN
            $table->string('onyomi')->nullable(); // NICHI, JITSU
            $table->string('kunyomi')->nullable(); // hi, bi, ka
            $table->integer('strokes')->default(1); // Số nét
            $table->string('radical', 20)->nullable(); // Bộ thủ
            $table->text('meaning'); // Ngày, mặt trời
            $table->text('stroke_svg')->nullable(); // SVG đường nét viết (KanjiVG)
            $table->json('compound_words')->nullable(); // Từ ghép chứa chữ Hán
            $table->string('level', 10)->default('N5');
            $table->timestamps();
        });

        // 5. Ngân hàng câu hỏi trắc nghiệm & Luyện thi JLPT
        Schema::create('japanese_jlpt_questions', function (Blueprint $table) {
            $table->id();
            $table->string('level', 10); // N5, N4, N3, N2, N1
            $table->string('section', 30); // vocabulary, grammar, reading, listening
            $table->text('question'); // Nội dung câu hỏi
            $table->string('audio_url')->nullable(); // File nghe nếu là section listening
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d')->nullable();
            $table->string('correct_option', 5); // A, B, C, D
            $table->text('explanation')->nullable(); // Giải thích đáp án (AI / giáo viên)
            $table->timestamps();
        });

        // 6. Thuật toán Flashcard ngắt quãng SRS (Spaced Repetition - SM-2)
        Schema::create('japanese_srs_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // Khách học (bảng customers)
            $table->string('card_type', 20); // vocabulary, kanji, grammar
            $table->unsignedBigInteger('item_id'); // ID của từ vựng / kanji tương ứng
            $table->integer('repetitions')->default(0); // Số lần đã ôn tập
            $table->float('ease_factor')->default(2.5); // Hệ số dễ theo SM-2
            $table->integer('interval_days')->default(1); // Số ngày đến lần ôn tiếp theo
            $table->timestamp('due_date')->useCurrent(); // Ngày cần ôn tập lại
            $table->timestamps();

            $table->index(['customer_id', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('japanese_srs_cards');
        Schema::dropIfExists('japanese_jlpt_questions');
        Schema::dropIfExists('japanese_kanjis');
        Schema::dropIfExists('japanese_grammars');
        Schema::dropIfExists('japanese_vocabularies');
        Schema::dropIfExists('japanese_lessons');
    }
};

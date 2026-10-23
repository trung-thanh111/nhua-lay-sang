<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lesson->title }} - Minna no Nihongo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .jp-font { font-family: 'Noto Sans JP', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('japanese.index') }}" class="text-xl font-black bg-gradient-to-r from-red-600 to-rose-500 bg-clip-text text-transparent jp-font">日本語</a>
                <span class="text-sm font-semibold text-slate-400">/</span>
                <span class="text-sm font-bold text-slate-900 truncate max-w-xs sm:max-w-md">{{ $lesson->title }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <select onchange="window.location.href=this.value" class="text-xs font-semibold bg-slate-100 border border-slate-300 rounded-lg px-2.5 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-500">
                    @foreach($allLessons as $l)
                        <option value="{{ route('japanese.lesson', $l->code) }}" {{ $l->id === $lesson->id ? 'selected' : '' }}>
                            Bài {{ $l->lesson_number }}: {{ Str::limit($l->title, 25) }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('japanese.index') }}" class="text-xs font-bold text-slate-600 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Quay lại</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Lesson Banner -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 mb-8 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2.5 py-0.5 bg-red-600 text-white text-xs font-bold rounded-md">BÀI {{ $lesson->lesson_number }}</span>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-md uppercase">{{ $lesson->level }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $lesson->title }}</h1>
                    <p class="text-slate-500 text-sm mt-1">{{ $lesson->description }}</p>
                </div>
                @if($lesson->audio_url)
                    <div class="flex items-center space-x-2 bg-slate-100 px-4 py-2 rounded-xl">
                        <span class="text-xs font-bold text-slate-600">Audio bài học:</span>
                        <audio controls class="h-8 max-w-[200px] sm:max-w-[250px]">
                            <source src="{{ $lesson->audio_url }}" type="audio/mpeg">
                        </audio>
                    </div>
                @endif
            </div>

            <!-- Navigation Tabs -->
            <div class="flex space-x-2 border-b border-slate-200 mt-6 pt-2">
                <button onclick="switchTab('vocab')" id="tab-btn-vocab" class="tab-btn pb-3 px-4 font-bold text-sm border-b-2 border-red-600 text-red-600">Từ vựng ({{ count($lesson->vocabularies) }})</button>
                <button onclick="switchTab('grammar')" id="tab-btn-grammar" class="tab-btn pb-3 px-4 font-semibold text-sm border-b-2 border-transparent text-slate-500 hover:text-slate-800">Ngữ pháp ({{ count($lesson->grammars) }})</button>
                <button onclick="switchTab('kaiwa')" id="tab-btn-kaiwa" class="tab-btn pb-3 px-4 font-semibold text-sm border-b-2 border-transparent text-slate-500 hover:text-slate-800">Hội thoại (Kaiwa)</button>
                <button onclick="switchTab('flashcard')" id="tab-btn-flashcard" class="tab-btn pb-3 px-4 font-semibold text-sm border-b-2 border-transparent text-slate-500 hover:text-slate-800">SRS Flashcard</button>
            </div>
        </div>

        <!-- TAB 1: TỪ VỰNG -->
        <div id="tab-vocab" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($lesson->vocabularies as $v)
                    <div class="bg-white rounded-xl border border-slate-200 p-4 hover:border-slate-300 transition flex items-start justify-between">
                        <div>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-2xl font-bold text-slate-900 jp-font">{{ $v->word }}</span>
                                @if($v->kanji)
                                    <span class="text-sm font-semibold text-slate-500 jp-font">【{{ $v->kanji }}】</span>
                                @endif
                                @if($v->romaji)
                                    <span class="text-xs text-slate-400">/{{ $v->romaji }}/</span>
                                @endif
                            </div>
                            <div class="text-sm font-semibold text-red-600 mt-1">{{ $v->meaning }}</div>
                            @if($v->example_sentence)
                                <div class="mt-3 p-2.5 bg-slate-50 rounded-lg text-xs border border-slate-100">
                                    <div class="font-medium text-slate-800 jp-font">{{ $v->example_sentence }}</div>
                                    <div class="text-slate-500 mt-0.5">{{ $v->example_meaning }}</div>
                                </div>
                            @endif
                        </div>
                        <button onclick="speakJapanese('{{ $v->word }}')" title="Phát âm" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 2: NGỮ PHÁP -->
        <div id="tab-grammar" class="tab-content hidden space-y-6">
            @foreach($lesson->grammars as $g)
                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <span class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-extrabold rounded-md">{{ $loop->iteration }}</span>
                        <h3 class="text-lg font-bold text-slate-900">{{ $g->title }}</h3>
                    </div>
                    <div class="p-3 bg-red-50/60 border border-red-200/60 rounded-xl mb-4">
                        <div class="text-xs font-semibold text-red-800 uppercase tracking-wider mb-1">Cấu trúc:</div>
                        <div class="text-sm font-bold text-slate-900 jp-font">{{ $g->structure }}</div>
                        <div class="text-xs font-medium text-slate-600 mt-1">Ý nghĩa: {{ $g->meaning }}</div>
                    </div>
                    @if($g->explanation)
                        <div class="text-sm text-slate-700 leading-relaxed mb-4 whitespace-pre-line">{{ $g->explanation }}</div>
                    @endif
                    @if(!empty($g->examples))
                        <div class="space-y-2">
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ví dụ minh họa:</div>
                            @foreach($g->examples as $ex)
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 jp-font">{{ $ex['ja'] ?? '' }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $ex['vi'] ?? '' }}</div>
                                    </div>
                                    <button onclick="speakJapanese('{{ $ex['ja'] ?? '' }}')" class="text-slate-400 hover:text-red-600 p-1.5 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- TAB 3: HỘI THOẠI (KAIWA) -->
        <div id="tab-kaiwa" class="tab-content hidden">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Hội thoại thực tế</h3>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 whitespace-pre-line text-sm leading-loose jp-font text-slate-800">
                    {{ $lesson->kaiwa_content ?: 'Đang cập nhật nội dung hội thoại...' }}
                </div>
            </div>
        </div>

        <!-- TAB 4: SRS FLASHCARD -->
        <div id="tab-flashcard" class="tab-content hidden">
            <div class="max-w-xl mx-auto">
                <div id="card-box" class="bg-white rounded-3xl border-2 border-slate-200 p-10 min-h-[280px] flex flex-col justify-center items-center text-center shadow-lg relative cursor-pointer select-none transition" onclick="flipCard()">
                    <div id="card-front" class="space-y-3">
                        <div id="fc-word" class="text-4xl font-extrabold text-slate-900 jp-font">わたし</div>
                        <div id="fc-hint" class="text-xs text-slate-400">(Bấm vào thẻ để lật xem nghĩa)</div>
                    </div>
                    <div id="card-back" class="hidden space-y-3">
                        <div id="fc-meaning" class="text-3xl font-extrabold text-red-600">Tôi</div>
                        <div id="fc-kanji" class="text-sm font-semibold text-slate-500 jp-font">Hán tự: 私</div>
                    </div>
                </div>

                <!-- SRS Review Buttons -->
                <div class="grid grid-cols-3 gap-3 mt-6">
                    <button onclick="submitSrs(1)" class="py-3 bg-red-100 hover:bg-red-200 text-red-800 font-bold rounded-xl text-sm transition">Khó (1 ngày)</button>
                    <button onclick="submitSrs(3)" class="py-3 bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold rounded-xl text-sm transition">Nhớ (3 ngày)</button>
                    <button onclick="submitSrs(5)" class="py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold rounded-xl text-sm transition">Dễ (6 ngày)</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        const vocabs = @json($lesson->vocabularies);
        let currentIndex = 0;
        let isFlipped = false;

        function switchTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('border-red-600', 'text-red-600');
                el.classList.add('border-transparent', 'text-slate-500');
            });
            document.getElementById('tab-' + tab).classList.remove('hidden');
            const btn = document.getElementById('tab-btn-' + tab);
            btn.classList.add('border-red-600', 'text-red-600');
            btn.classList.remove('border-transparent', 'text-slate-500');

            if (tab === 'flashcard' && vocabs.length > 0) {
                renderCard();
            }
        }

        function speakJapanese(text) {
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'ja-JP';
                utterance.rate = 0.9;
                window.speechSynthesis.speak(utterance);
            }
        }

        function renderCard() {
            if (!vocabs[currentIndex]) return;
            const item = vocabs[currentIndex];
            document.getElementById('fc-word').innerText = item.word;
            document.getElementById('fc-meaning').innerText = item.meaning;
            document.getElementById('fc-kanji').innerText = item.kanji ? 'Hán tự: ' + item.kanji : '';
            isFlipped = false;
            document.getElementById('card-front').classList.remove('hidden');
            document.getElementById('card-back').classList.add('hidden');
        }

        function flipCard() {
            isFlipped = !isFlipped;
            document.getElementById('card-front').classList.toggle('hidden', isFlipped);
            document.getElementById('card-back').classList.toggle('hidden', !isFlipped);
        }

        function submitSrs(quality) {
            if (!vocabs[currentIndex]) return;
            const item = vocabs[currentIndex];

            fetch('{{ route("japanese.srs.review") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    card_type: 'vocabulary',
                    item_id: item.id,
                    quality: quality
                })
            }).then(() => {
                currentIndex = (currentIndex + 1) % vocabs.length;
                renderCard();
            });
        }
    </script>
</body>
</html>

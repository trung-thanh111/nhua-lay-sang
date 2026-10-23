<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luyện Thi JLPT {{ $level }} Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .jp-font { font-family: 'Noto Sans JP', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen pb-16">
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('japanese.index') }}" class="text-xl font-black text-red-600 jp-font">日本語</a>
                <span class="text-sm font-semibold text-slate-400">/</span>
                <span class="text-sm font-bold text-slate-900">Luyện Thi JLPT {{ $level }}</span>
            </div>
            <div class="flex items-center space-x-3">
                <span id="timer" class="px-3 py-1 bg-red-100 text-red-700 font-mono font-bold text-xs rounded-lg">20:00</span>
                <a href="{{ route('japanese.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">Thoát</a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <form id="jlpt-form" onsubmit="submitExam(event)" class="space-y-6">
            @forelse($questions as $index => $q)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm question-card" id="q-box-{{ $q->id }}">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-extrabold rounded-md">Câu {{ $loop->iteration }}</span>
                        <span class="text-xs text-slate-400 uppercase font-semibold">[{{ $q->section }}]</span>
                    </div>
                    <div class="text-base font-bold text-slate-900 jp-font mb-4 leading-relaxed">{{ $q->question }}</div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $optKey => $optVal)
                            @if($optVal)
                                <label class="flex items-center space-x-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition opt-label-{{ $q->id }}-{{ $optKey }}">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $optKey }}" class="text-red-600 focus:ring-red-500">
                                    <span class="text-xs font-bold text-slate-400">{{ $optKey }}.</span>
                                    <span class="text-sm text-slate-800 jp-font">{{ $optVal }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <div id="explanation-{{ $q->id }}" class="hidden mt-4 p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-900"></div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-2xl border border-dashed border-slate-300 text-slate-500">
                    Chưa có câu hỏi cho phần này.
                </div>
            @endforelse

            @if(count($questions) > 0)
                <div class="sticky bottom-4 z-40 bg-white/90 backdrop-blur border border-slate-200 p-4 rounded-2xl shadow-xl flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-medium">Tổng: {{ count($questions) }} câu hỏi</span>
                    <button type="submit" id="submit-btn" class="px-8 py-2.5 bg-red-600 hover:bg-red-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-red-600/30 transition">
                        Nộp bài & Chấm điểm
                    </button>
                </div>
            @endif
        </form>

        <div id="result-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl p-8 max-w-md w-full text-center shadow-2xl">
                <div class="text-5xl font-black text-red-600 mb-2" id="score-text">0/0</div>
                <div class="text-sm font-semibold text-slate-600 mb-6" id="percentage-text">Tỷ lệ chính xác: 0%</div>
                <button onclick="document.getElementById('result-modal').classList.add('hidden')" class="w-full py-3 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm rounded-xl transition">
                    Xem lại lời giải chi tiết
                </button>
            </div>
        </div>
    </main>

    <script>
        function submitExam(e) {
            e.preventDefault();
            const form = document.getElementById('jlpt-form');
            const formData = new FormData(form);
            const answers = {};

            for (let [key, val] of formData.entries()) {
                const match = key.match(/answers\[(\d+)\]/);
                if (match) {
                    answers[match[1]] = val;
                }
            }

            fetch('{{ route("japanese.jlpt.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ answers: answers })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('score-text').innerText = `${data.score}/${data.total}`;
                document.getElementById('percentage-text').innerText = `Tỷ lệ chính xác: ${data.percentage}%`;
                document.getElementById('result-modal').classList.remove('hidden');

                data.results.forEach(res => {
                    const box = document.getElementById(`explanation-${res.id}`);
                    if (box) {
                        box.classList.remove('hidden');
                        box.innerHTML = `<strong>Đáp án đúng: ${res.correct_option}</strong>. ${res.explanation || ''}`;
                    }
                });
            });
        }
    </script>
</body>
</html>

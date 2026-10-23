<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Tiếng Nhật Minna No Nihongo & JLPT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .jp-font { font-family: 'Noto Sans JP', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl font-black bg-gradient-to-r from-red-600 to-rose-500 bg-clip-text text-transparent jp-font">日本語</span>
                <span class="text-sm font-semibold text-slate-500 border-l pl-3 border-slate-300">Minna & JLPT AI Master</span>
            </div>
            <nav class="flex items-center space-x-4">
                <a href="{{ route('japanese.index') }}" class="text-sm font-semibold text-red-600">Trang chủ</a>
                <a href="{{ route('japanese.kanji') }}" class="text-sm font-medium text-slate-600 hover:text-red-600 transition">Kanji</a>
                <a href="{{ route('japanese.jlpt') }}" class="text-sm font-medium text-slate-600 hover:text-red-600 transition">Thi thử JLPT</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-red-950 rounded-3xl p-8 sm:p-12 text-white shadow-xl mb-12 relative overflow-hidden">
            <div class="max-w-2xl relative z-10">
                <span class="inline-block px-3 py-1 bg-red-600/30 text-red-300 border border-red-500/40 rounded-full text-xs font-bold uppercase tracking-wider mb-4">E-Learning Tiếng Nhật Thế Hệ Mới</span>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4">Học tiếng Nhật toàn diện vượt trội</h1>
                <p class="text-slate-300 text-base sm:text-lg mb-8 leading-relaxed">Clone & nâng cấp toàn bộ tính năng Vnjpclub: 50 bài Minna no Nihongo, Kanji N5-N1 kèm nét vẽ, ngữ pháp thực chiến, thuật toán ôn tập ngắt quãng SRS và AI giải thích chi tiết.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#lessons" class="px-6 py-3 bg-red-600 hover:bg-red-500 font-bold rounded-xl shadow-lg shadow-red-600/30 transition">Vào 50 bài Minna</a>
                    <a href="{{ route('japanese.jlpt') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 font-bold rounded-xl backdrop-blur transition border border-white/20">Luyện thi JLPT N5-N1</a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bento -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Minna Bài học</div>
                <div class="text-3xl font-extrabold text-slate-900">{{ count($lessons) }} <span class="text-sm font-medium text-slate-400">/ 50</span></div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kho Từ vựng</div>
                <div class="text-3xl font-extrabold text-slate-900">{{ $vocabCount }} <span class="text-sm font-medium text-slate-400">từ</span></div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Chữ Hán Kanji</div>
                <div class="text-3xl font-extrabold text-slate-900">{{ $kanjiCount }} <span class="text-sm font-medium text-slate-400">chữ</span></div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Đề thi JLPT</div>
                <div class="text-3xl font-extrabold text-slate-900">{{ $questionCount }} <span class="text-sm font-medium text-slate-400">câu</span></div>
            </div>
        </div>

        <!-- Danh sách bài học Minna -->
        <div id="lessons">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Giáo trình Minna no Nihongo</h2>
                    <p class="text-sm text-slate-500">50 bài học tiếng Nhật chuẩn sơ cấp N5 - N4</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($lessons as $item)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-lg">Bài {{ $item->lesson_number }}</span>
                                <span class="text-xs font-semibold text-slate-400 uppercase">{{ $item->level }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-1">{{ $item->title }}</h3>
                            <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $item->description }}</p>
                        </div>
                        <a href="{{ route('japanese.lesson', $item->code) }}" class="w-full text-center py-2.5 bg-slate-900 hover:bg-red-600 text-white font-semibold text-sm rounded-xl transition">
                            Học bài này &rarr;
                        </a>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-dashed border-slate-300">
                        <p class="text-slate-500 mb-2">Chưa có bài học nào trong hệ thống.</p>
                        <p class="text-xs text-slate-400">Chạy Seeder để import bài học mẫu.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>

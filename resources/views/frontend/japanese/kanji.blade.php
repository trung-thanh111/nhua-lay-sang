<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Chữ Hán Kanji N5 - N1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .jp-font { font-family: 'Noto Sans JP', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('japanese.index') }}" class="text-xl font-black text-red-600 jp-font">日本語</a>
                <span class="text-sm font-semibold text-slate-400">/</span>
                <span class="text-sm font-bold text-slate-900">Tra cứu & Học Hán Tự (Kanji)</span>
            </div>
            <a href="{{ route('japanese.index') }}" class="text-xs font-bold text-slate-600 hover:text-red-600">Trang chủ</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Level Filter & Search -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
            <form method="GET" action="{{ route('japanese.kanji') }}" class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-2">
                    @foreach(['N5', 'N4', 'N3', 'N2', 'N1', 'all'] as $lvl)
                        <a href="{{ route('japanese.kanji', ['level' => $lvl]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $level === $lvl ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ strtoupper($lvl) }}
                        </a>
                    @endforeach
                </div>
                <div class="flex items-center space-x-2 w-full sm:w-auto">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm chữ Hán, Hán Việt..." class="px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-64">
                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs rounded-xl transition">Tìm</button>
                </div>
            </form>
        </div>

        <!-- Kanji Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($kanjis as $k)
                <div class="bg-white rounded-2xl border border-slate-200 p-4 text-center hover:border-red-500 hover:shadow-md transition group">
                    <div class="text-4xl font-extrabold text-slate-900 jp-font group-hover:text-red-600 transition mb-2">{{ $k->character }}</div>
                    <div class="text-xs font-bold text-red-600 uppercase">{{ $k->hanviet }}</div>
                    <div class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $k->meaning }}</div>
                    <div class="text-[11px] text-slate-400 mt-2 border-t border-slate-100 pt-2 flex justify-between">
                        <span>{{ $k->strokes }} nét</span>
                        <span>{{ $k->level }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-dashed border-slate-300 text-slate-500">
                    Chưa có chữ Kanji nào phù hợp.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $kanjis->links() }}
        </div>
    </main>
</body>
</html>

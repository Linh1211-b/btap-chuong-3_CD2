<article class="card overflow-hidden">
    <img src="{{ $course->image ? asset($course->image) : 'https://via.placeholder.com/640x360?text=No+Image' }}" alt="{{ $course->name }}" class="h-44 w-full object-cover" />
    <div class="p-5">
        <h3 class="text-xl font-semibold text-slate-900">{{ $course->name }}</h3>
        <p class="mt-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 120) }}</p>
        <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-slate-600">
            <span>Giá: <strong>{{ number_format($course->price, 0, ',', '.') }} ₫</strong></span>
            <span>|</span>
            <span>{{ $course->lessons_count ?? $course->lessons->count() }} bài học</span>
        </div>
        <div class="mt-4">
            <x-badge class="{{ $course->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                {{ ucfirst($course->status) }}
            </x-badge>
        </div>
    </div>
</article>

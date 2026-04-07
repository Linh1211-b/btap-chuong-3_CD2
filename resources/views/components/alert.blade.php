@if (session('success') || session('error') || $errors->any())
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        @if (session('success'))
            <div class="text-green-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="text-rose-700">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="space-y-1 text-sm text-slate-700">
                <p class="font-semibold">Có lỗi xảy ra:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

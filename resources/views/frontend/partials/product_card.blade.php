@php
    $img = (!empty($prod->images) && isset($prod->images[0]) && file_exists(public_path($prod->images[0])))
        ? asset($prod->images[0])
        : asset('images/logo.png');
@endphp
<div class="bg-white rounded-2xl border border-token overflow-hidden shadow-sm hover:shadow-xl hover:border-primary transition-all duration-300 flex flex-col justify-between h-full group">
    <div class="p-4">
        <!-- Image Box -->
        <div class="relative h-38 w-full bg-[var(--bg)] rounded-xl overflow-hidden mb-3 border border-token flex items-center justify-center p-3">
            <img src="{{ $img }}" alt="{{ $prod->name }}" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
            <span class="absolute top-2.5 right-2.5 bg-primary hover:bg-[var(--primary-dark)] backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm">
                {{ $prod->manufacturer->name ?? 'Industrial' }}
            </span>
        </div>

        <!-- Category -->
        <div class="text-[10px] font-bold text-primary uppercase tracking-wider mb-1">
            {{ $prod->category->name ?? 'Industrial Spare' }}
        </div>

        <!-- Title -->
        <h3 class="font-bold text-xs sm:text-sm text-[var(--text)] line-clamp-2 hover:text-primary transition mb-3 leading-snug min-h-[2.5rem]">
            <a href="{{ route('products.show', $prod->slug) }}">{{ $prod->name }}</a>
        </h3>

        <!-- Specs Badge Row -->
        <div class="flex flex-wrap gap-1.5 text-[11px] mb-3">
            <span class="spec-tag bg-[var(--bg)] text-[var(--text-muted)] px-2 py-0.5 rounded border border-token" title="Part Number">
                <strong class="font-sans text-[var(--text)]">P#:</strong> {{ $prod->part_number }}
            </span>
            <span class="spec-tag bg-[var(--bg)] text-[var(--text-muted)] px-2 py-0.5 rounded border border-token" title="Model Number">
                <strong class="font-sans text-[var(--text)]">M#:</strong> {{ $prod->model_number }}
            </span>
        </div>
    </div>

    <!-- Bottom Price & Action Row -->
    <div class="px-4 pb-4 pt-3 border-t border-token flex items-center justify-between mt-auto bg-[var(--bg)]/60">
        <div>
            <span class="text-[10px] text-[var(--text-muted)] font-medium block uppercase tracking-wider">Unit Price</span>
            <span class="text-sm sm:text-base font-extrabold text-[var(--primary-dark)]">£{{ number_format($prod->price, 2) }}</span>
        </div>

        <button onclick="addToRequest({{ $prod->id }}, '{{ addslashes($prod->name) }}', '{{ addslashes($prod->part_number) }}', {{ $prod->price }}, '{{ $img }}', this)" class="bg-primary hover:bg-[var(--primary-dark)] text-white text-xs font-bold px-3.5 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 shadow-md">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add Request</span>
        </button>
    </div>
</div>
@php
    // Frontend image and price hidden as requested
@endphp
<div class="bg-white rounded-2xl border border-token overflow-hidden shadow-sm hover:shadow-xl hover:border-primary transition-all duration-300 flex flex-col justify-between h-full group">
    <div class="p-4 sm:p-5">
        <!-- Category & Manufacturer Badges (Stacked vertically to prevent long-name overflow) -->
        <div class="mb-3 space-y-1.5">
            <div class="text-[10px] font-bold text-primary uppercase tracking-wider truncate">
                {{ $prod->category->name ?? 'Industrial Spare' }}
            </div>
            <div>
                <span class="inline-block bg-primary text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm max-w-full truncate" title="{{ $prod->manufacturer->name ?? 'Industrial' }}">
                    {{ $prod->manufacturer->name ?? 'Industrial' }}
                </span>
            </div>
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

    <!-- Bottom Action Row (Price removed as requested) -->
    <div class="px-4 pb-4 pt-3 border-t border-token flex items-center justify-end mt-auto bg-[var(--bg)]/60">
        <button onclick="addToRequest({{ $prod->id }}, '{{ addslashes($prod->name) }}', '{{ addslashes($prod->part_number) }}', 0, '', this)" class="w-full bg-primary hover:bg-[var(--primary-dark)] text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5 shadow-md">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add to Request</span>
        </button>
    </div>
</div>
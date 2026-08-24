@php 
    $img = (!empty($prod->images) && isset($prod->images[0]) && file_exists(public_path($prod->images[0]))) 
        ? asset($prod->images[0]) 
        : asset('images/logo.png');
@endphp
<div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl hover:border-sky-300 transition-all duration-300 flex flex-col justify-between h-full group">
    <div class="p-4">
        <!-- Image Box -->
        <div class="relative h-44 w-full  rounded-xl overflow-hidden mb-3 border border-slate-100 flex items-center justify-center p-3">
            <img src="{{ $img }}" alt="{{ $prod->name }}" class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
            <span class="absolute top-2.5 right-2.5 bg-[#13A1F3]/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm">
                {{ $prod->manufacturer->name ?? 'Industrial' }}
            </span>
        </div>

        <!-- Category -->
        <div class="text-[10px] font-bold text-sky-600 uppercase tracking-wider mb-1">
            {{ $prod->category->name ?? 'Industrial Spare' }}
        </div>
        
        <!-- Title -->
        <h3 class="font-bold text-xs sm:text-sm text-slate-900 line-clamp-2 hover:text-sky-600 transition mb-3 leading-snug min-h-[2.5rem]">
            <a href="{{ route('products.show', $prod->slug) }}">{{ $prod->name }}</a>
        </h3>

        <!-- Specs Badge Row -->
        <div class="flex flex-wrap gap-1.5 text-[11px] mb-3">
            <span class="bg-slate-100 text-slate-600 font-mono px-2 py-0.5 rounded border border-slate-200/60" title="Part Number">
                <strong class="font-sans text-slate-800">P#:</strong> {{ $prod->part_number }}
            </span>
            <span class="bg-slate-100 text-slate-600 font-mono px-2 py-0.5 rounded border border-slate-200/60" title="Model Number">
                <strong class="font-sans text-slate-800">M#:</strong> {{ $prod->model_number }}
            </span>
        </div>
    </div>

    <!-- Bottom Price & Action Row -->
    <div class="px-4 pb-4 pt-3  flex items-center justify-between mt-auto ">
        <div>
            <span class="text-[10px] text-slate-400 font-medium block uppercase tracking-wider">Unit Price</span>
            <span class="text-sm sm:text-base font-extrabold text-sky-950">£{{ number_format($prod->price, 2) }}</span>
        </div>

        <button onclick="addToRequest({{ $prod->id }}, '{{ addslashes($prod->name) }}', '{{ addslashes($prod->part_number) }}', {{ $prod->price }}, '{{ $img }}', this)" class="bg-[#13A1F3] hover:bg-[#13A1F3] text-white text-xs font-bold px-3.5 py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 shadow-md shadow-sky-200">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Add Request</span>
        </button>
    </div>
</div>

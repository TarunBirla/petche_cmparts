@extends('layouts.admin')

@section('title', 'Request Details #' . $productRequest->request_number)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.requests.index') }}" class="text-xs font-bold text-sky-600 hover:underline flex items-center gap-1">
        <i class="fa-solid fa-arrow-left"></i> Back to Requests List
    </a>

    <!-- Status Change Form -->
    <form action="{{ route('admin.requests.update-status', $productRequest->id) }}" method="POST" class="flex items-center gap-2">
        @csrf
        @method('PATCH')
        <span class="text-xs font-bold text-slate-700">Change Status:</span>
        <select name="status" onchange="this.form.submit()" class="text-xs p-2 border rounded-lg font-bold bg-white focus:ring-2 focus:ring-sky-500">
            <option value="pending" {{ $productRequest->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="contacted" {{ $productRequest->status === 'contacted' ? 'selected' : '' }}>Contacted Buyer</option>
            <option value="completed" {{ $productRequest->status === 'completed' ? 'selected' : '' }}>Completed / Sent Quote</option>
            <option value="cancelled" {{ $productRequest->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Customer Details Card -->
    <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="border-b pb-3">
            <span class="text-[10px] uppercase font-bold text-slate-400 block">Quotation Inquiry</span>
            <h3 class="text-xl font-mono font-bold text-sky-900">#{{ $productRequest->request_number }}</h3>
            <span class="text-xs text-slate-400 block mt-1">Submitted on {{ $productRequest->created_at->format('F d, Y at H:i') }}</span>
        </div>

        <div>
            <h4 class="font-bold text-xs uppercase text-slate-500 mb-2">Customer Details</h4>
            <div class="space-y-2 text-xs">
                <div><strong class="text-slate-700">Name:</strong> {{ $productRequest->customer_name }}</div>
                <div><strong class="text-slate-700">Email:</strong> <a href="mailto:{{ $productRequest->customer_email }}" class="text-sky-600 hover:underline">{{ $productRequest->customer_email }}</a></div>
                <div><strong class="text-slate-700">Phone:</strong> <a href="tel:{{ $productRequest->customer_phone }}" class="text-sky-600 hover:underline font-mono">{{ $productRequest->customer_phone }}</a></div>
            </div>
        </div>

        @if($productRequest->notes)
            <div class="bg-sky-50 p-4 rounded-xl border border-sky-100">
                <h4 class="font-bold text-xs text-sky-900 mb-1">Customer Notes / Message:</h4>
                <p class="text-xs text-slate-600 leading-relaxed">{{ $productRequest->notes }}</p>
            </div>
        @endif

        <div class="pt-4 border-t">
            <span class="text-xs text-slate-500 block mb-1">Current Status:</span>
            <span class="capitalize px-3 py-1 rounded-full text-xs font-bold inline-block
                {{ $productRequest->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                {{ $productRequest->status === 'contacted' ? 'bg-sky-100 text-sky-800' : '' }}
                {{ $productRequest->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                {{ $productRequest->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : '' }}">
                {{ $productRequest->status }}
            </span>
        </div>
    </div>

    <!-- Requested Items Table -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
            <i class="fa-solid fa-boxes-packing text-sky-600"></i> Requested Items List
        </h3>

        <div class="border rounded-xl overflow-hidden border-slate-200 mb-6">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold uppercase border-b">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Product Name</th>
                        <th class="p-3">Part #</th>
                        <th class="p-3">Unit Price (£)</th>
                        <th class="p-3 text-center">Qty</th>
                        <th class="p-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php $grandTotal = 0; @endphp
                    @foreach($productRequest->items as $index => $item)
                        @php 
                            $subtotal = $item->price * $item->quantity; 
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td class="p-3 text-slate-400 font-bold">{{ $index + 1 }}</td>
                            <td class="p-3 font-bold text-slate-900">
                                @if($item->product)
                                    <a href="{{ route('products.show', $item->product->slug) }}" target="_blank" class="hover:text-sky-600">
                                        {{ $item->product_name }}
                                    </a>
                                @else
                                    {{ $item->product_name }}
                                @endif
                            </td>
                            <td class="p-3 font-mono text-slate-600">{{ $item->part_number ?? 'N/A' }}</td>
                            <td class="p-3 font-semibold text-slate-800">£{{ number_format($item->price, 2) }}</td>
                            <td class="p-3 text-center font-bold text-sky-900">{{ $item->quantity }}</td>
                            <td class="p-3 text-right font-bold text-sky-900">£{{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-sky-50/70 font-bold text-slate-900 border-t">
                    <tr>
                        <td colspan="5" class="p-4 text-right text-xs">Total Estimated Inquiry Value:</td>
                        <td class="p-4 text-right text-base text-sky-900 font-extrabold">£{{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-end gap-3">
            <a href="mailto:{{ $productRequest->customer_email }}?subject=Petchemparts%20Quote%20Request%20%23{{ $productRequest->request_number }}" class="bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fa-solid fa-reply"></i>
                <span>Reply to Customer via Email</span>
            </a>
        </div>
    </div>

</div>

@endsection

@extends('layouts.app')

@section('title', 'Contact Us - Petchemparts')

@section('content')

<!-- Header Banner -->
<div class="bg-[var(--primary-dark)] text-white py-12 px-4">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <span class="inline-block bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                Get In Touch
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold">Contact Our Sales & Technical Team</h1>
            <p class="text-sky-200 text-xs sm:text-sm mt-1">Have a specific spare part inquiry or quotation request? Reach out to us anytime.</p>
        </div>

        <div class="text-xs text-sky-200 bg-sky-800/60 px-4 py-2 rounded-xl border border-sky-700">
            Helpline: <strong class="text-white text-sm ml-1 font-mono">0044-7891363776</strong>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Contact Information Cards -->
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-base border-b pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-headset text-sky-600"></i> Direct Contact Info
                </h3>

                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sales Helpline</span>
                    <a href="tel:00447891363776" class="text-sky-700 font-extrabold text-base font-mono hover:underline">0044-7891363776</a>
                    <span class="text-xs text-emerald-600 block mt-0.5"><i class="fa-solid fa-clock mr-1"></i> 7 Days a week: 9:00 am - 7:00 pm</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Office Telephone</span>
                    <a href="tel:00441234440530" class="text-slate-800 font-bold text-sm font-mono hover:underline">0044-1234440530</a>
                </div>

                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Email Inquiry</span>
                    <a href="mailto:Sales@petchemparts.com" class="text-sky-600 font-bold text-sm hover:underline">Sales@petchemparts.com</a>
                </div>

                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">UK Head Office Address</span>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium mt-1">
                        <i class="fa-solid fa-location-dot text-sky-600 mr-1.5"></i>
                        Suite 211 Sterling House, Langston Road, Loughton IG10 3TS, United Kingdom
                    </p>
                </div>
            </div>

            <div class="bg-[var(--primary-dark)] text-white p-6 rounded-2xl shadow-lg border border-sky-800 space-y-3">
                <h4 class="font-bold text-sm text-sky-200 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved"></i> Global Petchemparts Spare Sourcing
                </h4>
                <p class="text-xs text-sky-100 leading-relaxed">
                    Spanning more than 500 brands from UK, Europe, and USA. Fast turnaround and end-to-end global shipping.
                </p>
            </div>

        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <h3 class="font-bold text-xl text-slate-900 mb-2">Send Us a Direct Message</h3>
            <p class="text-xs text-slate-500 mb-6">Fill out the form below and our technical engineers will respond within 24 hours.</p>

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="e.g. Michael Scott" class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required placeholder="name@company.com" class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone / Mobile</label>
                        <input type="tel" name="phone" placeholder="+44 7123 456789" class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Subject</label>
                        <input type="text" name="subject" placeholder="e.g. Spare Parts Inquiry / Quotation" class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Message <span class="text-rose-500">*</span></label>
                    <textarea name="message" rows="5" required placeholder="Detail your spare parts request, model numbers, or plant specifications..." class="w-full text-xs p-3 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500"></textarea>
                </div>

                <button type="submit" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-8 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <span>Send Message</span>
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>
</div>

@endsection

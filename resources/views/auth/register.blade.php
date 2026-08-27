@extends('layouts.app')

@section('title', 'Register Account - Petchemparts')

@section('content')
<div class="py-12 bg-slate-50 min-h-[80vh] flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-8 border border-slate-200">
        <div class="text-center mb-6">
            <img class="h-12 w-auto mx-auto mb-3 object-contain" src="{{ asset('images/logo.png') }}" alt="Petchemparts Logo">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Create Customer Account</h1>
            <p class="text-xs text-slate-500 mt-1">Register to submit quote requests & track equipment inquiries</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-3.5 rounded-xl text-xs mb-5">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Full Name <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. John Doe" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <i class="fa-solid fa-user absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <i class="fa-solid fa-envelope absolute left-3 top-3 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone Number <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+44 7123 456789" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <i class="fa-solid fa-phone absolute left-3 top-3 text-slate-400 text-xs"></i>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Company / Organization (Optional)</label>
                <div class="relative">
                    <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Petrochem Industries Ltd" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <i class="fa-solid fa-building absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="reg_password" name="password" required placeholder="Minimum 6 characters" class="w-full text-xs pl-9 pr-9 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-slate-400 text-xs"></i>
                        <button type="button" onclick="togglePasswordVisibility('reg_password', this)" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 focus:outline-none p-0.5" title="Toggle password visibility">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Confirm Password <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="reg_password_confirmation" name="password_confirmation" required placeholder="Repeat password" class="w-full text-xs pl-9 pr-9 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <i class="fa-solid fa-shield-halved absolute left-3 top-3 text-slate-400 text-xs"></i>
                        <button type="button" onclick="togglePasswordVisibility('reg_password_confirmation', this)" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 focus:outline-none p-0.5" title="Toggle password visibility">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs py-3 rounded-xl shadow-md transition mt-2">
                Create Account
            </button>
        </form>

        <div class="mt-6 pt-6 border-t text-center text-xs text-slate-600">
            Already registered?
            <a href="{{ route('login') }}" class="text-sky-700 font-bold hover:underline ml-1">Sign In to Your Account</a>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, buttonEl) {
        const input = document.getElementById(inputId);
        const icon = buttonEl.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Sign In - Petchemparts')

@section('content')
<div class="py-12 bg-slate-50 min-h-[75vh] flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-8 border border-slate-200">
        <div class="text-center mb-6">
            <img class="h-12 w-auto mx-auto mb-3 object-contain" src="{{ asset('images/newlogo.jpeg') }}" alt="Petchemparts Logo">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sign In to Your Account</h1>
            <p class="text-xs text-slate-500 mt-1">Access quote requests, save equipment lists & manage account</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 rounded-xl text-xs mb-4">
                <i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-3 rounded-xl text-xs mb-4">
                <i class="fa-solid fa-circle-exclamation text-rose-600 mr-1.5"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <i class="fa-solid fa-envelope absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="login_password" name="password" required placeholder="••••••••" class="w-full text-xs pl-9 pr-9 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <i class="fa-solid fa-lock absolute left-3 top-3 text-slate-400 text-xs"></i>
                    <button type="button" onclick="togglePasswordVisibility('login_password', this)" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 focus:outline-none p-0.5" title="Toggle password visibility">
                        <i class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-sky-600 focus:ring-sky-500 mr-2">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs py-3 rounded-xl shadow-md transition">
                Sign In
            </button>
        </form>

        <div class="mt-6 pt-6 border-t text-center text-xs text-slate-600">
            Don't have an account yet?
            <a href="{{ route('register') }}" class="text-sky-700 font-bold hover:underline ml-1">Create an Account</a>
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

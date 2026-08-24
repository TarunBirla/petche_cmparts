<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Petchemparts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-sky-900 via-sky-800 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 border border-sky-100">
        <div class="text-center mb-8">
            <img class="h-12 w-auto mx-auto mb-3" src="{{ asset('images/logo.png') }}" alt="Petchemparts Logo">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Admin Portal</h1>
            <p class="text-xs text-slate-500 mt-1">Sign in to manage Petchemparts Petchemparts catalog</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-3 rounded-lg text-xs mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@petchemparts.com" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <i class="fa-solid fa-envelope absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="••••••••" class="w-full text-xs pl-9 pr-3 py-2.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <i class="fa-solid fa-lock absolute left-3 top-3 text-slate-400 text-xs"></i>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-sky-600 focus:ring-sky-500 mr-2">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs py-3 rounded-lg shadow-lg shadow-sky-200 transition">
                Sign In to Dashboard
            </button>
        </form>

       
    </div>

</body>
</html>

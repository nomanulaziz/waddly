<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Waddly</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-black text-white font-hanken-grotesk pb-20">
    <div class="px-10">
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/waddly-text-logo1.png') }}" alt="waddly-logo" 
                    class="w-24 h-auto sm:w-36 md:w-48 lg:w-64 xl:w-70" >
                </a>
            </div>

            <div class="space-x-6 font-bold">
                <a href="">Jobs</a>
                <a href="">Careers</a>
                <a href="">Salaries</a>
                <a href="">Companies</a>
            </div>

            @auth
                <div class="space-x-6 font-bold flex">
                    <a href="{{ url('/jobs/create') }} ">Post a job</a>
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button>Log Out</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="space-x-6 font-bold">
                    <a href="{{ url('/register') }}">Sign Up</a>
                    <a href="{{ url('/login') }}">Log In</a>
                </div>
            @endguest
        </nav>

        <main class="mt-10 max-w-[1200px] mx-auto">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        {{-- Vite Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @yield('scripts')
    </head>
    <body class="font-sans antialiased">
        <div class="border-2 bg-white sticky top-0 h-16">
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <span
                        class="mr-2 border-r-2 p-2 font-semibold text-gray-400 hover:text-gray-600"
                    >
                        Hi, Jason
                    </span>
                    <a
                        href="{{ route('films.list.page') }}"
                        class="mr-2 font-semibold text-gray-400 hover:text-gray-600"
                    >
                        Films
                    </a>
                    <a
                        href="{{ route('logout.web') }}"
                        class="font-semibold text-gray-400 hover:text-gray-600"
                    >
                        Logout
                    </a>
                @else
                    <a
                        href="{{ route('login.page') }}"
                        class="mr-2 font-semibold text-gray-400 hover:text-gray-600"
                    >
                        Log in
                    </a>

                    <a
                        href="{{ route('register.page') }}"
                        class="font-semibold text-gray-400 hover:text-gray-600"
                    >
                        Register
                    </a>
                @endauth
            </div>
        </div>

        <div id="app">
            @yield('content')
        </div>
    </body>
</html>

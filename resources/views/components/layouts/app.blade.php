
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .align-middle {
            align-content: center;
        }
        .full-height-no-navbar {
            height: calc(100vh - 4rem);
        }
        html, body {
            height: 100%;
        }
        .slide-enter-active, .slide-leave-active {
            transition: transform 0.5s ease;
        }

        .slide-enter, .slide-leave-to {
            transform: translateX(-100%);
        }
    </style>

</head>
<body>
    @include('components/navbar')

    {{-- Page content goes here --}}
    {{ $slot }}

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
</body>
<script>
    window.Laravel = {
        userId: @json(Auth::check() ? Auth::id() : null),
    }

</script>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Protection & Privacy Fines</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/dpfines_logo.png') }}" type="image/png">
    @stack('styles')
</head>

<body>

    @include('includes.header')

    <main>
        @yield('content')
    </main>

    @include('includes.footer')

    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        window.NEWSLETTER_SUBSCRIBE_URL = "{{ route('newsletter.subscribe') }}";
    </script>

    @stack('scripts')
</body>

</html>
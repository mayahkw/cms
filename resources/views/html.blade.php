<!DOCTYPE html>
<html lang="{{ $data->lang }}">

<head>

    <head>
        <title>{{ $data->title }} | {{ $system->config->site->value }} </title>

        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if (Auth::check())
            <meta name="user-id" content="{{ Auth::user()->email }}" />
        @endif

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    </head>

<body class="font-sans antialiased">
    @yield('content')
</body>

</html>

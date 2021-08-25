<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>safta</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{asset('css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{asset('css/all.min.css') }}">
        <link rel="stylesheet" href="{{asset('css/style.css') }}">

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
       

        <!-- Scripts -->
        @routes
        <script>var safta = 235;</script>
        <script src="{{ asset('js/jquery-3.6.0.min.js')}}"></script>
          <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <script src="{{ asset('js/jquery-ui.min.js')}}"></script>
        <script src="{{ asset('js/jquery.ui.touch-punch.min.js')}}"></script>
        <script src="{{ asset('js/mqtt.js')}}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ asset('js/scripte.js')}}"></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>

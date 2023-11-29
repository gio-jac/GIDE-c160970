<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title inertia>Loading... | Service LATAM GyD | {{ config('app.name', 'GyD') }}</title>

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    
    @vite(['resources/js/src/app.js', "resources/js/src/views/{$page['component']}.vue"])
    @inertiaHead
</head>

<body>
    <noscript>
        <strong>No JS.</strong>
    </noscript>

    @inertia
</body>
</html>

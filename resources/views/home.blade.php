<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .bg-curve {
            background-image: url('{{ asset('images/Path.png') }}');
            background-repeat: no-repeat;
            background-position: top right;
            background-size: contain;
            position: relative;
            overflow: hidden;
        }
        body {
            background-color: #05102E;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="bg-curve">
        <x-navbar />
        <x-hero />
    </div>
    <x-hero_2 />
    <x-footer />
</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* .bg-curve {
            background-image: url('{{ asset('images/Path.png') }}');
            background-repeat: no-repeat;
            background-position: top right;
            background-size: contain;
            position: relative;
            overflow: hidden;
        } */
        body {
            background-color: #05102E;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
    </style>
</head>
<body class="font-['Source Sans 3']">
    <div class="bg-curve">
        <x-navbar />
        <x-hero />
    </div>
    <x-hero_2 />
    <x-footer />
    <script>
       document.getElementById('languageDropdown').addEventListener('click', function (e) {
    e.stopPropagation();
    const dropdownMenu = document.getElementById('dropdownMenu');
    dropdownMenu.classList.toggle('hidden');
});

document.addEventListener('click', function () {
    const dropdownMenu = document.getElementById('dropdownMenu');
    if (!dropdownMenu.classList.contains('hidden')) {
        dropdownMenu.classList.add('hidden');
    }
});


    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-navbar />
    <x-hero />
    {{-- <x-sections.other /> --}}
    <x-footer />
</body>
</html>

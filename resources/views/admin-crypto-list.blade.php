<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CryptoList</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
        <admin-crypto-list/>
    </div>
</body>
</html>
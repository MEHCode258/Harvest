<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Laravel Site</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 text-gray-900">
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-white text-lg font-bold">Seedling Harvest ED.</a>
        <ul class="flex space-x-4">
            <li><a href="{{ route('projects.index') }}" class="text-gray-300 hover:text-white">Projects</a></li>
            <li><a href="{{ route('clients.index') }}" class="text-gray-300 hover:text-white">Clients</a></li>
            <li><a href="{{ route('proposals.index') }}" class="text-gray-300 hover:text-white">Proposals</a></li>
        </ul>
    </div>
</nav>
    <div class="container mx-auto mt-8 p-4">
        @yield('content')
    </div>
 
</body>
</html>
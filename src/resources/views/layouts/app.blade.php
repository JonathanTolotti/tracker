<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de rastreamento')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 antialiased">
<div class="container mx-auto px-4 py-8">
    <header class="text-center mb-12">
        <h1 class="text-4xl font-bold text-orange-600">Rastreamento de Entregas</h1>
        <p class="text-lg text-gray-600 mt-2">Consulte o status da sua entrega de forma rápida e fácil.</p>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="text-center mt-16 text-sm text-gray-500">
        <p>&copy; {{ date('Y') }}.</p>
    </footer>
</div>
</body>
</html>

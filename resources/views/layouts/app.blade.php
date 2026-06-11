<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Management System</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <h1 class="text-xl font-bold text-gray-800">CRM System</h1>
                        <div class="flex space-x-4">
                            <a href="/products" wire:navigate
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Products</a>
                            <a href="/customers" wire:navigate
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Customers</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Add this right before @livewireScripts or in the head -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            // This runs after each navigation
            console.log('Page navigated without reload!');
        });
    </script>

    @livewireScripts
</body>

</html>

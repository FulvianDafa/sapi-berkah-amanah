<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Sapi Berkah Amanah</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Dropzone CSS -->
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@4/material-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="fixed w-64 min-h-screen bg-slate-800 transition-all duration-300 z-20">
            <div class="flex items-center p-4 text-xl font-bold text-white bg-slate-900">
                <i class="fas fa-mosque mr-2"></i>
                Admin Panel
            </div>
            <div class="flex flex-col">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-5 py-4 text-gray-300 hover:bg-slate-700 hover:text-white transition-all {{ Request::routeIs('admin.dashboard') ? 'bg-slate-700 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.hewan-kurban.index') }}" 
                   class="flex items-center px-5 py-4 text-gray-300 hover:bg-slate-700 hover:text-white transition-all {{ Request::routeIs('admin.hewan-kurban.*') ? 'bg-slate-700 text-white' : '' }}">
                    <i class="fas fa-cow mr-2"></i> Hewan Kurban
                </a>
                <a href="{{ route('admin.reseller') }}" 
                   class="flex items-center px-5 py-4 text-gray-300 hover:bg-slate-700 hover:text-white transition-all {{ Request::routeIs('admin.reseller') ? 'bg-slate-700 text-white' : '' }}">
                    <i class="fas fa-user mr-2"></i> Reseller
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="ml-64 w-[calc(100%-16rem)] transition-all duration-300">
            <!-- Navbar -->
            <nav class="bg-white shadow-md sticky top-0 z-10">
                <div class="px-4 py-3">
                    <div class="flex justify-between items-center">
                        <button id="sidebarToggle" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="relative">
                            <button class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                                <span class="mr-2">Admin</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <!-- Dropdown menu -->
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                                <hr class="my-2 border-gray-200">
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded relative" role="alert">
                        <div class="flex">
                            <i class="fas fa-check-circle mt-1 mr-2"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded relative" role="alert">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mt-1 mr-2"></i>
                            <div>
                                {{ session('error') }}
                            </div>
                        </div>
                        <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const wrapper = document.getElementById('wrapper');
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('page-content-wrapper');
            
            wrapper.classList.toggle('sidebar-hidden');
            
            if (wrapper.classList.contains('sidebar-hidden')) {
                sidebar.classList.add('-translate-x-full');
                content.classList.remove('ml-64');
                content.classList.add('ml-0', 'w-full');
            } else {
                sidebar.classList.remove('-translate-x-full');
                content.classList.add('ml-64', 'w-[calc(100%-16rem)]');
                content.classList.remove('ml-0', 'w-full');
            }
        });

        // Dropdown toggle with improved accessibility
        const dropdownButton = document.querySelector('button.flex.items-center');
        const dropdownMenu = document.querySelector('.hidden.absolute');
        
        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            if (!dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Close alerts with animation
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            const closeButton = alert.querySelector('button');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    alert.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    setTimeout(() => alert.remove(), 300);
                });
            }
        });
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
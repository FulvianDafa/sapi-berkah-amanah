<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Sapi Berkah Amanah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen" id="wrapper">

        <!-- ════════════════════════════ -->
        <!-- SIDEBAR                      -->
        <!-- ════════════════════════════ -->
        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-40 w-60 flex flex-col
                      bg-gradient-to-b from-green-950 to-green-900
                      transition-transform duration-300 ease-in-out
                      -translate-x-full">

            <!-- Brand -->
            <div class="flex items-center gap-2.5 px-5 h-16 shrink-0">
                <span class="text-white font-semibold tracking-wide">ADMIN SBA</span>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                          {{ Request::routeIs('admin.dashboard')
                              ? 'bg-white/10 text-white'
                              : 'text-green-300/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-th-large w-4 text-center text-[11px]"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.hewan-kurban.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                          {{ Request::routeIs('admin.hewan-kurban.*')
                              ? 'bg-white/10 text-white'
                              : 'text-green-300/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-cow w-4 text-center text-[11px]"></i>
                    Hewan Kurban
                </a>
                <a href="{{ route('admin.reseller') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm font-medium transition-colors
                          {{ Request::routeIs('admin.reseller')
                              ? 'bg-white/10 text-white'
                              : 'text-green-300/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-users w-4 text-center text-[11px]"></i>
                    Reseller
                </a>
            </nav>

            <!-- Footer -->
            <div class="px-4 py-3 border-t border-white/5">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 w-full px-2 py-1.5 text-[12px] text-green-400/60 hover:text-red-400 rounded transition-colors">
                        <i class="fas fa-sign-out-alt w-4 text-center text-[11px]"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile overlay -->
        <div id="sidebar-overlay"
             class="fixed inset-0 z-30 bg-black/30 hidden lg:hidden"
             onclick="closeSidebar()"></div>

        <!-- ════════════════════════════ -->
        <!-- MAIN AREA                    -->
        <!-- ════════════════════════════ -->
        <div id="main" class="lg:ml-60 min-h-screen flex flex-col transition-all duration-300">

            <!-- Top bar -->
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-lg border-b border-gray-100 h-14 flex items-center px-4 sm:px-6 shrink-0">
                <button id="menuBtn" onclick="toggleSidebar()"
                        class="w-8 h-8 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors lg:hidden">
                    <i class="fas fa-bars text-sm" id="menuIcon"></i>
                </button>

                <!-- Desktop toggle -->
                <button id="desktopMenuBtn" onclick="toggleDesktop()"
                        class="hidden lg:flex w-8 h-8 items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                    <i class="fas fa-bars text-sm"></i>
                </button>

                <span class="ml-3 text-sm font-semibold text-gray-800 hidden sm:inline">@yield('title')</span>

                <div class="ml-auto flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-green-600 flex items-center justify-center text-white text-[11px] font-bold">A</div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-4 sm:p-6">
                @if(session('success'))
                    <div id="flash-success"
                         class="mb-5 flex items-center gap-3 p-3 rounded-lg bg-green-50 border border-green-100 text-green-700 text-sm" role="alert">
                        <i class="fas fa-check-circle text-green-500 text-sm shrink-0"></i>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600"><i class="fas fa-times text-xs"></i></button>
                    </div>
                @endif
                @if(session('error'))
                    <div id="flash-error"
                         class="mb-5 flex items-center gap-3 p-3 rounded-lg bg-red-50 border border-red-100 text-red-700 text-sm" role="alert">
                        <i class="fas fa-exclamation-circle text-red-500 text-sm shrink-0"></i>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600"><i class="fas fa-times text-xs"></i></button>
                    </div>
                @endif
                @yield('content')
            </main>

            <footer class="px-6 py-3 text-center text-[11px] text-gray-400 border-t border-gray-50">
                &copy; {{ date('Y') }} Sapi Berkah Amanah
            </footer>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const main = document.getElementById('main');
        let desktopVisible = true;

        function applySidebarState(visible) {
            desktopVisible = visible;
            if (visible) {
                sidebar.classList.remove('-translate-x-full');
                main.classList.add('lg:ml-60');
            } else {
                sidebar.classList.add('-translate-x-full');
                main.classList.remove('lg:ml-60');
            }
        }

        // On load: restore saved state on desktop, hide on mobile
        function initSidebar() {
            if (window.innerWidth >= 1024) {
                const saved = localStorage.getItem('sidebarVisible');
                applySidebarState(saved === null ? true : saved === 'true');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                desktopVisible = true; // reset for when they go back to desktop
            }
        }
        initSidebar();

        // Mobile: open/close with overlay
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
        function toggleSidebar() {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }

        // Desktop: toggle sidebar + persist state
        function toggleDesktop() {
            desktopVisible = !desktopVisible;
            localStorage.setItem('sidebarVisible', desktopVisible);
            applySidebarState(desktopVisible);
        }

        // Auto-dismiss flash
        document.querySelectorAll('[id^="flash-"]').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity .3s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            }, 4000);
        });
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true })
                .fire({ icon:'success', title:"{{ session('success') }}" });
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true })
                .fire({ icon:'error', title:"{{ session('error') }}" });
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
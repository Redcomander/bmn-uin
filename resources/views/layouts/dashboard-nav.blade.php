<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Font1|Font2|Font3&display=swap"> --}}
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>

    <script src="{{ asset('bootstrap.bundle.js') }}"></script>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Include jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Buttons -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <link
        href="https://cdn.datatables.net/v/se/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/kt-2.10.0/r-2.5.0/sb-1.6.0/datatables.min.css"
        rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <style>
        /* Add transition for menu items */
        .list-group-item {
            transition: background-color 0.0ms, color 0.0ms;
            font-size: 12px;
        }

        .list-group-item i {
            font-size: 15px;
            /* Adjust the size as needed */
        }

        /* Active class in light mode */
        body.light-mode .list-group-item.active {
            background-color: #007bff;
            color: #fff;
        }

        /* Active class in dark mode */
        body.dark-mode .list-group-item.active {
            background-color: #fff !important;
            color: #000 !important;
        }

        body {
            background-color: #fbfbfb;
        }

        body.dark-mode .dark-mode {
            background-color: #333 !important;
            color: #fff !important;
        }

        body.dark-mode .sidebar {
            background-color: #333 !important;
            color: #fff !important;
        }

        body.dark-mode #main-navbar {
            background-color: #333 !important;
            color: #fff !important;
        }

        @media (min-width: 991.98px) {
            main {
                padding-left: 240px;
            }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            border-radius: 30px;
            padding: 48px;
            /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
            top: 8px;
            left: 24px;
            /* Adjust this value as needed */
        }

        .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }

        .dark-mode-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .dark-mode-toggle:hover {
            color: #333;
            /* Darker color on hover */
        }

        /* Style for the user's name in the dropdown */
        /* Style for the user's name in the dropdown in light mode */
        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            /* Spacing between the image and name */
        }

        .user-name {
            font-size: 16px;
            font-weight: bold;
            color: #000000;
            /* Text color for the user's name in light mode */
        }

        /* Style for the user's name in the dropdown in dark mode */
        body.dark-mode .user-name {
            color: #fff;
            /* Text color for the user's name in dark mode */
        }

        .custom-navbar {
            height: 70px;
            margin-left: 19%;
            border-radius: 20px;
            margin-top: 0.5%;
            margin-right: 1%;
        }

        .custom-container {
            padding: 0;
        }

        .custom-header {
            margin: -11px;
        }

        .navbar {
            padding-top: 0;
        }

        /* Style for the user's role in light mode */
        .user-role {
            font-size: 12px;
            /* Adjust the font size as needed */
            color: #555;
            /* Your desired color */
        }

        /* Style for the user's role in dark mode */
        body.dark-mode .user-role {
            color: #aaa;
            /* Your desired color in dark mode */
        }

        .list-group-item:hover {
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Style for the mobile bottom navbar */
        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 -2px 5px 0 rgba(0, 0, 0, 0.1);
            z-index: 999;
            /* Ensure the navbar appears over content */
        }

        .mobile-navbar {
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }

        .mobile-nav-item {
            text-align: center;
            color: #000;
            text-decoration: none;
            font-size: 24px;
        }

        /* Show the mobile navbar in mobile view */
        @media (max-width: 991.98px) {
            #mobileNav {
                display: block;
            }

            #sidebarMenu {
                display: none;
            }

            .mobile-active {
                color: #007bff;
            }
        }
    </style>

</head>

<body class="light-mode">
    <!--Main Navigation-->
    <header class="custom-header">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white"
            style="border-radius: 10px; padding: 10px;">
            <div class="position-sticky">
                {{-- LOGO --}}
                <a class="navbar-brand justify-content-center" href="{{ '/' }}">
                    <img id="navbar-logo" src="{{ asset('logo_uin.png') }}" height="70" alt=""
                        loading="lazy" />
                    <span id="header-title"></span>
                </a>
                {{-- END LOGO --}}
                <div class="list-group list-group-flush mx-2 mt-5">
                    @if (auth()->check())
                        <a href="{{ route('dashboard') }}"
                            class="nav-link list-group-item list-group-item-action py-2 ripple dark-mode {{ Request::is('dashboard') ? 'active' : '' }}"
                            aria-current="true" onclick="changeHeaderTitle('Main Dashboard')">
                            <i class="fas fa-tachometer-alt fa-fw me-2"></i><span>Main Dashboard</span>
                        </a>
                        <a href="{{ url('/masuk') }}"
                            class="list-group-item list-group-item-action py-2 ripple dark-mode {{ Request::is('masuk*') ? 'active' : '' }}"
                            onclick="changeHeaderTitle('Daftar Barang Masuk')">
                            <i class="fas fa-circle-arrow-up me-2"></i><span>Daftar Barang Masuk</span>
                        </a>
                        <a href="{{ url('/keluar') }}"
                            class="list-group-item list-group-item-action py-2 ripple dark-mode {{ Request::is('keluar*') ? 'active' : '' }}"
                            onclick="changeHeaderTitle('Daftar Barang Keluar')"><i
                                class="fas fa-circle-arrow-down me-2"></i><span>Daftar
                                Barang Keluar</span></a>
                        <a href="{{ url('/inventory') }}"
                            class="list-group-item list-group-item-action py-2 ripple dark-mode {{ Request::is('inventory*') ? 'active' : '' }}"
                            onclick="changeHeaderTitle('List Barang')"><i
                                class="fas fa-boxes-stacked me-2"></i><span>List
                                Barang</span></a>
                        @if (auth()->user()->hasPermission('read_write'))
                            <a href="{{ url('/user') }}"
                                class="list-group-item justify-center list-group-item-action py-2 ripple dark-mode {{ Request::is('user*') ? 'active' : '' }}">
                                <i class="fas fa-chalkboard-user me-1"></i><span>User Account</span>
                            </a>
                        @endif
                        <a href="{{ url('/ruangan') }}"
                            class="list-group-item list-group-item-action py-2 ripple dark-mode {{ Request::is('ruangan*') ? 'active' : '' }}"><i
                                class="far fas fa-list me-2"></i><span>Daftar Ruangan</span></a>
                        <a href="{{ url('/berita_acara') }}"
                            class="list-group-item list-group-item-action py-2 ripple dark-mode {{ Request::is('berita_acara*') ? 'active' : '' }}"><i
                                class="bi bi-newspaper me-2"></i><span>Berita Acara</span></a>
                        <!-- Avatar -->
                        @auth
                            <div class="mx-auto" style="margin-top : 90%;">
                                <div class="text-center mb-3" style="margin-left: -20px;">
                                    <div class="user-name">{{ Auth::user()->name }}</div>
                                    @if (Auth::user()->role)
                                        <div class="user-role">{{ Auth::user()->role->role }}</div>
                                    @else
                                        <div class="user-role"></div>
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="btn btn-danger mb-4" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </div>
                        @endauth
                        {{-- Dark Mode --}}
                        {{-- <div class="form-check form-switch" style="margin-left : 30%;">
                        <label class="form-check-label ms-3" for="lightSwitch">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-brightness-high" viewBox="0 0 16 16">
                                <path
                                    d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                            </svg>
                        </label>
                        <input class="form-check-input" type="checkbox" id="lightSwitch" />
                    </div> --}}
                </div>
                {{-- End Dark Mode --}}
            </div>
        </nav>
        <!-- Sidebar -->
        <!-- Mobile Navigation (for smaller screens) -->
        <div id="mobileNav" class="mobile-nav">
            <div class="mobile-navbar">
                <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ Request::is('dashboard') ? 'mobile-active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                </a>
                <a href="{{ url('/masuk') }}" class="mobile-nav-item {{ Request::is('masuk') ? 'mobile-active' : '' }}">
                    <i class="fas fa-circle-arrow-up"></i>
                </a>
                <a href="{{ url('/keluar') }}" class="mobile-nav-item {{ Request::is('keluar') ? 'mobile-active' : '' }}">
                    <i class="fas fa-circle-arrow-down"></i>
                </a>
                <a href="{{ url('/inventory') }}" class="mobile-nav-item {{ Request::is('inventory*') ? 'mobile-active' : '' }}">
                    <i class="fas fa-boxes-stacked"></i>
                </a>
                @if (auth()->user()->hasPermission('read_write'))
                    <a href="{{ url('/user') }}" class="mobile-nav-item {{ Request::is('user*') ? 'mobile-active' : '' }}">
                        <i class="fas fa-chalkboard-user"></i>
                    </a>
                @endif
                <a href="{{ url('/ruangan') }}" class="mobile-nav-item {{ Request::is('ruangan*') ? 'mobile-active' : '' }}">
                    <i class="far fas fa-list"></i>
                </a>
                <a href="{{ url('/berita_acara') }}" class="mobile-nav-item {{ Request::is('berita_acara*') ? 'mobile-active' : '' }}">
                    <i class="bi bi-newspaper"></i>
                </a>
            </div>
        </div>
        @endif

    </header>

    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 20px; margin-left: 2%;">
        <div class="container custom-container">
            @yield('content')
        </div>
    </main>
    <!--Main layout-->
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const body = document.body;
            const lightSwitch = document.getElementById("lightSwitch");

            // Check the user's preference for dark mode using localStorage
            const isDarkMode = localStorage.getItem("darkMode") === "true";

            // Set the initial mode
            if (isDarkMode) {
                enableDarkMode();
            } else {
                enableLightMode();
            }

            // Function to enable dark mode
            function enableDarkMode() {
                body.classList.remove("light-mode");
                body.classList.add("dark-mode");
                document.getElementById('navbar-logo').src = '{{ asset('logo_putih.png') }}';
                lightSwitch.checked = true;
                // Store the user's preference in localStorage
                localStorage.setItem("darkMode", "true");
            }

            // Function to enable light mode
            function enableLightMode() {
                body.classList.remove("dark-mode");
                body.classList.add("light-mode");
                document.getElementById('navbar-logo').src = '{{ asset('logo_uin.png') }}';
                lightSwitch.checked = false;
                // Store the user's preference in localStorage
                localStorage.setItem("darkMode", "false");
            }

            // Toggle dark/light mode when the switch is clicked
            lightSwitch.addEventListener("change", function() {
                if (lightSwitch.checked) {
                    enableDarkMode();
                } else {
                    enableLightMode();
                }
            });
        });
    </script> --}}
    <script>
        // JavaScript to handle mobile menu toggling
        document.addEventListener("DOMContentLoaded", function() {
            const mobileNav = document.getElementById("mobileNav");

            // Toggle the mobile navigation menu when the body is clicked
            document.body.addEventListener("click", function() {
                if (mobileNav.style.display === "block") {
                    mobileNav.style.display = "none";
                }
            });

            // Prevent toggling when clicking inside the mobile navbar
            mobileNav.addEventListener("click", function(e) {
                e.stopPropagation();
            });
        });
    </script>

</body>

</html>

<!-- resources/views/partials/navbar.blade.php -->


    

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <!-- Logo -->
        <a href="/"><img id="logo" src="{{ asset('img/logo.png') }}?v={{ time() }}" class="img-fluid" style="max-width: 250px; margin-right: 10px; max-height: 30px;" alt="Logo"></a>

        {{-- Versi Asli --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        {{-- Modif Sidbar --}}
        {{-- <button class="navbar-toggler" type="button" aria-label="Toggle navigation" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button> --}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ ($active === 'home') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($active === 'profile') ? 'active' : '' }}" href="/profile">Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        INFO
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/project">Project</a></li>
                        <li><a class="dropdown-item" href="/contact">Kontak</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/posts">News Post</a></li>
                    </ul>
                </li>   
               
                <li class="nav-item">
                    <a class="nav-link {{ ($active === 'anggota') ? 'active' : '' }}" href="/anggota">Anggota</a>
                </li>

                @if (auth()->check() && auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link {{ ($active === 'pengurus') ? 'active' : '' }}" href="/datamahasiswa">Pengurus</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ ($active === 'artikel') ? 'active' : '' }}" href="/artikel">Artikel</a>
                </li>  
                  
                <li class="nav-item">
                    <a class="nav-link {{ ($active === 'test') ? 'active' : '' }}" href="/test">Test</a>
                </li>  
            </ul>

            <ul class="navbar-nav ms-auto">
                {{-- <!-- Theme Toggle Button -->
                <li class="nav-item">
                    <button id="theme-toggle" class="btn btn-link nav-link" aria-label="Toggle Theme">
                        <i id="theme-icon" class="bi bi-brightness-high"></i>
                    </button>
                </li> --}}

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                        <li><a class="dropdown-item" href="/user"><i class="bi bi-person-fill-gear"></i> User</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-in-left"></i> Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a href="/login" class="nav-link login-btn {{ ($active === 'login') ? 'active' : '' }}"><i class="bi bi-box-arrow-in-right"></i> Login  </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>




<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
          <a href="/"> <img alt="image" src="{{ asset('img/logo-s.png') }}" class="header-logo" /> 
              <span class="logo-name">Pelajar-NU</span>
          </a>
      </div>
      <ul class="sidebar-menu">
          <li class="menu-header">Main</li>

          <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
              <a href="{{ url('/dashboard') }}" class="nav-link">
                  <i data-feather="monitor"></i>
                  <span>Dashboard</span>
              </a>
          </li>

          <li class="{{ Request::is('dashboard/pengurus') ? 'active' : '' }}">
              <a href="{{ url('dashboard/pengurus') }}" class="nav-link">
                  <i data-feather="users"></i>
                  <span>Data Pengurus</span>
              </a>
          </li>
          
          <li class="{{ Request::is('dashboard/makesta') ? 'active' : '' }}">
              <a href="{{ url('dashboard/makesta') }}" class="nav-link">
                  <i data-feather="slack"></i>
                  <span>Makesta</span>
              </a>
          </li>

          <li class="{{ Request::is('dashboard/event') ? 'active' : '' }}">
            <a href="{{ url('dashboard/event') }}" class="nav-link">
                <i data-feather="calendar"></i>
                <span>Event</span>
            </a>
        </li>
          {{-- <li class="dropdown {{ Request::is('event*') ? 'active' : '' }}">
              <a href="#" class="menu-toggle nav-link has-dropdown">
                  <i data-feather="calendar"></i>
                  <span>Event</span>
              </a>
              <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ url('dashboard/event/makesta') }}">Makesta</a></li>
                  <li><a class="nav-link" href="{{ url('dashboard/event/ramadhan') }}">Ramadhan</a></li>
                  <li><a class="nav-link" href="{{ url('dashboard/event/other') }}">Other</a></li>
              </ul>
          </li> --}}

          <li class="menu-header">Media</li>
          <li class="{{ Request::is('media/artikel') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('media/artikel') }}">
                  <i data-feather="folder"></i>
                  <span>Artikel</span>
              </a>
          </li>

          <li class="{{ Request::is('media/kategori') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('media/kategori') }}">
                  <i data-feather="bookmark"></i>
                  <span>Kategori</span>
              </a>
          </li>

          <li class="{{ Request::is('media/modul-materi') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('media/modul-materi') }}">
                  <i data-feather="book"></i>
                  <span>Modul Materi</span>
              </a>
          </li>

          <li class="{{ Request::is('media/berkas') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('media/berkas') }}">
                  <i data-feather="folder"></i>
                  <span>Berkas</span>
              </a>
          </li>

          <li class="menu-header">Administrator</li>
          <li class="{{ Request::is('dashboard/auth') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('dashboard/auth') }}">
                  <i data-feather="server"></i>
                  <span>Data User</span>
              </a>
          </li>

          <li class="{{ Request::is('dashboard/role-permission') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('dashboard/role-permission') }}">
                  <i data-feather="lock"></i>
                  <span>Role Permission</span>
              </a>
          </li>

          <li class="{{ Request::is('dashboard/tambah-akun') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('dashboard/tambah-akun') }}">
                  <i data-feather="user-plus"></i>
                  <span>Tambah Akun</span>
              </a>
          </li>

          <li class="{{ Request::is('dashboard/edit-profile') ? 'active' : '' }}">
              <a class="nav-link" href="{{ url('dashboard/edit-profile') }}">
                  <i data-feather="user"></i>
                  <span>Edit Profile</span>
              </a>
          </li>

      </ul>
  </aside>
</div>

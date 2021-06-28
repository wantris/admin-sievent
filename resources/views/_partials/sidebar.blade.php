<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
      <li><a class="nav-link" href="blank.html"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
      <li class="menu-header">Admin</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-portrait"></i> <span>Admin</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('admin.index')}}">Admin</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Wadir 3</a></li>
        </ul>
      </li>
      <li class="menu-header">Semua Pengguna</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-id-badge"></i> <span>Semua Pengguna</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('admin.index')}}">Pengguna</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Mahasiswa</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Participant</a></li>
        </ul>
      </li>
      <li class="menu-header">Informasi Event</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-info-circle"></i> <span>Informasi Event</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('kategorievent.index')}}">Kategori Event</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Cakupan Ormawa</a></li>
        </ul>
      </li>
      <li class="menu-header">Ormawa</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i> <span>Ormawa</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('ormawa.index')}}">Ormawa</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Pembina</a></li>
        </ul>
      </li>
      <li class="menu-header">Tim</li>
      <li><a class="nav-link" href="blank.html"><i class="fas fa-users"></i> <span>Tim</span></a></li>
      <li class="menu-header">Event</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-week"></i> <span>Event</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('admin.index')}}">Event Internal</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Event Eksternal</a></li>
        </ul>
      </li>
      <li class="menu-header">Pendaftaran</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-portrait"></i> <span>Pendaftaran Event</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('admin.index')}}">Event Internal</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Event Eksternal</a></li>
        </ul>
      </li>

  </aside>
</div>
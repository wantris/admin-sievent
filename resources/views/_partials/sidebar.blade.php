<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">SIEVENT</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
      <li><a class="nav-link" href="blank.html"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
      @if (Session::get('is_admin') == "1")
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-portrait"></i> <span>Admin</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('admin.index')}}">Admin</a></li>
            <li><a class="nav-link" href="{{route('wadir3.index')}}">Wadir 3</a></li>
          </ul>
        </li>
      @endif
      @if (Session::get('is_admin') == "1")
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-id-badge"></i> <span>Semua Pengguna</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('pengguna.index')}}">Pengguna</a></li>
            <li><a class="nav-link" href="{{route('mahasiswa.index')}}">Akun Mahasiswa</a></li>
            <li><a class="nav-link" href="{{route('dosen.index')}}">Akun Dosen</a></li>
            <li><a class="nav-link" href="{{route('participant.index')}}">Participant</a></li>
          </ul>
        </li>
      @endif
      @if (Session::get('is_admin') == "1")
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-info-circle"></i> <span>Informasi Event</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('kategorievent.index')}}">Kategori Event</a></li>
            <li><a class="nav-link" href="{{route('cakupanOrmawa.index')}}">Cakupan Ormawa</a></li>
            <li><a class="nav-link" href="{{route('tipepeserta.index')}}">Tipe Peserta</a></li>
          </ul>
        </li>
      @endif
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i> <span>Ormawa</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('ormawa.index')}}">Ormawa</a></li>
          <li><a class="nav-link" href="{{route('pembina.index')}}">Pembina</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-week"></i> <span>Event</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('eventinternal.index')}}">Event Internal</a></li>
          <li><a class="nav-link" href="{{route('eventeksternal.index')}}">Event Eksternal</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i> <span>Tim Peserta</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('team.index', 'eventinternal')}}">Event Internal</a></li>
          <li><a class="nav-link" href="{{route('team.index', 'eventeksternal')}}">Event Eksternal</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-portrait"></i> <span>Pendaftaran Event</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('registrations.eventinternal.index')}}">Event Internal</a></li>
          <li><a class="nav-link" href="{{route('wadir3.index')}}">Event Eksternal</a></li>
        </ul>
      </li>
  </aside>
</div>
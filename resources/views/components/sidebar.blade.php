<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Admin Lauwba</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">

            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admins.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Admin</span></a>
            </li>

            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Peserta</span></a>
            </li>

            <li class="nav-item">
                <a href="{{ route('pembimbings.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Pembimbing</span></a>
            </li>

            <li class="nav-item">
                <a href="{{ route('attendances.index') }}" class="nav-link"><i class="fas fa-columns"></i> <span>Presensi</span></a>
            </li>
    </aside>
</div>
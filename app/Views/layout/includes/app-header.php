<header class="navbar navbar-expand-md navbar-header">
    <div class="container-md">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img src="/assets/img/logo.png" width="30" height="30" class="logo d-inline-block align-top" alt="" loading="lazy">
            <span class="ml-1 d-none d-md-inline-block">
                <?= site()->appName ?>
            </span>
        </a>
        <div class="dropdown ml-md-auto user-menu">
            <a href="#" class="dropdown-toggle text-hover text-decoration-none" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="user-text-image rounded-circle">JD</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <div class="user-profile">
                    <div class="user-thumb">
                        <span class="user-initial">JD</span>
                    </div>
                    <div class="user-info">
                        <span class="user-name">John Doe</span>
                        <small class="user-status">Admin</small>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <?= anchor(['user', 'ganti-password'], 'Ganti Password', ['class' => 'dropdown-item']) ?>
                <?= anchor(['logout'], 'Keluar', ['class' => 'dropdown-item']) ?>
            </div>
        </div>
    </div>
</header>
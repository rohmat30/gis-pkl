<nav class="navbar navbar-expand-md navbar-custom navbar-light">
    <div class="container-md">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item<?= menu()->getActiveMenu() == 'home' || empty(menu()->getActiveMenu()) ? ' active' : '' ?>">
                    <?= anchor('/', '<i class="fas fa-home fa-fw"></i> Beranda', ['class' => 'nav-link']); ?>
                </li>
                <?php foreach (menu()->get(user()->role) as $url => $list) : ?>
                    <li class="nav-item<?= menu()->getActiveMenu() == $url ? ' active' : '' ?>">
                        <?= anchor($url, '<i class="' . $list['icon'] . ' fa-fw"></i> ' . $list['title'], ['class' => 'nav-link']); ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</nav>
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="<?= base_url('assets/dist/img/logo.png') ?>" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Mehmet Test</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="<?= base_url('assets/dist/img/demo/avatars/avatar-admin.png') ?>" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
                                        <?= ucfirst($currentUser['first_name']); ?> <?= ucfirst($currentUser['last_name']); ?>
                                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm"><?= $currentUser['email']; ?></span>
            </div>
            <img src="<?= base_url('assets/dist/img/card-backgrounds/cover-2-lg.png') ?>" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <!--
        TIP: The menu items are not auto translated. You must have a residing lang file associated with the menu saved inside dist/media/data with reference to each 'data-i18n' attribute.
        -->
        <ul id="js-nav-menu" class="nav-menu">
            <li class="nav-title">Manage Users</li>
            <li class="active">
                <a href="<?= base_url('users') ?>" title="Blank Project" data-filter-tags="blank page">
                    <i class="fal fa-users"></i>
                    <span class="nav-link-text" data-i18n="nav.blankpage">Users</span>
                </a>
            </li>
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
</aside>
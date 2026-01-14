<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin Dashboard') ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=2">
    <?= $this->renderSection('head') ?>
</head>

<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar d-none d-lg-flex flex-column">
            <div class="sidebar-brand">
                <a href="/admin/dashboard">CK Admin</a>
            </div>
            <nav class="sidebar-nav">
                <a class="nav-link <?= active_class('admin/dashboard') ?>" href="/admin/dashboard">Dashboard</a>
                <a class="nav-link <?= active_class('admin/properties*') ?>" href="/admin/properties">Properties</a>
                <a class="nav-link <?= active_class('admin/agents*') ?>" href="/admin/agents">Agents</a>
                <a class="nav-link <?= active_class('admin/pages*') ?>" href="/admin/pages">Pages</a>
            </nav>
            <div class="sidebar-footer mt-auto">
                <a class="btn btn-outline-secondary w-100" href="/logout">Logout</a>
            </div>
        </aside>

        <div class="admin-main">
            <nav class="navbar admin-topbar">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#adminOffcanvas" aria-controls="adminOffcanvas">
                        <i class="bi bi-list"></i> Menu
                    </button>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <span class="text-muted small"><?= esc(session('user_name') ?? 'Admin') ?></span>
                        <a class="btn btn-sm btn-primary" href="/">View Site</a>
                    </div>
                </div>
            </nav>

            <main class="container-fluid py-4">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <div class="offcanvas offcanvas-start admin-offcanvas" tabindex="-1" id="adminOffcanvas"
        aria-labelledby="adminOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="adminOffcanvasLabel">CK Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="sidebar-nav">
                <a class="nav-link <?= active_class('admin/dashboard') ?>" href="/admin/dashboard">Dashboard</a>
                <a class="nav-link <?= active_class('admin/properties*') ?>" href="/admin/properties">Properties</a>
                <a class="nav-link <?= active_class('admin/agents*') ?>" href="/admin/agents">Agents</a>
                <a class="nav-link <?= active_class('admin/pages*') ?>" href="/admin/pages">Pages</a>
                <a class="nav-link mt-3" href="/logout">Logout</a>
            </nav>
        </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>

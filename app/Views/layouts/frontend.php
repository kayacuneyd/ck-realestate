<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Your trusted partner in real estate.">
    <title><?= $title ?? 'Bawue Immobilien' ?></title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body>
    <?php
    // Get logo from settings
    $settingModel = new \App\Models\SettingModel();
    $siteLogo = $settingModel->getValue('site_logo', '');

    $navbarItems = [
        ['href' => '/', 'label' => 'Home'],
        ['href' => '/properties', 'label' => 'Immobilien'],
        ['href' => '/how-it-works', 'label' => 'Wie es funktioniert'],
        ['href' => '/references', 'label' => 'Referenzen'],
        ['href' => '/about', 'label' => 'Über uns'],
        ['href' => '/contact', 'label' => 'Kontakt'],
    ];
    ?>
    <?= view('partials/navbar', [
        'brand' => 'Bawue Immobilien',
        'brandUrl' => '/',
        'navItems' => $navbarItems,
        'cta_link' => '/contact',
        'cta_text' => 'Kostenlose Bewertung',
        'logo' => $siteLogo ?: null,
    ]) ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <?= view('partials/footer') ?>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
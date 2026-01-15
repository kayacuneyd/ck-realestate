<?php

$brand = $brand ?? '';
$brandUrl = $brandUrl ?? '/';
$navItems = $navItems ?? [];
$cta_link = $cta_link ?? null;
$cta_text = $cta_text ?? '';
$logo = $logo ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= esc($brandUrl) ?>">
            <?php if ($logo): ?>
                <img src="<?= esc($logo) ?>" alt="<?= esc($brand) ?>" style="max-height: 40px;">
            <?php else: ?>
                <?= esc($brand) ?>
            <?php endif; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($navItems as $item): ?>
                    <?php
                    $href = $item['href'] ?? '#';
                    $label = $item['label'] ?? '';
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= esc($href) ?>">
                            <?= esc($label) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($cta_link && $cta_text): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-primary" href="<?= esc($cta_link) ?>">
                            <?= esc($cta_text) ?>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
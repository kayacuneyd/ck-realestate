<?php

$title = $title ?? '';
$subtitle = $subtitle ?? '';
$actions = $actions ?? '';
$class = $class ?? '';
$backgroundImage = $backgroundImage ?? null;
$overlayOpacity = $overlayOpacity ?? '0.5';

// For hero class, get background from settings if not provided
if ($class === 'hero' && $backgroundImage === null) {
    $settingModel = new \App\Models\SettingModel();
    $backgroundImage = $settingModel->getValue('hero_background_image', '');
    $overlayOpacity = $settingModel->getValue('hero_overlay_opacity', '0.5');
}

$hasBackground = !empty($backgroundImage);
$bgStyle = $hasBackground ? "background-image: url('" . esc($backgroundImage) . "');" : '';
?>

<header class="page-header <?= esc($class) ?><?= $hasBackground ? ' has-bg-image' : '' ?>" style="<?= $bgStyle ?>">
    <?php if ($hasBackground): ?>
        <div class="page-header-overlay" style="--overlay-opacity: <?= esc($overlayOpacity) ?>;"></div>
    <?php endif; ?>
    <div class="container px-5 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xxl-7">
                <div class="text-center">
                    <h1 class="page-title"><?= esc($title) ?></h1>
                    <?php if ($subtitle): ?>
                        <p class="page-subtitle"><?= esc($subtitle) ?></p>
                    <?php endif; ?>
                    <?php if ($actions): ?>
                        <div class="page-actions"><?= $actions ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
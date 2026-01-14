<?php

$title = $title ?? '';
$subtitle = $subtitle ?? '';
$actions = $actions ?? '';
$class = $class ?? '';
?>

<header class="page-header <?= esc($class) ?>">
    <div class="container px-5">
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

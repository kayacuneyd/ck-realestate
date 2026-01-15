<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<?= view('App\Views\components\page_header', [
    'title' => content('about', 'page_title', 'About CK Real Estate'),
    'subtitle' => content('about', 'page_subtitle', 'A legacy of trust, a future of innovation in real estate.'),
]) ?>

<!-- About section one-->
<section class="py-5 bg-light" id="scroll-target">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="/assets/images/placeholder-wide.svg"
                    alt="Our Office" /></div>
            <div class="col-lg-6">
                <h2 class="fw-bolder"><?= esc(content('about', 'mission_title', 'Our Mission')) ?></h2>
                <p class="lead fw-normal text-muted mb-0">
                    <?= esc(content('about', 'mission_text', 'To provide unparalleled service and expert guidance in the real estate market...')) ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- About section two-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6 order-lg-2"><img class="img-fluid rounded mb-5 mb-lg-0"
                    src="/assets/images/placeholder-wide.svg" alt="Handshake" /></div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="fw-bolder"><?= esc(content('about', 'vision_title', 'Our Vision')) ?></h2>
                <p class="lead fw-normal text-muted mb-0">
                    <?= esc(content('about', 'vision_text', 'To be the real estate company of choice for our clients and agents...')) ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Content Introduction/Intro Text if any specific place needed, or can be used in place of static parts above -->
<!-- Note: Original 'intro_text' mapped in seeder isn't directly used in previous template structure, adding it potentially or just mapping mission/vision as done above. 
         Let's stick to mapping existing layout to the block keys we defined in ContentController/Seeder. 
         We defined: page_title, page_subtitle, intro_text, mission_title, mission_text, vision_title, vision_text.
    -->

<?= $this->endSection() ?>
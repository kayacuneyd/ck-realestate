<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

    <?= view('components/page_header', [
        'title' => 'About CK Real Estate',
        'subtitle' => 'A legacy of trust, a future of innovation in real estate.',
    ]) ?>

    <!-- About section one-->
    <section class="py-5 bg-light" id="scroll-target">
        <div class="container px-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="/assets/images/placeholder-wide.svg" alt="Our Office" /></div>
                <div class="col-lg-6">
                    <h2 class="fw-bolder">Our Mission</h2>
                    <p class="lead fw-normal text-muted mb-0">To provide unparalleled service and expert guidance in the real estate market. We are committed to making the buying and selling of real estate as cost-effective as possible while maintaining the highest level of service.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About section two-->
    <section class="py-5">
        <div class="container px-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6 order-lg-2"><img class="img-fluid rounded mb-5 mb-lg-0" src="/assets/images/placeholder-wide.svg" alt="Handshake" /></div>
                <div class="col-lg-6 order-lg-1">
                    <h2 class="fw-bolder">Our Vision</h2>
                    <p class="lead fw-normal text-muted mb-0">To be the real estate company of choice for our clients and agents, known for our integrity, professionalism, and commitment to our community. We aim to be a leader in the industry through innovation and teamwork.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Signals Section -->
    <section class="py-5 bg-light">
        <div class="container px-5">
            <div class="row gx-5 text-center">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="icon-stack icon-stack-xl bg-primary text-white mb-3"><i class="bi bi-trophy-fill"></i></div>
                    <h3>15+</h3>
                    <p class="lead">Years in Market</p>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="icon-stack icon-stack-xl bg-primary text-white mb-3"><i class="bi bi-check-circle-fill"></i></div>
                    <h3>500+</h3>
                    <p class="lead">Successful Closings</p>
                </div>
                <div class="col-lg-4">
                    <div class="icon-stack icon-stack-xl bg-primary text-white mb-3"><i class="bi bi-star-fill"></i></div>
                    <h3>4.9/5</h3>
                    <p class="lead">Client Rating</p>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>

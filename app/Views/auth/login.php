<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<?= view('components/page_header', [
    'title' => 'Admin Login',
    'subtitle' => 'Sign in to access the Bawue Immobilien admin panel.',
]) ?>

<!-- Login Form Section -->
<section class="py-5">
    <div class="container px-5">
        <div class="bg-light rounded-4 py-5 px-4 px-md-5 mb-5 shadow-sm" style="max-width: 500px; margin: 0 auto;">
            <?= view('components/alerts') ?>
            <form action="/login" method="post">
                <?= csrf_field() ?>
                <!-- Email Input -->
                <div class="form-floating mb-3">
                    <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com"
                        value="<?= old('email') ?>" required autocomplete="email" />
                    <label for="email"><?= lang('Auth.login.email') ?></label>
                </div>
                <!-- Password Input -->
                <div class="form-floating mb-4">
                    <input class="form-control" id="password" name="password" type="password" placeholder="Password"
                        required autocomplete="current-password" />
                    <label for="password"><?= lang('Auth.login.password') ?></label>
                </div>
                <!-- Submit Button -->
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">
                        <i class="bi bi-box-arrow-in-right me-2"></i><?= lang('Auth.login.submit') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
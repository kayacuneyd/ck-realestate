<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Update agent profile details.</p>
    </div>
    <a href="/admin/agents" class="btn btn-outline-secondary">Back to list</a>
</div>

<?= view('components/alerts') ?>

<div class="card admin-card">
    <div class="card-body">
        <form action="/admin/agents/<?= esc($agent->id) ?>" method="post">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'name',
                        'label' => 'Name',
                        'required' => true,
                        'value' => old('name', $agent->name),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'title',
                        'label' => 'Title',
                        'value' => old('title', $agent->title),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'email',
                        'type' => 'email',
                        'label' => 'Email',
                        'required' => true,
                        'value' => old('email', $agent->email),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'phone',
                        'label' => 'Phone',
                        'value' => old('phone', $agent->phone),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'slug',
                        'label' => 'Slug',
                        'help' => 'Leave empty to auto-generate.',
                        'value' => old('slug', $agent->slug),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'photo',
                        'label' => 'Photo URL',
                        'value' => old('photo', $agent->photo),
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= view('components/form_field', [
                        'name' => 'bio',
                        'type' => 'textarea',
                        'label' => 'Bio',
                        'value' => old('bio', $agent->bio),
                        'attributes' => ['rows' => 5],
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= view('components/form_field', [
                        'name' => 'sort_order',
                        'type' => 'number',
                        'label' => 'Sort Order',
                        'value' => old('sort_order', $agent->sort_order ?? 0),
                        'attributes' => ['min' => 0],
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= view('components/form_field', [
                        'name' => 'is_active',
                        'type' => 'checkbox',
                        'label' => 'Active',
                        'value' => 1,
                        'attributes' => old('is_active', (int) $agent->is_active === 1) ? ['checked' => 'checked'] : [],
                    ]) ?>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/admin/agents" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('head') ?>
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <div>
        <h1><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Update page details and visibility.</p>
    </div>
    <a href="/admin/pages" class="btn btn-outline-secondary">Back to list</a>
</div>

<?= view('components/alerts') ?>

<div class="card admin-card">
    <div class="card-body">
        <form action="/admin/pages/<?= esc($page->id) ?>" method="post">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-8">
                    <?= view('components/form_field', [
                        'name' => 'title',
                        'label' => 'Title',
                        'required' => true,
                        'value' => old('title', $page->title),
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= view('components/form_field', [
                        'name' => 'slug',
                        'label' => 'Slug',
                        'help' => 'Leave empty to auto-generate.',
                        'value' => old('slug', $page->slug),
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Content *</label>
                    <div id="page-editor" class="quill-editor"></div>
                    <input type="hidden" id="page-content" name="content" value="">
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'meta_title',
                        'label' => 'Meta Title',
                        'value' => old('meta_title', $page->meta_title),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= view('components/form_field', [
                        'name' => 'meta_description',
                        'label' => 'Meta Description',
                        'value' => old('meta_description', $page->meta_description),
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= view('components/form_field', [
                        'name' => 'is_active',
                        'type' => 'checkbox',
                        'label' => 'Active',
                        'value' => 1,
                        'attributes' => old('is_active', (int) $page->is_active === 1) ? ['checked' => 'checked'] : [],
                    ]) ?>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/admin/pages" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
    (function () {
        var editor = new Quill('#page-editor', {
            theme: 'snow',
            placeholder: 'Write your page content here...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image', 'blockquote', 'code-block'],
                    [{ align: [] }],
                    ['clean']
                ]
            }
        });

        var contentInput = document.getElementById('page-content');
        var form = contentInput.closest('form');
        var initialContent = <?= json_encode(old('content', $page->content)) ?>;
        if (initialContent) {
            editor.root.innerHTML = initialContent;
        }
        contentInput.value = editor.root.innerHTML;

        form.addEventListener('submit', function () {
            contentInput.value = editor.root.innerHTML;
        });

        var toolbar = editor.getModule('toolbar');
        toolbar.addHandler('image', function () {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = function () {
                var file = input.files[0];
                if (!file) {
                    return;
                }

                var data = new FormData();
                data.append('image', file);
                data.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('/admin/pages/upload', {
                    method: 'POST',
                    body: data
                })
                    .then(function (response) { return response.json(); })
                    .then(function (result) {
                        if (!result || !result.url) {
                            alert(result && result.error ? result.error : 'Upload failed');
                            return;
                        }
                        var range = editor.getSelection(true);
                        editor.insertEmbed(range.index, 'image', result.url);
                    })
                    .catch(function () {
                        alert('Upload failed');
                    });
            };
        });
    })();
</script>
<?= $this->endSection() ?>

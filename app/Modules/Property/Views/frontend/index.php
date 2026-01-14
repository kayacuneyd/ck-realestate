<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<?= view('components/page_header', [
    'title' => 'Our Properties',
    'subtitle' => 'Browse listings and filter by what matters most.',
]) ?>

<div class="container py-5">

    <!-- Filter/Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="/properties">
                <?php
                $hasAdvanced = !empty($filters['min_price'] ?? '')
                    || !empty($filters['max_price'] ?? '')
                    || !empty($filters['bedrooms'] ?? '')
                    || !empty($filters['bathrooms'] ?? '')
                    || !empty($filters['min_area'] ?? '')
                    || !empty($filters['max_area'] ?? '')
                    || !empty($filters['type'] ?? '');
                ?>
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="q" placeholder="Search by keyword, address..."
                            value="<?= esc($search ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="city">
                            <option value="">All Cities</option>
                            <?php foreach ($cities ?? [] as $c): ?>
                                <option value="<?= esc($c) ?>" <?= ($city ?? '') === $c ? 'selected' : '' ?>>
                                    <?= esc($c) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">Search</button>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#advancedFilters" aria-expanded="<?= $hasAdvanced ? 'true' : 'false' ?>"
                            aria-controls="advancedFilters">
                            Advanced
                        </button>
                    </div>
                </div>

                <div class="collapse mt-3 <?= $hasAdvanced ? 'show' : '' ?>" id="advancedFilters">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Min Price</label>
                            <input type="number" class="form-control" name="min_price" placeholder="0"
                                value="<?= esc($filters['min_price'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Max Price</label>
                            <input type="number" class="form-control" name="max_price" placeholder="500000"
                                value="<?= esc($filters['max_price'] ?? '') ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Beds</label>
                            <input type="number" class="form-control" name="bedrooms" min="0"
                                value="<?= esc($filters['bedrooms'] ?? '') ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Baths</label>
                            <input type="number" class="form-control" name="bathrooms" min="0"
                                value="<?= esc($filters['bathrooms'] ?? '') ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Type</label>
                            <select class="form-select" name="type">
                                <option value="">Any</option>
                                <option value="sale" <?= ($filters['type'] ?? '') === 'sale' ? 'selected' : '' ?>>Sale</option>
                                <option value="rent" <?= ($filters['type'] ?? '') === 'rent' ? 'selected' : '' ?>>Rent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Min Area (sqm)</label>
                            <input type="number" class="form-control" name="min_area" min="0"
                                value="<?= esc($filters['min_area'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Max Area (sqm)</label>
                            <input type="number" class="form-control" name="max_area" min="0"
                                value="<?= esc($filters['max_area'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="/properties" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Properties Grid -->
    <?php if (empty($properties)): ?>
        <div class="text-center py-5">
            <p>No properties found that match your criteria.</p>
            <a href="/properties" class="btn btn-secondary mt-2">Clear Filters</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($properties as $property): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= esc($property->getMainImage()) ?>" class="card-img-top" alt="<?= esc($property->title) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($property->title) ?></h5>
                            <p class="card-text small text-muted">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                <?= esc($property->address) ?>, <?= esc($property->city) ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="text-primary mb-0">$<?= number_format($property->price) ?></h4>
                                <span class="badge bg-light text-dark"><?= esc(ucfirst($property->type)) ?></span>
                            </div>
                            <div class="d-flex justify-content-around text-center border-top pt-2 mt-2">
                                <div class="px-2">
                                    <i class="bi bi-door-open"></i>
                                    <div class="small"><?= esc($property->bedrooms) ?> Beds</div>
                                </div>
                                <div class="px-2">
                                    <i class="bi bi-droplet"></i>
                                    <div class="small"><?= esc($property->bathrooms) ?> Baths</div>
                                </div>
                                <div class="px-2">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                    <div class="small"><?= esc($property->area_sqm) ?> sqm</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-3">
                             <a href="/properties/<?= esc($property->slug) ?>" class="btn btn-primary w-100">Schedule a Viewing</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
             <div class="mt-5">
                <?= $pager->links() ?>
             </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

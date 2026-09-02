<?php

declare(strict_types=1);

/* [AI:GPT-5.6 | 2026-09-01 05:30:00 UTC] */
if (!theme::render('head', get_defined_vars())) {
    require APPROOT . '/views/inc/head.php';
}

$editItem = is_array($data['edit_item'] ?? null) ? $data['edit_item'] : null;
$items = is_array($data['items'] ?? null) ? $data['items'] : [];
$isEditing = $editItem !== null;
$escape = static fn ($value): string => htmlspecialchars(
    (string) $value,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
$categories = ['maintenance', 'feature', 'fix', 'security', 'release', 'development'];
?>

<p><small><a href="/admin">Admin</a> &gt;&gt; <strong>Changelog</strong></small></p>

<main class="container my-4" aria-labelledby="changelog-admin-title">
    <header class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 id="changelog-admin-title">Changelog</h1>
            <p class="text-body-secondary mb-0">Publish and maintain release history.</p>
        </div>
        <?php if ($isEditing) : ?>
            <a href="/admin/changelog" class="btn btn-outline-secondary">Cancel Edit</a>
        <?php endif; ?>
    </header>

    <section class="card card-body mb-4" aria-labelledby="changelog-form-title">
        <h2 class="h4" id="changelog-form-title">
            <?= $isEditing ? 'Edit Update' : 'Log New Improvement'; ?>
        </h2>

        <form action="/admin/changelog" method="post">
            <?= $this->csrf_field(); ?>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= (int) ($editItem['id'] ?? 0); ?>">

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="changelog-version">Version</label>
                    <input class="form-control" id="changelog-version" name="version"
                        maxlength="20" placeholder="v1.0.0" required
                        value="<?= $escape($editItem['version'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="changelog-category">Category</label>
                    <select class="form-select" id="changelog-category" name="category" required>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $escape($category); ?>"
                                <?= strtolower((string) ($editItem['category'] ?? 'maintenance')) === $category
                                    ? 'selected'
                                    : ''; ?>>
                                <?= $escape(ucfirst($category)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="changelog-date">Release Date</label>
                    <input class="form-control" id="changelog-date" name="date_released"
                        type="date" required
                        value="<?= $escape($editItem['date_released'] ?? date('Y-m-d')); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="changelog-description">Description</label>
                <textarea class="form-control" id="changelog-description" name="description"
                    rows="5" required><?= $escape($editItem['description'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $isEditing ? 'Save Changes' : 'Publish to Log'; ?>
            </button>
        </form>
    </section>

    <section aria-labelledby="changelog-history-title">
        <h2 class="h4" id="changelog-history-title">Release History</h2>

        <?php if ($items === []) : ?>
            <p>No changelog entries found.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Version</th>
                            <th scope="col">Category</th>
                            <th scope="col">Date</th>
                            <th scope="col">Summary</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><strong><?= $escape($item['version'] ?? ''); ?></strong></td>
                                <td><?= $escape(ucfirst((string) ($item['category'] ?? 'maintenance'))); ?></td>
                                <td class="text-nowrap"><?= $escape($item['date_released'] ?? ''); ?></td>
                                <td><?= nl2br($escape($item['description'] ?? '')); ?></td>
                                <td class="text-end text-nowrap">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a class="btn btn-sm btn-outline-primary"
                                            href="/admin/changelog/edit/<?= (int) ($item['id'] ?? 0); ?>">
                                            Edit
                                        </a>
                                        <form action="/admin/changelog" method="post" class="d-inline"
                                            onsubmit="return confirm('Delete this changelog entry?');">
                                            <?= $this->csrf_field(); ?>
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int) ($item['id'] ?? 0); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
if (!theme::render('foot', get_defined_vars())) {
    require APPROOT . '/views/inc/foot.php';
}
/* [End AI:GPT-5.6] */

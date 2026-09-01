<?php

declare(strict_types=1);

/* [AI:GPT-5.6 | 2026-09-01 05:00:00 UTC] */
final class changelog extends controller
{
    private const ADMIN_ACTIONS = ['save', 'delete'];

    public function index(array $params = []): void
    {
        $model = $this->model('changelog_model');
        $this->view('index', ['updates' => $model->getAllUpdates()]);
    }

    public function admin(array $params = []): void
    {
        $this->require_admin(7);
        $model = $this->model('changelog_model');

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $this->require_csrf();
            $action = trim((string) ($_POST['action'] ?? ''));
            if (!in_array($action, self::ADMIN_ACTIONS, true)) {
                http_response_code(400);
                $this->error_page('Invalid Changelog module action.');
            }

            $id = $this->validId($_POST['id'] ?? null);
            if ($action === 'delete') {
                if ($id === null) {
                    $this->invalidRecord();
                }
                $model->deleteUpdate($id);
            } else {
                $model->saveUpdate($this->validatedUpdate($_POST), $id);
            }

            header('Location: /admin/changelog');
            exit;
        }

        $action = (string) ($params[1] ?? $params[0] ?? '');
        $rawId = $params[2] ?? $params[1] ?? null;
        $editItem = null;
        if ($action === 'edit') {
            $id = $this->validId($rawId);
            if ($id === null || !is_array($editItem = $model->getById($id))) {
                $this->invalidRecord();
            }
        }

        $this->view('admin/index', [
            'edit_item' => $editItem,
            'items' => $model->getAllUpdates(),
        ]);
    }

    private function validatedUpdate(array $input): array
    {
        $version = trim((string) ($input['version'] ?? ''));
        $description = trim((string) ($input['description'] ?? ''));
        $category = strtolower(trim((string) ($input['category'] ?? 'maintenance')));
        $date = trim((string) ($input['date_released'] ?? ''));
        $categories = ['maintenance', 'feature', 'fix', 'security', 'release', 'development'];
        if ($version === '' || strlen($version) > 20 || $description === '' || !in_array($category, $categories, true)) {
            http_response_code(422);
            $this->error_page('Enter a valid version, category, and description.');
        }

        $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
        if (!$parsed || $parsed->format('Y-m-d') !== $date) {
            http_response_code(422);
            $this->error_page('Enter a valid release date.');
        }

        return compact('version', 'category', 'description') + ['date_released' => $date];
    }

    private function validId($value): ?int
    {
        $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        return $id === false || $id === null ? null : (int) $id;
    }

    private function invalidRecord(): void
    {
        http_response_code(400);
        $this->error_page('Invalid Changelog record.');
    }
}
/* [End AI:GPT-5.6] */

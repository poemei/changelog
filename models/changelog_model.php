<?php

declare(strict_types=1);

/* [AI:GPT-5.6 | 2026-09-01 05:00:00 UTC] */
final class changelog_model extends model
{
    private const TABLE = 'changelog';

    public function getAllUpdates(): array
    {
        return $this->fetchAll('SELECT * FROM `changelog` ORDER BY `date_released` DESC, `id` DESC');
    }

    public function getById(int $id)
    {
        return $this->fetch('SELECT * FROM `changelog` WHERE `id` = :id LIMIT 1', ['id' => $id]);
    }

    public function deleteUpdate(int $id): void
    {
        $this->query('DELETE FROM `changelog` WHERE `id` = :id', ['id' => $id]);
    }

    public function saveUpdate(array $data, ?int $id): void
    {
        if ($id === null) {
            $this->insert(self::TABLE, $data);
            return;
        }
        $this->update(self::TABLE, $data, 'id = :record_id', ['record_id' => $id]);
    }
}
/* [End AI:GPT-5.6] */

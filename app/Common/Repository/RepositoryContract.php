<?php

namespace App\Common\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryContract
{
    /**
     * @param int $id
     * @return Model|null
     */
    public function get(int $id): ?Model;

    /**
     * @param string[] $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model,array $data): Model;

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool;
}

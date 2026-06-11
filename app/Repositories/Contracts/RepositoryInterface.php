<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    public function findById(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    public function findByField(string $field, mixed $value, array $columns = ['*']): ?Model;

    public function create(array $data): Model;

    public function update(int $id, array $data): bool;

    public function deleteById(int $id): bool;

    public function with(array $relations): static;
}

<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    public function findById(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->with($relations)->select($columns)->find($id)?->append($appends);
    }

    public function findByField(string $field, mixed $value, array $columns = ['*']): ?Model
    {
        return $this->model->where($field, $value)->select($columns)->first();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) $this->model->find($id)?->update($data);
    }

    public function deleteById(int $id): bool
    {
        return (bool) $this->model->find($id)?->delete();
    }

    public function with(array $relations): static
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}

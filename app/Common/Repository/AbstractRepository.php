<?php

namespace App\Common\Repository;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class AbstractRepository implements RepositoryContract, PaginableContract
{
    /**
     * @var string $class
     */
    protected string $class;

    /**
     * @var Model $model
     */
    private Model $model;

    /**
     * HasModelTrait constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (class_exists($this->class) && is_subclass_of($this->class, Model::class, true)) {
            $this->setModel(new $this->class());
        } else {
            throw new Exception('Property $class must be instance of Model!');
        }
    }

    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model::all($columns);
    }

    /**
     * @param int|string $id
     *
     * @return Model|null
     * @throws \InvalidArgumentException
     */
    public function get($id): ?Model
    {
        if (is_int($id) || is_string($id)) {
            return $this->model::find($id);
        }

        throw new \InvalidArgumentException('ID must be integer or string value, ' . gettype($id) . ' given.');
    }

    /**
     * @return Model
     */
    protected function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    private function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function paginate(array $filter = []): array
    {
        $filterBy = Arr::get($filter, self::FIELD_FILTERS, []);
        $page = Arr::get($filter, self::FIELD_CURRENT_PAGE, self::DEFAULT_PAGE);
        $perPage = Arr::get($filter, self::FIELD_PER_PAGE, self::DEFAULT_PER_PAGE);
        $qb = $this->modifyQuery($this->getModel()->newQuery(), $filterBy);
        $paginate = $qb->paginate($perPage, ['*'], self::FIELD_CURRENT_PAGE, $page);

        return $this->preparePaginatorResponse($paginate, $filterBy);
    }

    /**
     * Modify paginate query
     *
     * @param Builder $builder
     * @param array $filterBy
     * @return Builder
     */
    protected function modifyQuery(Builder $builder, array $filterBy = []): Builder
    {
        return $builder;
    }

    /**
     * @param array $items
     * @return AnonymousResourceCollection
     */
    protected function wrapResource(array $items): AnonymousResourceCollection
    {
        return JsonResource::collection($items);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param array $filterBy
     * @return array
     */
    private function preparePaginatorResponse(
        LengthAwarePaginator $paginator,
        array $filterBy = []
    ): array {
        return [
            self::FIELD_TOTAL => $paginator->total(),
            self::FIELD_LAST_PAGE => $paginator->lastPage(),
            self::FIELD_PER_PAGE => $paginator->perPage(),
            self::FIELD_CURRENT_PAGE => $paginator->currentPage(),
            self::FIELD_FILTERS => $filterBy,
            self::FIELD_ITEMS => $this->wrapResource($paginator->items())
        ];
    }
}

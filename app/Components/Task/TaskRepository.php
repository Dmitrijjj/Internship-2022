<?php

namespace App\Components\Task;

use App\Common\Repository\AbstractRepository;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;

class TaskRepository extends AbstractRepository implements TaskRepositoryContract
{
    /**
     * @var string
     */
    protected string $class = Task::class;

    /**
     * @inheritDoc
     */
    public function create(array $data): Task
    {
       return $this->getModel()::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Model $model, array $data): Task
    {
        $model->update($data);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function delete(Model $model): bool
    {
       return $model->delete();
    }

    /**
     * @inheritDoc
     */
    protected function wrapResource(array $items): AnonymousResourceCollection
    {
        return TaskResource::collection($items);
    }

    /**
     * @inheritDoc
     */
    protected function modifyQuery(Builder $builder, array $filterBy = []): Builder
    {
        $status = Arr::get($filterBy, 'status');
        $userId = Arr::get($filterBy, 'user_id');

        return parent::modifyQuery($builder)->when($status,function (Builder $query) use ($status){
            $query->where('status', $status);
        })->when($userId,function (Builder $query) use ($userId){
            $query->where('user_id', $userId);
        });
    }
}

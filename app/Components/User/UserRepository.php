<?php

namespace App\Components\User;

use App\Common\Repository\AbstractRepository;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    /**
     * @var string
     */
    protected string $class = User::class;

    /**
     * @inheritDoc
     */
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->getModel()::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Model $model, array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $model->update($data);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function delete(Model $model): bool
    {
        if (Auth::id() == $model->id)
        {
            throw new InvalidArgumentException('User cannot delete himself', 422);
        }

        return $model->delete();
    }

    /**
     * @inheritDoc
     */
    protected function wrapResource(array $items): AnonymousResourceCollection
    {
        return UserResource::collection($items);
    }
}

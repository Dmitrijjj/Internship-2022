<?php

namespace App\Http\Controllers;

use App\Components\User\UserRepositoryContract;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserIndexRequest $request
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(UserIndexRequest $request, UserRepositoryContract $repository): JsonResponse
    {
        return \response()->json($repository->paginate($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     */
    public function store(UserRequest $request, UserRepositoryContract $repository): JsonResponse
    {
        return \response()->json(UserResource::make($repository->create($request->validated())));
    }

    /**
     * Display the specified resource.
     *
     * @param User $task
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return \response()->json(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user, UserRepositoryContract $repository): JsonResponse
    {
        return  \response()->json(UserResource::make($repository->update($user, $request->validated())));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param UserRepositoryContract $repository
     * @return JsonResponse
     */
    public function destroy(User $user, UserRepositoryContract $repository): JsonResponse
    {
        $repository->delete($user);

        return \response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Components\Task\TaskRepositoryContract;
use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TaskIndexRequest $request
     * @param TaskRepositoryContract $repository
     * @return JsonResponse
     * @throws Exception
     */
    public function index(TaskIndexRequest $request,TaskRepositoryContract $repository): JsonResponse
    {
        return \response()->json($repository->paginate($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @param TaskRepositoryContract $repository
     * @return JsonResponse
     */
    public function store(TaskRequest $request, TaskRepositoryContract $repository): JsonResponse
    {
        return \response()->json(TaskResource::make($repository->create($request->validated())));
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return \response()->json(TaskResource::make($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param Task $task
     * @param TaskRepositoryContract $repository
     * @return JsonResponse
     */
    public function update(TaskRequest $request, Task $task, TaskRepositoryContract $repository): JsonResponse
    {
        return  \response()->json(TaskResource::make($repository->update($task, $request->validated())));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @param TaskRepositoryContract $repository
     * @return JsonResponse
     */
    public function destroy(Task $task, TaskRepositoryContract $repository): JsonResponse
    {
        $repository->delete($task);

        return \response()->json(null, 204);
    }
}

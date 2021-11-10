<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Checklist;
use App\Models\Task;

class TaskController extends Controller
{

    public function store(CreateTaskRequest $request, Checklist $checklist)
    {
        $this->authorize('store', $checklist);
        return new TaskResource(Task::createTask($request->only('content', 'done'), $checklist));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task->checklist);
        return new TaskResource($task->updateTask($request->only('content', 'done')));
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task->checklist);
        $task->deleteTask();
        return response()->json([], 204);
    }
}

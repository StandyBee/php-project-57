<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Label;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $tasks = QueryBuilder::for(task::class)
        ->allowedFilters(
            [
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ]
        )
            ->paginate(15);

        return view('tasks.index', compact('tasks', 'taskStatuses', 'users'));
    }

    public function create()
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.create', compact('taskStatuses', 'users', 'labels'));
    }

    public function store(StoreTaskRequest $request)
    {
        $inputData = $request->validated();

        $user = Auth::user();
        $task = $user->tasks()->make();
        $task->fill($inputData);
        $task->save();
        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $task->labels()->attach($labels);
        flash(__('tasks.Task has been added successfully'))->success();
        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $inputData = $this->validate($request, [
            'name' => 'required|max:255',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|integer'
        ]);

        $task->fill($inputData);
        $task->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $task->labels()->sync($labels);

        flash(__('tasks.Task has been updated successfully'))->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();
        flash(__('tasks.Task has been deleted successfully'))->success();
        return redirect()->route('tasks.index');
    }
}

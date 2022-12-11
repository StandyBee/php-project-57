<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $tasks = Task::orderBy('id')->get();
        return view('tasks.index', compact('tasks', 'taskStatuses', 'users'));
    }

    public function create()
    {
        //$task = new Task();
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.create', compact('taskStatuses', 'users'));
    }

    public function store(StoreTaskRequest $request)
    {
        $inputData = $request->validated();

        $user = Auth::user();
        $task = $user->tasks()->make();
        $task->fill($inputData);
        $task->save();

        flash('success')->success();
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
        return view('tasks.edit', compact('task', 'taskStatuses', 'users'));
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

        flash('succ')->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        flash('Deleted succcess')->success();
        return redirect()->route('tasks.index');
    }
}

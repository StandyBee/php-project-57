<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('id')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $task = new Task();
        return view('tasks.create', compact('task'));
    }

    public function store(StoreTaskRequest $request)
    {
        $inputData = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|integer'
        ]);

        $user = Auth::user();
        $task = $user->tasks()->make();
        $task->fill($inputData);
        $task->save();
        
        flash('success')->succcess();
        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $inputData = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks',
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

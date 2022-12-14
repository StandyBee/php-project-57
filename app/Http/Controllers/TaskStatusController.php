<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->get();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    public function store(StoreTaskStatusRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:task_statuses'
        ]);
        $taskStatus = new TaskStatus();
        $taskStatus->fill($validated);
        $taskStatus->save();
        flash(__('taskStatuses.Status has been added successfully'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:task_statuses,name,' . $taskStatus->id
        ]);
        $taskStatus->fill($validated);
        $taskStatus->save();
        flash(__('taskStatuses.Status has been updated successfully'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('taskStatuses.Failed to delete status'))->error();
            return back();
        }

        $taskStatus->delete();
        flash(__('taskStatuses.Status has been deleted successfully'))->success();
        return redirect()->route('task_statuses.index');
    }
}

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
        $taskStatuses = TaskStatus::get();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return abort(403);
        }
        return view('task_statuses.create');
    }

    public function store(StoreTaskStatusRequest $request)
    {
        if (!Auth::check()) {
            return view('task_statuses.index');
        }
        //$validated = $request->validated();
        $taskStatus = new TaskStatus();
        $taskStatus->fill(['name' => $request]);
        $taskStatus->save();
        flash('Статус создан успешно')->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        if (!Auth::check()) {
            return view('task_statuses.index');
        }

        $taskStatus->fill(['name' => $request]);
        $taskStatus->save();
        flash('Статус успешно изменен')->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        // if ($taskStatus->tasks()->exists()) {
        //     flash('error')->error();
        //     return back();
        // }

        $taskStatus->delete();
        flash('Deleted succcess')->success();
        return redirect()->route('task_statuses.index');
    }
}

@extends('layouts.app')
@section('content')

<div class="grid col-span-full">
    <h1 class="max-w-2xl mb-4 text-4xl leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
        {{ __('layout.task_header') }} </h1>
    <div class="w-full flex items-center">
        <div>
            {{ Form::open(['route' => 'tasks.index','method' => 'GET', 'class' => "form-inline"]) }}
                <div class="flex">
                    <div>
                        {{ Form::select('filter[status_id]', $taskStatuses, request()->input('filter.status_id'), ['class' => 'form-control mr-2', 'placeholder' =>  __('layout.table_task_status')]) }}
                    </div>
                    <div>
                        {{ Form::select('filter[created_by_id]', $users, request()->input('filter.created_by_id'), ['class' => 'form-control mr-2', 'placeholder' =>  __('layout.table_creater')]) }}
                    </div>
                    <div>
                        {{ Form::select('filter[assigned_to_id]', $users, request()->input('filter.assigned_to_id'), ['class' => 'form-control mr-2', 'placeholder' =>  __('layout.table_assigned')]) }}
                    </div>
                    <div>
                        {{ Form::submit(__('layout.create_apply'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
        <div class="ml-auto">
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    @auth()
        @csrf
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('layout.create_button_task') }}</a>
    @endauth
    </div>
    </div>
    <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left" style="text-align: left">
            <tr>
                <th>{{ __('layout.table_id') }}</th>
                <th>{{ __('layout.table_task_status') }}</th>
                <th>{{ __('layout.table_name') }}</th>
                <th>{{ __('layout.table_creater') }}</th>
                <th>{{ __('layout.table_assigned') }}</th>
                <th>{{ __('layout.table_date_of_creation') }}</th>
                @auth()
                    <th>{{ __('layout.table_actions') }}</th>
                @endauth
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
            <tr class="border-b border-dashed text-left">
                <td>{{ $task->id }}</td>
                <td>{{ $taskStatuses[$task->status_id] }}</td>
                <td>
                    <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-900">{{ $task->name }}</a>
                </td>
                <td>{{ $users[$task->created_by_id] }}</td>
                <td>{{ $users[$task->assigned_to_id] ?? '' }}</td>
                <td>{{ $task->created_at->format('d.m.Y') }}</td>
                <td>
                @auth
                @can('delete', $task)
                <a href="{{ route('tasks.destroy', $task) }}"
                    data-method="delete"
                    data-confirm="{{ __('layout.table_delete_question') }}"
                    class="text-red-600 hover:text-red-900">{{ __('layout.table_delete') }}</a>
                @endcan
                <a href="{{ route('tasks.edit', $task) }}"
                    class="text-blue-600 hover:text-blue-900">{{ __('layout.table_edit') }}</a>
                @endauth
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
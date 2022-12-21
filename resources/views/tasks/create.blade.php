@extends('layouts.app')
@section('content')

<div class="grid col-span-full">
        <h1 class="max-w-2xl mb-4 text-4xl leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">{{ __('layout.tasks_create') }}</h1>
    {{ Form::open(['url' => route('tasks.store'), 'method' => 'POST', 'class' => 'w-50']) }}
        <div class="flex flex-col">
            <div class="mt-4">
                {{ Form::label('name', __('layout.table_name')) }}
            </div>
            <div>
                {{ Form::text('name') }}
            </div>
            <div class="text-red-600 hover:text-red-900">
                @if ($errors->any())
                    {{ $errors->first('name') }}
                @endif
            </div>
            <div class="mt-2">
                {{ Form::label('description', __('layout.table_description')) }}
            </div>
            <div>
                {{ Form::textarea('description', '', ['class' => 'rounded border-gray-300 w-1/3 h-32']) }}
            </div>
            <div class="text-red-600 hover:text-red-900">
                @if ($errors->any())
                    {{ $errors->first('description') }}
                @endif
            </div>
            <div>
                {{ Form::label('status_id', __('layout.table_task_status')) }}
            </div>
            <div>
                {{ Form::select('status_id', $taskStatuses, null, ['placeholder' => '----------']) }}
            </div>
            <div class="text-red-600 hover:text-red-900">
                @if ($errors->any())
                    {{ $errors->first('status_id') }}
                @endif
            </div>
            <div>
                {{ Form::label('assigned_to_id', __('layout.table_assigned')) }}
            </div>
            <div>
                {{ Form::select('assigned_to_id', $users, null, ['placeholder' => '----------']) }}
            </div>
            <div class="text-red-600 hover:text-red-900">
                @if ($errors->any())
                    {{ $errors->first('assigned_to_id') }}
                @endif
            </div>
            <div>
                {{ Form::label('labels', __('layout.labels_header')) }}
            </div>
            <div>
                {{ Form::select('labels[]', $labels, null, ['class' => 'form-control rounded border-gray-300 w-1/3 h-32', 'multiple' => 'multiple']) }}
            </div>
            <div>
                {{ Form::submit(__('layout.create_button'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
            </div>
        </div>
    {{ Form::close() }}
</div>

@endsection
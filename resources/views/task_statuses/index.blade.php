@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ __('taskStatuses.Statuses') }}</h1>
        @auth
            <a href="{{ route('task_statuses.create') }}" class="btn btn-info">{{ __('taskStatuses.Create status') }}</a>
        @endauth
        <table class="table mt-2">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('taskStatuses.Status name') }}</th>
                <th>{{ __('taskStatuses.Date of creation') }}</th>
                @if(Auth::check())
                    <th>{{ __('taskStatuses.Actions') }}</th>
                @endif
            </tr>
            </thead>
            @if ($taskStatuses)
                @foreach ($taskStatuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td> {{ $status->name }} </td>
                        <td>{{ $status->created_at }}</td>
                        @auth
                            <td>
                                <a class="text-danger" href="{{ route('task_statuses.destroy', ['task_status' => $status]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('taskStatuses.Are you sure?') }}">{{ __('taskStatuses.Delete') }}</a>
                                <a href="{{ route('task_statuses.edit', ['task_status' => $status]) }}">{{ __('taskStatuses.Edit') }}</a>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
@endsection
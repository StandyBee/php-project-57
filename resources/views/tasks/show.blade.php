@extends('layouts.app')
@section('content')

<div class="grid col-span-full">
<h1>Просмотр задачи: {{ $task->name }}</h1>
<a href="{{ route('tasks.edit', $task) }}">ссылка на edit</a>
<h2>Имя: {{ $task->name }}</h2>
<h2>Статус: {{ $task->status->name }}</h2>
<h2>Описание: {{ $task->description }}</h2>
</div>
@endsection
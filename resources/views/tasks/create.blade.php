@extends('layouts.app')
@section('content')
    <h1>{{ isset($task) ? 'Edit Task' : 'Create Task' }}</h1>
    <form action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}" method="POST">
        @csrf
        @if (isset($task))
            @method('PUT')
        @endif
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ isset($task) ? $task->title : '' }}" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description">{{ isset($task) ? $task->description : '' }}</textarea>
        </div>
        <div>
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ isset($task) ? $task->due_date->format('Y-m-d') : '' }}" required>
        </div>
        <button type="submit">{{ isset($task) ? 'Update' : 'Create' }}</button>
    </form>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Task</h4>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Button to trigger the modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
                Create Task
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->due_date ?? '' }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-info">View | Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tasks->links() }}
        </div>
    </div>

    <!-- Modal for creating a new task -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating a new task -->
                    <form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <!-- Title Field -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        </div>
                        <!-- Due Date Field -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required min="">
                        </div>
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    // Set the minimum date to tomorrow
    document.addEventListener("DOMContentLoaded", function () {
        let today = new Date();
        today.setDate(today.getDate() + 1); // Add one day to get tomorrow's date
        let minDate = today.toISOString().split("T")[0]; // Format as YYYY-MM-DD
        document.getElementById("due_date").setAttribute("min", minDate);
    });
</script>

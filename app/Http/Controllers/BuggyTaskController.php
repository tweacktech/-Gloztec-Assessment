<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Trait\RespondsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class BuggyTaskController extends Controller
{
    use RespondsTrait;
    // No authentication middleware

    public function index()
    {
        try {
            // Retrieve all tasks
            $tasks = Task::all();

            return $this->success($tasks);

        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'required|string|in:pending,completed',
                'due_date'    => 'nullable|date',
            ]);

            // Use mass assignment for creating a task
            $task = Task::create($request->only(['title', 'description', 'status', 'due_date']));

            return $this->success($task);
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'required|string|in:pending,completed',
                'due_date'    => 'nullable|date',
            ]);

            // Find the task, or return a 404 if not found
            $task = Task::find($id);
            if (! $task) {
                return $this->notFound();
            }

            // Update the task using mass assignment
            $task->update($request->only(['title', 'description', 'status', 'due_date']));

            return $this->success($task, 'successfully updated');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Find the task, or return a 404 if not found
            $task = Task::find($id);
            if (! $task) {
                return $this->notFound();
            }

            // Delete the task
            $task->delete();

            return $this->success(null, 'successfully deleted');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }

    }
}

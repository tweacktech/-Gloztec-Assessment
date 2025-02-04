<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // Display a listing of tasks
    public function index()
    {
        $user=Auth()->user();
        $tasks = Task::where('user_id',$user->id)->latest()->paginate(10);
        return view('home', compact('tasks'));
    }

    //store new task
    public function store(Request $request)
    {
        $userId = auth()->user()->id; // Get authenticated user ID
        // Validate input
        $validate = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date|after:today',
        ]);

        // If validation fails, redirect with errors
        if ($validate->fails()) {
            return redirect()->back()->with('status',$validate->errors());
        }

        // Get validated data
        $validatedData = $validate->validated();
        $validatedData['user_id'] = $userId; // Corrected key name

        // Create task
        Task::create($validatedData);

        return redirect()->route('tasks.index')->with('status', 'Task created successfully.');
    }


    public function show(Task $task)
{
    // Get the authenticated user
    $user = auth()->user();

    // Check if the task belongs to the authenticated user
    if ($task->user_id !== $user->id) {
        return redirect()->back()->with('status', 'Unauthorized access to this task.');
    }

    return view('tasks.show', compact('task'));
}


    // Update the specified task
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date|after:today',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Remove the specified task
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}

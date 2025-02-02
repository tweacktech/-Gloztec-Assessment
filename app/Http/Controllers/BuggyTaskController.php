<?php

namespace App\Https\Controllers;

use Illuminate\Https\Request;
use App\Models\Task;
use DB;

class BuggyTaskController extends Controller
{
    // No authentication middleware

    public function index()
    {
        $tasks = Task::all(); 

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        
        $task->title = $request->title; 
        $task->description = $request->description;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return response()->json($task);
    }

    public function destroy($id)
    {
        Task::destroy($id); 

        return response()->json(["message" => "Task deleted"]);
    }
}

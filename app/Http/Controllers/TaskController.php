<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Fetch Data
        $tasks = Task::latest()->paginate(5);
        //Return message and data
        // return response()->json(['Task fetch data has been successfully!', TaskResource::collection($todos)]);

        return view('tasks.index', compact('tasks'));
    }

    public function create() {
        return view('tasks.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check validator
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:500'
        ]);
        //If validator
        if ($validator->fails()) {
            return redirect()->route('tasks.create')->with('error',$validator->errors());
        }
        //Create data
        $task = Task::create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);
        //Return Data
        return redirect()->route('tasks.index')->with('success', 'Task has been created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task) {
        return view('tasks.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //Check validator
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:500'
        ]);
        //If validator fails
        if ($validator->fails()) {
            return redirect()->route('tasks.edit',compact('task'))->with('error', $validator->errors());
        }else {
            //Set data
            $task->name = $request->name;
            $task->desc = $request->desc;
            $task->save();
        }

        //Return message and data
        return redirect()->route('tasks.index')->with('success','Task has been updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //Delete
        $task->delete();

        //Return message
        return redirect()->route('tasks.index')->with('success', 'Task has been deleted successfully!');
    }
}

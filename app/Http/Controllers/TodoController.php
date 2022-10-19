<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Fetch Data
        $todos = Todo::latest()->get();
        //Return message and data
        return response()->json(['Todo fetch has been successfully!',TodoResource::collection($todos)], 200);
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
            'title' => 'required|string|max:255',
            'desc' => 'string|nullable'
        ]);

        //If validator fail
        if ($validator->fails()) {
            //Return validator error message
            return response()->json([$validator->errors()], 400);
        }
        //Create data
        $todo = Todo::create([
            'title' => $request->title,
            'desc' => $request->desc
        ]);
        //Return message and data
        return response()->json(['Todo has been created successfully!', new TodoResource($todo), 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //Return data
        return response()->json([$todo],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */

    public function edit (Todo $todo) {
        return response()->json([$todo], 200);
    }

    public function update(Request $request, Todo $todo)
    {
        //Check validator
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'desc' => 'string|nullable',
            'is_finish' => 'numeric|nullable'
        ]);

        //If validator fails
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 400);
        }



        //Set data
        $todo->title = $request->title;
        $todo->desc = $request->desc;

        if ($request->is_finish) {
            $todo->is_finish = $request->is_finish;
        }

        $todo->save();
        //Return message and data
        return response()->json(['Todo has been updated successfully!', new TodoResource($todo), $request->id, 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //Delete data
        $todo->delete();
        //Return message
        return response()->json(['Todo has been deleted successfully!'], 200);
    }
}

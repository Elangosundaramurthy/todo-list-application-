<?php

namespace App\Http\Controllers;
use App\Http\Requests\TodoRequest;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(){
        $todos=Todo::all();
        return view('todos.index',[
            'todos'=>$todos
        ]);
    }
    public function create(){
        return view('todos.create');
    }
    public function store(TodoRequest $request){
        //return $request->all();
        Todo::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'is_completed'=>0
        ]);
        $request->session()->flash('alert-success','todo created');
        return redirect()->route('todos.index'); 
    }
    public function show($id){
        $todo=todo::find($id);
        if(! $todo){
            return to_route('todos.index')->withErrors([
           'error'=>'unable to locate the todo'
            ]);
        }
        return view('todos.show',['todo'=>$todo]);
        return $id;

    }
    public function edit($id){
        $todo=todo::find($id);
        if(! $todo){
            return to_route('todos.index')->withErrors([
           'error'=>'unable to locate the todo'
            ]);
        }
        return view('todos.edit',['todo'=>$todo]);
        return $id;
    }
    public function update(todoRequest $request){
        $todo=Todo::find($request->todo_id);
        if(! $todo)
        {
            return to_route('todos.index')->withErrors([
           'error'=>'unable to locate the todo'
            ]);
        }
        $todo->update([
        'title'=>$request->title,
        'description'=>$request->description,
        'is_completed'=>$request->is_completed
        ]);
        $request->session()->flash('alert-info','todo updated');
        return redirect()->route('todos.index'); 
    }
    public function destroy(Request $request){
        $todo=Todo::find($request->todo_id);
        if(! $todo)
        {
            return to_route('todos.index')->withErrors([
           'error'=>'unable to locate the todo'
            ]);
        }
        $todo->delete();
        $request->session()->flash('alert-info','todo updated');
        return redirect()->route('todos.index'); 
    }
}



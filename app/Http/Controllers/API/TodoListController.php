<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Todo;
use DateTime;

class TodoListController extends Controller
{
    public function addTodo(Request $request) 
    {
        $todo = new Todo();
        $todo->user_id = auth()->user()->id;
        $todo->description = $request->description;
        $todo->active = $request->active;
        $todo->due =  $request->due_date === null? 'no due' : $request->due_date;
        $todo->save();
        return $todo;
    }

    public function index(Request $request)
    {
        $active = $request->active === 'true';
        $completed = $request->completed ==='true';
        $hard_filter = $request->hard_filter === 'true';

        if($hard_filter) {
            return auth()->user()->todos()
            ->where([
                ['active', $active],
                ['completed', $completed]
            ])->orderBy('created_at','desc')->paginate(5);

        }else{
            return $this->searchFilter($active, $completed);
        }
        
    }
    private function searchFilter($active, $completed) {
        
        if($active && $completed) {
            return auth()->user()->todos()
            ->where([
                ['active', $active],
                ['completed', $completed]
            ])->orderBy('created_at','desc')->paginate(5);
        }
        else if(!$active && !$completed){   
            return auth()->user()->todos()->orderBy('created_at','desc')->paginate(5);
        }
        else if($active){
            return auth()->user()->todos()
            ->where([
                ['active', $active]
            ])->orderBy('created_at','desc')->paginate(5);
        }
        else if($completed) {
            
            return auth()->user()->todos()
            ->where([
                ['completed', $completed]
            ])->orderBy('created_at','desc')->paginate(5);
        }
        else {
            return [];
        }

    }

    public function updateTodo(Request $request, $todo_id)
    {
        $todo = Todo::find($todo_id);
        $todo->description = $request->description;
        $todo->active = $request->active;
        $todo->completed = $request->completed;
        $todo->dateCompleted = $request->completed === true? date('Y-m-d') : '';
        $todo->due =  $request->due_date === null? 'no due' : $request->due_date;
        $todo->save();
        return $todo;
    }
    
    public function removeTodo($id){

        $todo = Todo::find($id);
        $todo->delete();
        return $todo;
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller{

    public function index(){
        $task = Task::OrderBy("id","DESC")->paginate(10);

        $output = [
            "message" => "task",
            "result" => $task
        ];

        return response()->json($task,200);
    }

    public function store(Request $request){
        $input = $request->all(); //mengambil semua input dari user
        $task = Task::create($input); //membuat task baru

        return response()->json($task,200); //mengembalikan data task baru dalam bentuk json
    }

    public function show($id){
        $task = Task::find($id); //mencari task berdasarkan id

        if(!$task){
            abort(404);
        }

        return response()->json($task,200);
    }

    public function update(Request $request, $id){
        $input = $request->all(); //mengambil semua input dari user
        $task = Task::find($id); //mencari task berdasarkan id

        if(!$task){
            abort(404);
        }

        $task->fill($input); //mengisi task dengan data baru dari input
        $task->save(); //menyimpan task ke database

        return response()->json($task,200); //mengembalikan data task yang baru diupdate dalam bentuk json
    }

    public function destroy($id){
        $task = Task::find($id); //mencari task berdasarkan id

        if(!$task){
            abort(404);
        }

        $task->delete(); //menghapus task

        $message = ["message" => "delete success", "task_id" => $id];

        return response()->json($message,200); //mengembalikan pesan ketika task berhasil dihapus
    }
}
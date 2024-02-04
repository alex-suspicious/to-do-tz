<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
 
use App\Models\Task;
use App\Models\User;

class TasksController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function list( Request $request )
    {
        return Task::get();
    }

    public function create( Request $request )
    {
        try {
            $newTask = Task::create([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "text" => $request->input("text"),
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $newTask,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function done_toggle( Request $request )
    {
        try {
            $newTask = Task::where("id", $request->input("id"))->first();
            $newTask->status = ($newTask->status) ? 0 : 1;
            $newTask->save();

            return response()->json([
                'status' => 'success',
                'data' => $newTask,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function set_text( Request $request )
    {
        try {
            $newTask = Task::where("id", $request->input("id"))->first();
            $newTask->text = $request->input("text");
            $newTask->save();

            return response()->json([
                'status' => 'success',
                'data' => $newTask,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}

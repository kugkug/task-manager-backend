<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GlobalException;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function list(Request $request)
    {
        try {
            $tasks = Task::orderBy('created_at', 'desc')->paginate(10);
            return [
                'status' => 'ok',
                'list' => $tasks
            ];
                
        } catch(Exception $e) {
            Log::channel('info')->info("Global : ".$e->getMessage());
            throw new GlobalException();
        }
    }

    public function create(Request $request)
    {
        try {
            $validated = validatorHelper()->validate('task_save', 
                $request->merge([
                    'TaskStatus' => Task::STATUS['Pending'],
                    'TaskCreatedBy' => Auth::id()
                ]
            ));

            if ($validated['status'] === "error") {
                return $validated;
            }
    
            $task = Task::create($validated['validated']);
            return [
                'status' => 'ok',
                'list' => $task
            ];
                
        } catch(Exception $e) {
            Log::channel('info')->info("Global : ".$e->getMessage());
            throw new GlobalException();
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $task =  Task::where('id', $id)->get()->toArray();
            return [
                'status' => 'ok',
                'list' => $task
            ];
                
        } catch(Exception $e) {
            Log::channel('info')->info("Global : ".$e->getMessage());
            throw new GlobalException();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = validatorHelper()->validate('task_update', $request);

            if ($validated['status'] === "error") {
                return $validated;
            }
            
            $task = Task::find($id)->update($validated['validated']);
            return [
                'status' => 'ok',
                'list' => $task
            ];
                
        } catch(Exception $e) {
            Log::channel('info')->info("Global : ".$e->getMessage());
            throw new GlobalException();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $task = Task::find($id)->delete();
            return [
                'status' => 'ok',
                'list' => $task
            ];
                
        } catch(Exception $e) {
            Log::channel('info')->info("Global : ".$e->getMessage());
            throw new GlobalException();
        }
    }
}
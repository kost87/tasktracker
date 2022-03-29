<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Status;


class TasksController extends Controller
{
    private const TASK_VALIDATOR = [
        'title' => 'required|max:50',
        'content' => 'required',
        'deadline' => 'required|date|after:yesterday',
        'user_id' => 'required|integer'
    ];
    private const TASK_ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длиннее :max символов',
        'date' => 'Здесь должна быть дата',
        'after' => 'Дата не может относиться к прошлому',
        'user_id.integer' => 'Не выбран исполнитель'
    ];
    public function index(Request $request)
    {
        switch ($request->sort_by)
        {
            case 'user':
                $query = new Task;
                $query = $query->join('users', 'users.id','=','tasks.user_id');
                $query = $query->select('users.sname as sname','tasks.*');
                $query = $query->orderBy('sname','asc');
                $tasks = $query->get();
                break;
            
            case 'status':
                $tasks = Task::orderBy('status_id')->get();
                break;
            
            case 'deadline':
                $tasks = Task::orderBy('deadline', 'desc')->get();
                break;

            case 'date_done':
                $tasks = Task::orderBy('date_done', 'desc')->get();
                break;

            default:
                $tasks = Task::latest()->get();
                break;
        }
        foreach ($tasks as $task) {
            if ($task->date_done)
            { 
                $task->date_done = date("d F Y", strtotime($task->date_done));
                $task->finished = true;
            }
            else
            {
                $task->date_done = "—";
                if (date("Y-m-d")>$task->deadline) $task->expired = true;
            }
            $task->deadline = date("d F Y", strtotime($task->deadline));
        }
        $context = ['tasks' => $tasks, 'users' => User::get(), 'statuses' => Status::get()];
        
        return view('index', $context);
        
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate(self::TASK_VALIDATOR, self::TASK_ERROR_MESSAGES);
        if (!isset($request->id)) $task = new Task(); else $task = Task::find($request->id);
        $task->fill(['title' => $validated['title'],
                    'content' => $validated['content'],
                    'deadline' => $validated['deadline'],
                    'user_id' => $validated['user_id']]);
        $task->save();
        return redirect()->route('index');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();
        return redirect(request()->headers->get('referer'));
    }

    public function setStatus(Request $request, Task $task)
    {
        $task->status_id = $request->status_id;
        if (Status::find($request->status_id)->name == Task::FINISHED_STATUS) //установка статуса Завершена
        {    
            $task->date_done = date('Y-m-d');  // пишем текущую дату как дату завершеничя
        }
        $task->save();
        return redirect(request()->headers->get('referer'));
    }
}

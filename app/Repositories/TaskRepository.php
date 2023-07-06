<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskInterface
{

    public function getAll()
    {
        $query = Task::with('project_id', 'created_by')->orderByDesc('id');


        if (Auth::user()->role !== 'admin') {
            $query->where('created_by', Auth::id());
        }

        return $query->paginate(20);
    }

    public function findById($id)
    {
        $task = Task::with('project_id', 'created_by')->orderByDesc('id')->findOrFail($id);

        if (Auth::user()->role === 'admin' || $task->created_by === Auth::id()) {
            return $task;
        } else {
            throw new \Exception("No tienes permiso para acceder a este registro.");
        }
    }

    public function create($request)
    {
        $task = Task::create([
            'created_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
        ]);

        return $task;
    }

    public function update($data, $id)
    {
        $task = Task::findOrfail($id);

        if (Auth::user()->role === 'admin' || $task->created_by === Auth::id()) {
            $task->update($data);
            return $task;
        } else {
            throw new \Exception("No tienes permiso para actualizar esta Tarea.");
        }
    }

    public function delete($id)
    {
        $task = Task::findOrfail($id);

        if (Auth::user()->role === 'admin' || $task->created_by === Auth::id()) {
            $task->delete($task);
            return $task;
        } else {
            throw new \Exception("No tienes permiso para eliminar esta Tarea.");
        }
    }

    public function filters($request)
    {
        $query = Task::query();

        if (Auth::user()->role === 'admin') {

        } else {

            $query->where('created_by', Auth::id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('sort_by')) {
            $sortColumn = $request->input('sort_by');

            if ($sortColumn === 'status') {
                $query->orderBy($sortColumn);
            }
        }

        $tasks = $query->get();

        return $tasks;
    }
}

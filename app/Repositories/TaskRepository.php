<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskInterface{

    public function getAll()
    {
        return Task::all();
    }

    public function findById($id)
    {
        return Task::findOrFail($id);
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

        $task->update($data);
        return $task;
    }

    public function delete($id)
    {
        $task = Task::findOrfail($id);

        $task->delete();
        return $task;
    }

}

<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskInterface{

    public function getAll()
    {
        return Task::where('created_by', Auth::id())->with('project_id', 'created_by')->orderByDesc('id')
        ->paginate(10);
    }

    public function findById($id)
    {
        return Task::where('created_by', Auth::id())->findOrFail($id);
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
        $task = Task::where('created_by', Auth::id())->findOrfail($id);

        $task->update($data);
        return $task;
    }

    public function delete($id)
    {
        $task = Task::where('created_by', Auth::id())->findOrfail($id);

        $task->delete();
        return $task;
    }

}

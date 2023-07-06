<?php

namespace App\Repositories;

use App\Interfaces\ProjectInterface;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectInterface
{
    public function getAll()
    {
        return Project::with('members', 'created_by')->get();
    }

    public function findById($id)
    {
        return Project::with('members', 'created_by')->findOrFail($id);
    }

    public function create($request)
    {
        $project = Project::create([
            'created_by' => Auth::id(),
            'title' => $request->title,
            'start_date' => $request->start_date,
            'description' => $request->description,
            'end_date' => $request->end_date,
        ]);

        return $project;
    }

    public function update($data, $id)
    {
        $project = Project::findOrfail($id);

        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        $project = Project::findOrfail($id);

        $project->delete();
        return $project;
    }
}

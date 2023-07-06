<?php

namespace App\Repositories;

use App\Interfaces\ProjectInterface;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectInterface
{
    public function getAll()
    {
        return Project::where('created_by', Auth::id())->with('members', 'created_by')->orderByDesc('id')
            ->paginate(10);
    }

    public function findById($id)
    {
        return Project::where('created_by', Auth::id())->with('members', 'created_by')->findOrFail($id);
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
        $project = Project::where('created_by', Auth::id())->findOrfail($id);

        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        $project = Project::where('created_by', Auth::id())->findOrfail($id);

        $project->delete();
        return $project;
    }
}

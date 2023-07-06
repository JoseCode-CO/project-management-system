<?php

namespace App\Repositories;

use App\Models\ProjectMember;

class ProjectMemberRepository{

    public function getAll()
    {
        return ProjectMember::all();
    }

    public function findById($id)
    {
        return ProjectMember::findOrFail($id);
    }

    public function create($request)
    {
        $project = ProjectMember::create([
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
        ]);

        return $project;
    }

    public function update($data, $id)
    {
        $project = ProjectMember::findOrfail($id);

        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        $project = ProjectMember::findOrfail($id);

        $project->delete();
        return $project;
    }


}

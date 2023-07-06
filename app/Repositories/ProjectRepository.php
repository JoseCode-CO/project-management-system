<?php

namespace App\Repositories;

use App\Interfaces\ProjectInterface;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectInterface
{
    public function getAll()
    {
        $query = Project::with('members', 'created_by', 'tasks', 'tasks.created_by')
            ->orderByDesc('id');

        if (Auth::user()->role !== 'admin') {
            $query->where('created_by', Auth::id());
        }

        return $query->paginate(20);
    }

    public function getAllUsers()
    {
        return Project::with('members', 'created_by', 'tasks', 'tasks.created_by')
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function findById($id)
    {
        $project = Project::with('members', 'created_by')->findOrFail($id);

        if (Auth::user()->role === 'admin' || $project->created_by === Auth::id()) {
            return $project;
        } else {
            throw new \Exception("No tienes permiso para acceder a este registro.");
        }
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
        $project = Project::findOrFail($id);

        if (Auth::user()->role === 'admin' || $project->created_by === Auth::id()) {
            $project->update($data);
            return $project;
        } else {
            throw new \Exception("No tienes permiso para actualizar este Proyecto.");
        }
    }


    public function delete($id)
    {
        $project = Project::findOrFail($id);

        if (Auth::user()->role === 'admin' || $project->created_by === Auth::id()) {
            $project->delete();
            return $project;
        } else {
            throw new \Exception("No tienes permiso para eliminar este Proyecto.");
        }
    }

    public function filters($request)
    {
        $query = Project::with('members', 'created_by', 'tasks', 'tasks.created_by');

        if (Auth::user()->role === 'admin') {
        } else {

            $query->where('created_by', Auth::id());
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '=', $request->input('end_date'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('sort_by')) {
            $sortColumn = $request->input('sort_by');

            if ($sortColumn === 'start_date' || $sortColumn === 'end_date' || $sortColumn === 'status') {
                $query->orderBy($sortColumn);
            }
        }

        $tasks = $query->get();

        return $tasks;
    }
}

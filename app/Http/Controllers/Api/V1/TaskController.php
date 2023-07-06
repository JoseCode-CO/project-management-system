<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function index()
    {
        try {
            $tasks = $this->taskRepository->getAll();
            return response($tasks, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al listar los Tareas", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        try {
            $tasks = $this->taskRepository->create($request);
            return response($tasks, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al crear el Tarea", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $project = $this->taskRepository->findById($id);
            return response($project, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al listar el Tarea", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $attributes = $request->validated();
        try {
            $project = $this->taskRepository->update($attributes, $id);
            return response($project, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al listar el Tarea", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $project = $this->taskRepository->delete($id);
            return response($project, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al eliminar el Tarea", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

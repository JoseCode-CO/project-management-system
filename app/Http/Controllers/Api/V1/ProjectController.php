<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $projects = $this->projectRepository->getAll();
            return response($projects, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al listar los Proyectos", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        try {
            $projects = $this->projectRepository->create($request);
            return response($projects, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al crear el Proyecto", "error" => $ex->getMessage(), "line" => $ex->getCode()
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
            $project = $this->projectRepository->findById($id);
            return response($project, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al listar el Proyecto", "error" => $ex->getMessage(), "line" => $ex->getCode()
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
    public function update(ProjectRequest $request, $id)
    {
        $attributes = $request->validated();
        try {
            $project = $this->projectRepository->update($attributes, $id);
            return response($project, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al listar el Proyecto", "error" => $ex->getMessage(), "line" => $ex->getCode()
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
            $project = $this->projectRepository->delete($id);
            return response($project, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al eliminar el Proyecto", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

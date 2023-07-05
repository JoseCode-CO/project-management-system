<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function register(Request $request)
    {
        try {
            $projects = $this->authRepository->register($request);
            return response($projects, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al crear el Registrar", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {
        try {
            $projects = $this->authRepository->login($request);
            return response($projects, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al Loguearse", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        try {
            $projects = $this->authRepository->logout($request);
            return response($projects, Response::HTTP_OK);
        } catch (\Exception $ex) {
            return  response([
                "message" => "Algo salio mal al cerrar la sesion", "error" => $ex->getMessage(), "line" => $ex->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'status' => 'sometimes|in:Pendiente,En progreso,Completado',
            'project_id' => 'required|exists:projects,id',
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Está enviando un estado invalido, los estados validos son Pendiente,En progreso, y Completado',
            'description.required' => 'La descripcion es requerida.',
            'project_id.required' => 'El proyecto es requerido.',
            'project_id.exists' => 'El proyecto no existe.',
        ];
    }
}

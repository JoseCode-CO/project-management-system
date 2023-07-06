<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                Rule::unique('projects', 'title')->ignore($this->project,'id')
            ],
            'description' => 'required',
            'start_date' => 'required_with:end_date|date',
            'end_date' => 'required_with:start_date|date|after_or_equal:start_date',
            'status' => 'sometimes|in:Pendiente,En progreso,Completado'
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Está enviando un estado invalido, los estados validos son Pendiente,En progreso, y Completado',
            'title.required' => 'El titulo del proyecto es requerido.',
            'title.unique' => 'Ya hay un proyecto con este titulo.',
            'description.required' => 'La descripcion es requerida.',
            'start_date.date' => 'La fecha de inicio no es una fecha válida.',
            'start_date.required_with' => 'Debe enviar la fecha inicio.',
            'end_date.required_with' => 'Debe enviar la fecha final.',
            'end_date.date' => 'La fecha de inicio no es una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser una fecha posterior o igual a la fecha de inicio.'
        ];
    }
}

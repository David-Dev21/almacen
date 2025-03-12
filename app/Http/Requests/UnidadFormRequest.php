<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jefe' => 'required|string|max:30',
            'nombre' => 'required|string|max:50',
            'direccion' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
        ];
    }
    public function messages(): array
    {
        return [
            'jefe.required' => 'El campo jefe es obligatorio.',
            'jefe.string' => 'El jefe debe ser una cadena de texto.',
            'jefe.max' => 'El jefe no puede tener más de 30 caracteres.',
            'nombre.required' => 'El campo nombre de unidad es obligatorio.',
            'nombre.string' => 'El nombre de unidad debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de unidad no puede tener más de 50 caracteres.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 100 caracteres.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
        ];
    }
}

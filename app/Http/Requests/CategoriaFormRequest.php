<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaFormRequest extends FormRequest
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
        $id_categoria = $this->route('categoria') ?? 'NULL';
        return [
            'codigo' => 'required|string|max:30|unique:categorias,codigo,' . $id_categoria . ',id_categoria',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'El campo código es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.max' => 'El código no puede tener más de 30 caracteres.',
            'codigo.unique' => 'El código ya existe en la base de datos.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
            'estado.required' => 'Elija un estado.',
        ];
    }
}

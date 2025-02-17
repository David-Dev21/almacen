<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorFormRequest extends FormRequest
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
        $id_proveedor = $this->route('proveedore') ?? 'NULL';
        return [
            'razon_social' => 'nullable|string|max:30',
            'nombre' => 'required|string|max:30',
            'nit' => 'required|string|max:30|unique:proveedores,nit,' .  $id_proveedor . ',id_proveedor',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required',
            'email' => 'nullable|string|email|max:50|unique:proveedores,email,' .  $id_proveedor . ',id_proveedor',
        ];
    }

    public function messages(): array
    {
        return [
            'razon_social.string' => 'La razón social debe ser una cadena de texto.',
            'razon_social.max' => 'La razón social no puede tener más de 30 caracteres.',
            'nombre.required' => 'El campo nombre de proveedor es obligatorio.',
            'nombre.string' => 'El nombre nombre de proveedor debe ser una cadena de texto.',
            'nombre.max' => 'El nombre nombre de proveedor no puede tener más de 30 caracteres.',
            'nit.required' => 'El campo NIT es obligatorio.',
            'nit.string' => 'El NIT debe ser una cadena de texto.',
            'nit.max' => 'El NIT no puede tener más de 30 caracteres.',
            'nit.unique' => 'El NIT ya existe en la base de datos.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 100 caracteres.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'estado.required' => 'El campo estado es obligatorio.',
            'email.string' => 'El email debe ser una cadena de texto.',
            'email.email' => 'El email debe ser una dirección de correo electrónico válida.',
            'email.max' => 'El email no puede tener más de 50 caracteres.',
            'email.unique' => 'El email ya existe en la base de datos.',
        ];
    }
}

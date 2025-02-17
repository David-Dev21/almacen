<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IngresoFormRequest extends FormRequest
{

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
            // Validaciones para la tabla Ingresos
            'n_factura' => [
                'required',
                'string',
                'max:30',
                Rule::unique('ingresos')
                    ->where('id_proveedor', $this->input('id_proveedor'))
                    ->ignore($this->route('ingresos.edit')) // Ignora el ID si se está editando
            ],
            'id_proveedor' => ['required', 'exists:proveedores,id_proveedor'],
            // Validaciones para la tabla DetalleIngresos
            'lote' => 'required|string|max:20',
            'id_producto' => 'required|array',
            'cantidad_original' => 'required|array',
            'costo_u' => 'required|array',
        ];
    }


    public function messages()
    {
        return [
            // Mensajes personalizados para Ingresos
            'n_factura.required' => 'El número de factura es obligatorio.',
            'n_factura.string' => 'El número de factura debe ser una cadena de texto.',
            'n_factura.max' => 'El número de factura no puede tener más de 30 caracteres.',
            'n_factura.unique' => 'El número de factura ya existe para este proveedor.',
            'id_proveedor.required' => 'El proveedor es obligatorio.',
            'id_proveedor.exists' => 'El proveedor seleccionado no es válido.',

            // Mensajes para la tabla DetalleIngresos
            'lote.required' => 'El lote es obligatorio.',
            'lote.string' => 'El lote debe ser una cadena de texto.',
            'lote.max' => 'El lote no puede tener más de 20 caracteres.',
        ];
    }
}

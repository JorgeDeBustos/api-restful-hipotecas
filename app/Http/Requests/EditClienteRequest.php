<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Validators\CustomValidators;
use Illuminate\Validation\Rule;

class EditClienteRequest extends FormRequest
{
    public $ID_cliente;

    public function __construct($ID_cliente)
    {
        $this->ID_cliente = $ID_cliente;
    }
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'string',
            'dni' => [
                'string',
                Rule::unique('Cliente')->ignore($this->ID_cliente, 'ID_cliente'),
                function ($attribute, $value, $fail) {
                    if (!CustomValidators::isValidDni($value)) {
                        $fail('The dni field must be a valid official dni.');
                    }
                },
            ],
            'email' => [
                'string',
                Rule::unique('Cliente')->ignore($this->ID_cliente, 'ID_cliente'),
                function ($attribute, $value, $fail) {
                    if (!CustomValidators::isValidEmail($value)) {
                        $fail('The email field must be a valid email address.');
                    }
                },
            ],
            'capital_solicitado' => 'required|numeric|gt:0',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class SwiftBankTaxRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "date" => "required|string",
            "name" => "required|string",
            "bsn" => "required|string",
            "birthday" => "required|string",
            "bank_name" => "required|string",
            "full_name" => "required|string",
            "iban" => "required|string",
            "bank_address" => "required|string",
            "fileName" => "required|string",
            "token" => [
                'required',
                Rule::in([env('PDF_TOKEN')]),
            ],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'   => 400,
            'status'   => "error",
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}

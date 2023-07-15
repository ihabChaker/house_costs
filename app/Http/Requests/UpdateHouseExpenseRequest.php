<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseExpenseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'expense_name' => 'required|string',
            'spender_id' => 'required|exists:mysql1.employees,id'
        ];
    }

    public function messages()
    {
        return [
            'amount' => 'المبلغ',
            'expense_name' => 'انفق في',
            'spender_id' => 'اسم المنفق'
        ];
    }
}
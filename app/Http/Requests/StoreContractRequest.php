<?php
// app/Http/Requests/StoreContractRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gate with auth/abilities if needed
    }

    public function rules(): array
    {
        return [
            'pdf_file' => ['required', 'file', 'mimes:pdf', 'max:20480'], // up to 20MB
            'name' => ['required', 'string', 'max:255'],
            'contract_number' => ['required', 'string', 'max:50'],
            'date_signed' => ['required', 'date_format:Y-m-d'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'date_desk' => ['required', 'date_format:Y-m-d'],
            'contract_value' => ['required', 'integer', 'min:0'],
            'deposit' => ['required', 'integer', 'min:0', 'lte:contract_value'],
            'status' => ['required', 'integer', 'in:0,1,2,3'], // adjust to your enum
        ];
    }
}

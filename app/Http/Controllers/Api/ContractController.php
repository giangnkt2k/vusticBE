<?php

namespace App\Http\Controllers\API;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index()
    {
        return response()->json(Contract::with('customer')->paginate(10));
    }

    public function show($id)
    {
        $contract = Contract::with('customer')->findOrFail($id);
        return response()->json($contract);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $customerData = $request->input('customer');
            $companyData = $request->input('company');
            $company = null;
            if ($companyData) {
                $company = Company::firstOrCreate([
                    'name' => $companyData['name']
                ], $companyData);
            }

            // $customer = Customer::create(array_merge($customerData, [
            //     'company_tax_code' => $company ? $company->tax_code : null
            // ]));

            // UploadFile pdf
            if (!Storage::exists('public/contracts')) {
                Storage::makeDirectory('public/contracts');
            }
            if (isset($request->pdf_file)) {

                $fileName = time() . '_' . $request->file('pdf_file')->getClientOriginalName();
                $pdfPath = $request->file('pdf_file')->storeAs('public/contracts', $fileName);
            }

            $contract = Contract::create([
                'name' => $request->input('name'),
                'contract_number' => $request->input('contract_number'),
                'date_signed' => $request->input('date_signed'),
                // 'customer_id' => $customer->id,
                'customer_id' => $request->input('customer_id'),
                'date_desk' => $request->input('date_desk'),
                'contract_value' => $request->input('contract_value'),
                'deposit' => $request->input('deposit'),
                'status' => $request->input('status'),
                'pdf_file' => $pdfPath ?? null
            ]);

            DB::commit();
            return response()->json($contract, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $contract->update($request->only([
            'date_signed',
            'customer_id',
            'date_desk',
            'contract_value',
            'deposit',
            'status',
        ]));
        return response()->json($contract);
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();
        return response()->json(null, 204);
    }
}

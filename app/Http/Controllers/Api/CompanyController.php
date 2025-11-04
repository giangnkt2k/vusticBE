<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::all());
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function store(Request $request)
    {
        $company = Company::create($request->validate([
            'name' => 'required|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'ceo' => 'nullable|string|max:255',
        ]));
        return response()->json($company, 201);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'ceo' => 'nullable|string|max:255',
        ]));
        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, 204);
    }
}

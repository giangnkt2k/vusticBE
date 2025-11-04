<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (isset($search)) {
            $search = trim($search);
            $customers = Customer::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->get();
        } else {
            $customers = Customer::all();
        }

        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_tax_code' => 'nullable',
            'company_name' => 'nullable|string|max:255',
            'contact_point' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]));
        return response()->json($customer, 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_tax_code' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_point' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]));
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['message' => 'Đã xoá thành công'], 204);
    }
}

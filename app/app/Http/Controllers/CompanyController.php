<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nit' => 'required|unique:companies|max:20',
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
            ]);

            $company = Company::create($validated);
            return response()->json($company, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the company'], 500);
        }
    }

    public function show($nit)
    {
        try {
            $company = Company::where('nit', $nit)->firstOrFail();
            return response()->json($company);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Company not found'], 404);
        }
    }

    public function index()
    {
        try {
            $companies = Company::all();
            if ($companies->isEmpty()) {
                return response()->json(['message' => 'No companies found'], 404);
            }
            return response()->json($companies);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching companies'], 500);
        }
    }

    public function update(Request $request, $nit)
    {
        try {
            if ($request->has('nit')) {
                return response()->json(['error' => 'NIT cannot be updated'], 400);
            }

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:100',
                'address' => 'sometimes|required|string|max:255',
                'phone' => 'sometimes|required|string|max:15',
                'status' => 'sometimes|required|string|in:Active,Inactive',
            ]);

            $company = Company::where('nit', $nit)->firstOrFail();
            $company->update($validated);
            return response()->json($company);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Company not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the company'], 500);
        }
    }

    public function destroy($nit)
    {
        try {
            $company = Company::where('nit', $nit)->firstOrFail();
            if ($company->status === 'Inactive') {
                $company->delete();
                return response()->json(['message' => 'Company deleted successfully'], 200);
            }
            return response()->json(['error' => 'Only inactive companies can be deleted'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Company not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the company'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\StoreRequest;
use App\Http\Requests\Api\Company\UpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $companies = Cache::rememberForever('companies-page-' . request('page', 1), function () {
            return Company::paginate(Company::PER_PAGE);
        });

        return CompanyResource::collection($companies);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $company = Company::create($request->validated());

        return response()->json([
            'data' => new CompanyResource($company)
        ], 201);
    }

    public function show(Company $company): CompanyResource
    {
        // Example of how the company will be cached
        $company = Cache::rememberForever("company-{$company->id}", function () use ($company) {
            return $company;
        });

        return new CompanyResource($company);
    }

    public function update(UpdateRequest $request, Company $company): CompanyResource
    {
        $company->update($request->validated());

        return new CompanyResource($company);
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->employees()->delete();
        $company->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employee\StoreRequest;
use App\Http\Requests\Api\Employee\UpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $employees = Cache::rememberForever('employees-page-' . request('page', 1), function () {
            return Employee::paginate(Employee::PER_PAGE);
        });

        return EmployeeResource::collection($employees);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());

        return response()->json([
            'data' => new EmployeeResource($employee)
        ], 201);
    }

    public function show(Employee $employee): EmployeeResource
    {
        // Example of how the employee will be cached
        $employee = Cache::rememberForever("employee-{$employee->id}", function () use ($employee) {
            return $employee;
        });

        return new EmployeeResource($employee);
    }

    public function update(UpdateRequest $request, Employee $employee): EmployeeResource
    {
        $employee->update($request->validated());

        return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json(null, 204);
    }
}

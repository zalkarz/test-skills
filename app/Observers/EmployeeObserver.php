<?php

namespace App\Observers;

use App\Models\Employee;
use Illuminate\Support\Facades\Cache;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        $this->clearCache($employee);
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        $this->clearCache($employee);
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        $this->clearCache($employee);
    }

    private function clearCache($employee): void
    {
        Cache::forget("employee-{$employee->id}");

        // Efficient workaround to clear cached pages
        // It's better to use cache tags if the driver supports them
        $totalResults = Employee::count();
        $totalPages = ceil($totalResults/Employee::PER_PAGE) + 1;

        for ($i = 1; $i < $totalPages; $i++) {
            Cache::forget('employees-page-' . $i);
        }
    }
}

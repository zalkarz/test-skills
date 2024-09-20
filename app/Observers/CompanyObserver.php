<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        $this->clearCache($company);
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        $this->clearCache($company);
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        $this->clearCache($company);
    }

    private function clearCache($company): void
    {
        Cache::forget("company-{$company->id}");

        // Efficient workaround to clear cached pages
        // It's better to use cache tags if the driver supports them
        $totalResults = Company::count();
        $totalPages = ceil($totalResults/Company::PER_PAGE) + 1;

        for ($i = 1; $i < $totalPages; $i++) {
            Cache::forget('companies-page-' . $i);
        }
    }
}

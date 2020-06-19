<?php

declare(strict_types=1);

namespace Modules\User\App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;

class TenantManager
{
    private $tenant;
    private static $tenantTable = 'tenants';
    private static $tenantField = 'tenant_id';
    private static $tenantName = 'Empresa';
    private static $tenantModel = Tenant::class;

    public function getTenantTable(): string
    {
        return self::$tenantTable;
    }

    public function getTenantField(): string
    {
        return self::$tenantField;
    }

    public function getTenantModel(): string
    {
        return self::$tenantModel;
    }

    public function getTenantName(): string
    {
        return self::$tenantName;
    }

    public function getTenant()
    {
        return $this->tenant;
    }

    public function setTenant($tenant): void
    {
        $this->tenant = $tenant;
    }

    public function bluePrintMacros()
    {
        Blueprint::macro('tenant', function () {
            $this->bigInteger(\Tenant::getTenantField())->unsigned();
            $this
                ->foreign(\Tenant::getTenantField())
                ->references('id')
                ->on(\Tenant::getTenantTable());
        });
    }

    public function ruleExists()
    {
        return "{$this->getTenantField()},".($this->getTenant()->id ?? request()->{\Tenant::getTenantField()});
    }
}

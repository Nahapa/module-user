<?php

namespace Modules\User\App\Tenant;


use Illuminate\Database\Eloquent\Model;

trait TenantModels
{

    protected static function bootTenantModels()
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (Model $obj) {
            $tenantObj = \Tenant::getTenant();
            if ($tenantObj) {
                $obj->{\Tenant::getTenantField()} = $tenantObj->id;
            } else if (request()->{\Tenant::getTenantField()}) {
                $obj->{\Tenant::getTenantField()} = request()->{\Tenant::getTenantField()};
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(\Tenant::getTenantModel(), \Tenant::getTenantField());
    }
}

<?php
/**
 * User: kewan
 * Date: 25/3/18
 * Time: 3:54 PM
 */

namespace Kewan\Squatter\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Kewan\Squatter\Facades\Squatter;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($tenant = Squatter::tenant()) {
            return $builder->where($model->getTable() . '.' . $tenant->getForeignKey(), $tenant->id);
        }
    }
}
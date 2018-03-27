<?php
/**
 * User: kewan
 * Date: 27/3/18
 * Time: 2:00 PM
 */

namespace Kewan\Squatter\Relations;

use Kewan\Squatter\Scopes\TenantScope;

trait BelongsToTenant
{
    public static function bootSquatter() {
        static::addGlobalScope(new TenantScope());
    }
}
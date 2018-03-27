<?php
/**
 * User: kewan
 * Date: 27/3/18
 * Time: 2:05 PM
 */

namespace Kewan\Squatter\Facade;


use Illuminate\Support\Facades\Facade;
use Kewan\Squatter\TenantManager;

class Squatter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TenantManager::class;
    }
}
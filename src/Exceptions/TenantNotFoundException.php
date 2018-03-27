<?php
/**
 * User: kewan
 * Date: 25/3/18
 * Time: 3:47 PM
 */

namespace Kewan\Squatter\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class TenantNotFoundException extends ModelNotFoundException
{
}
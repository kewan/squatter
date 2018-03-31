<?php

namespace Kewan\Squatter\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueTenantSubdomain implements Rule
{
    /**
     * @var string
     */
    protected $tenantClass;

    /**
     * @var string
     */
    protected $subdomainField;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tenantClass = config('squatter.class');
        $this->subdomainField = config('squatter.subdomain_field_name');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $existingTenant = (new $this->tenantClass)->where($this->subdomainField, $value)->count();
        return $existingTenant == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is already taken.';
    }
}

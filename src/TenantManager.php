<?php

namespace Kewan\Squatter;

use Illuminate\Database\Eloquent\Model;
use Kewan\Squatter\Exceptions\TenantNotFoundException;

class TenantManager {
    protected $subdomain;

    protected $tenantClass;

    protected $subdomainField;

    protected $tenant;

    public function __construct($host, $tenantClass, $subdomainField)
    {
        $this->subdomain = preg_replace('/^([^\.]+).*/', '$1', $host);

        $this->tenantClass = $tenantClass;
        $this->subdomainField = $subdomainField ?: 'subdomain';
    }

    public function set(Model $tenant) {
        $this->tenant = $tenant;
        $this->subdomain = $tenant->{$this->subdomainField};
    }

    public function tenant()
    {
        if (in_array($this->subdomain, config('squatter.reserved_subdomains'))) {
            return null;
        }
        
        if($this->tenant && $this->subdomain == $this->tenant->{$this->subdomainField}) {
            return $this->tenant;
        }

        $this->tenant = (new $this->tenantClass)->where($this->subdomainField, $this->subdomain)->first();

        if(!$this->tenant) {
            throw new TenantNotFoundException(sprintf("Tenant not found for %s=%s", $this->subdomainField, $this->subdomain));
        }

        return $this->tenant;
    }
}

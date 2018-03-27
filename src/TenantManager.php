<?php

namespace Kewan\Squatter;

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

    public function tenant()
    {
        if($this->tenant && $this->subdomain == $this->tenant->subdomain) {
            return $this->tenant;
        }

        $this->tenant = (new $this->tenantClass)->where($this->subdomainField, $this->subdomain)->first();

        if(!$this->tenant) {
            throw new TenantNotFoundException(sprintf("Tenant not found for %s=%s", $this->subdomainField, $this->subdomain));
        }

        return $this->tenant;
    }
}

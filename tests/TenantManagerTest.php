<?php
/**
 * Responsible for finding a tenant based on the subdomain
 * User: kewan
 */

namespace Kewan\Squatter\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Kewan\Squatter\Exceptions\TenantNotFoundException;
use Kewan\Squatter\TenantManager;
use Kewan\Squatter\Tests\Fixtures\Tenant;

class TenantManagerTest extends \PHPUnit\Framework\TestCase
{
    public $tenant;

    public function setUp()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        Capsule::schema()->create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('subdomain');
        });

        $this->tenant = Tenant::create(['name' => 'One', 'subdomain' => 'one']);
    }

    public function testFindValidTenant()
    {
        $tenantManager = new TenantManager('one.test.com', Tenant::class, 'subdomain');
        $this->assertEquals($this->tenant->id, $tenantManager->tenant()->id);
    }

    public function testFindInValidTenant()
    {
        $tenantManager = new TenantManager('two.test.com', Tenant::class, 'subdomain');

        $this->expectException(TenantNotFoundException::class);

        $tenantManager->tenant();
    }

    public function testFindByIncorrectSubdomainFieldName()
    {
        $tenantManager = new TenantManager('one.test.com', Tenant::class, 'sub');

        $this->expectException(TenantNotFoundException::class);

        $tenantManager->tenant();
    }
}
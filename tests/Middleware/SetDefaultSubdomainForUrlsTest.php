<?php
/**
 * Created by PhpStorm.
 * User: kewan
 * Date: 1/4/18
 * Time: 11:29 AM
 */

namespace Kewan\Squatter\Tests\Middleware;

use Illuminate\Support\Facades\URL;
use Kewan\Squatter\Middleware\SetDefaultSubdomainForUrls;
use PHPUnit\Framework\TestCase;

class SetDefaultSubdomainForUrlsTest extends TestCase
{
    private $request;

    public function setUp() {
        $this->request = \Mockery::mock();
        $this->request->allows()->getHost()->andReturns('example.test.com');
    }

    public function testHandle()
    {
        $middleware = new SetDefaultSubdomainForUrls();
        $middleware->handle($this->request, function() {});

        $this->assertEquals('example', $this->request->subdomain);

    }
}

<?php

namespace ForceHttps\Tests;

use ForceHttps\Middleware\RedirectToHttps;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class MiddlewareTest extends TestCase {

    /** @test */
    public function redirect_always() {
        Config::set( 'force-https.conditions.always', true );

        $request = new Request();

        $middleware = new RedirectToHttps();

        /** @var RedirectResponse $result */
        $result = $middleware->handle($request, function ($req) {
            // should never call
            $this->assertFalse(true);
        });

        $this->assertInstanceOf(RedirectResponse::class, $result);

        $this->assertEquals(301, $result->status());
        $this->assertStringStartsWith('https://', $result->getTargetUrl());
    }

    /** @test */
    public function not_redirect() {
        Config::set( 'force-https.conditions.always', false );

        $request = new Request();

        $middleware = new RedirectToHttps();

        $result = $middleware->handle($request, function ($req) {
            // should never call
            $this->assertTrue(true);

            return null;
        });

        $this->assertNull($result);
    }

    /** @test */
    public function redirect_query() {
        Config::set( 'force-https.conditions.always', false );
        Config::set( 'force-https.conditions.envs', [
            'testing','dev'
        ] );
        Config::set( 'force-https.redirect.query', true );

        $request = new Request();

        $request->merge([
            'test' => 'foo'
        ]);

        $middleware = new RedirectToHttps();

        /** @var RedirectResponse $result */
        $result = $middleware->handle($request, function ($req) {
            // should never call
            $this->assertFalse(true);
        });

        $this->assertInstanceOf(RedirectResponse::class, $result);

        $this->assertEquals(301, $result->status());
        $this->assertStringStartsWith('https://', $result->getTargetUrl());
        $this->assertStringContainsString('test=foo', $result->getTargetUrl());
    }
}

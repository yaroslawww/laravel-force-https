<?php

namespace ForceHttps\Tests;

class ConfigFileTest extends TestCase {

    /** @test */
    public function config_correct_parse_envs() {
        $this->assertTrue(config('force-https.conditions.always'));

        $this->assertTrue(is_array(config('force-https.conditions.envs')));
        $this->assertCount(2, config('force-https.conditions.envs'));
        $this->assertEquals('dev', config('force-https.conditions.envs.0'));
        $this->assertEquals('production', config('force-https.conditions.envs.1'));

        $this->assertFalse(config('force-https.redirect.query'));
        $this->assertEquals(301, config('force-https.redirect.status'));
        $this->assertEmpty(config('force-https.redirect.headers'));
        $this->assertTrue(is_array(config('force-https.redirect.headers')));
    }
}

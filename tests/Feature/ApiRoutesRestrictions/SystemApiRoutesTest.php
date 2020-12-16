<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de sistemas.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/system/index');

        $response->assertStatus(401);

        $response = $this->call('POST', '/api/system/allowed/index');

        $response->assertStatus(401);

        $response = $this->call('GET', '/api/system/show');

        $response->assertStatus(401);

        $response = $this->call('POST', '/api/system/guard/inite_beds/update');

        $response->assertStatus(401);

        $response = $this->call('POST', '/api/system/guard/available');

        $response->assertStatus(401);

    }
}

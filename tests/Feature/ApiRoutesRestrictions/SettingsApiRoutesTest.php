<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de configuraciones del sistema.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/settings/rules/show');

        $response->assertStatus(401);

        $response = $this->call('POST', '/api/settings/rules/update');

        $response->assertStatus(401);
    }
}

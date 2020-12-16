<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvolutionApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de evoluciones.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('POST', '/api/evolution/store');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/evolution/update');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/evolution/form_data');
        
        $response->assertStatus(401);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de médicos.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/medic/index');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/medic/assigned/index');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/medic/index/1');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/medic/store');
        
        $response->assertStatus(401);
    }
}

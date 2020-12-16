<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicalEnsuranceApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de seguros médicos.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/medical_ensurance/index');
        
        $response->assertStatus(401);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientStateApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de estados de pacientes.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/patient_state/index');

        $response->assertStatus(401);
    }
}

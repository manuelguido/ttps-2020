<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de pacientes.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/patient/index');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/patient/assigned/index');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/patient/index/1');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/store');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/new_entry');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/update');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/search');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/patient/clinic_data/1');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/system/change');
        
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/patient/medics/1');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/medic/add');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/medic/remove');
        
        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/declare/exit');

        $response->assertStatus(401);

        $response = $this->call('POST', '/api/patient/declare/death');
    }
}

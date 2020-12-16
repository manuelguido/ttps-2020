<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationApiRoutesTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de autenticación.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('POST', '/api/logout');
        
        $response->assertStatus(401);
    }
}

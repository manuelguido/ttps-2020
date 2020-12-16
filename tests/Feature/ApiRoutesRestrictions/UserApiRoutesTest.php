<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * Test de restricción de rutas de API de usuarios.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/api/user');
        $response->assertStatus(401);

        $response = $this->call('GET', '/api/user/index');
        $response->assertStatus(401);
        
        $response = $this->call('GET', '/api/user/role');
        $response->assertStatus(401);
        
        $response = $this->call('GET', '/api/user/system');
        $response->assertStatus(401);
        
        $response = $this->call('GET', '/api/user/routes');
        $response->assertStatus(401);
        
        $response = $this->call('GET', '/api/user/full');
        $response->assertStatus(401);
        
        $response = $this->call('POST', '/api/user/profile/update');
        $response->assertStatus(401);
        
    }
}

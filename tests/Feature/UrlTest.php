<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlTest extends TestCase
{
   
    public function testUrlTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
    }
}

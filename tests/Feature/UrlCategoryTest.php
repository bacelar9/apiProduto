<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UrlCategoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexTest()
    {
        foreach([1,2,3,4,5] as $i){
            $data = ['description' => 'categoria 0'.$i];
            \App\Category::create($data);
        }
        
        $this->get('api/category')
            ->assertStatus(200)
            ->assertJsonStructure([
                    '*' => [
                        'description',
                        'id',
                        'created_at',
                        'updated_at'
                    ]
                
            ]);
    }

    public function testPostTest()
    {
        $data= ['description' => 'Categoria 21'];
        $this->post('api/category', $data )
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function testGetTest()
    {
        $data= ['description' => 'Categoria 21'];
        $response = $this->post('api/category', $data )
            ->assertStatus(201)
            ->assertJson($data);

        $category = json_decode($response->getContent());
        $show = $this->get('api/category/'.$category->id);
        $show->assertStatus(200)
            ->assertJson($data);

    }

    public function testPostInDataBaseTest()
    {
        $data= ['description' => 'Categoria 21'];
        $response = $this->post('api/category', $data );
        $this->assertDatabaseHas('categories', $data);
    }

    public function testPuttInDataBaseTest()
    {
        $data= ['description' => 'Categoria 21'];
        $response = $this->post('api/category', $data );
        $category = json_decode($response->getContent());
                
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    
        $data_new= ['description' => 'New Categoria 1'];
        $this->put('api/category/'.$category->id, $data_new )
            ->assertStatus(201)
            ->assertJson($data_new);
        $this->assertDatabaseHas('categories', ['id' => $category->id] + $data_new);   
    }

    public function testDeleteTest()
    {
        $data= ['description' => 'Categoria 21'];
        $response = $this->post('api/category', $data );
        $category = json_decode($response->getContent());

        //check in database
        $this->assertDatabaseHas('categories', $data);

        $this->delete('api/category/'.$category->id)
            ->assertStatus(200);
        
        $this->assertDatabaseMissing('categories', $data);
    }
   
}

<?php
namespace Tests\Feature;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UrlProductTest extends TestCase
{
    use DatabaseTransactions;
    public function testIndexTest()
    {
        $category_data = ['description' => 'categoria 00'];
        $category = \App\Category::create($category_data);

        foreach([1,2,3,4,5] as $i){
            $product_data = [
                'Im' => 1001 + $i,
                'name' => 'Furadeira X',  
                'free_shipping' => 1,
                'description' => 'Furadeira eficiente X',
                'price' => 100.00,
                'category_id' => $category->id
            ];
            \App\Product::create($product_data);
        }
        
        $this->get('api/product')
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

    public function testGetTest()
    {
        $category_data = ['description' => 'categoria 00'];
        $category = \App\Category::create($category_data);

        $product_data = [
            'Im' => 1001,
            'name' => 'Furadeira X',  
            'free_shipping' => 1,
            'description' => 'Furadeira eficiente X',
            'price' => 100.00,
            'category_id' => $category->id
        ];
        $product = \App\Product::create($product_data);
        $show = $this->get('api/product/'.$product->id);
        $show->assertStatus(200)
            ->assertJson($product_data);
    }

    public function testPuttInDataBaseTest()
    {
        $category_data = ['description' => 'categoria 00'];
        $category = \App\Category::create($category_data);
        $product_data = [
            'Im' => 1001,
            'name' => 'Furadeira X',  
            'free_shipping' => 1,
            'description' => 'Furadeira eficiente X',
            'price' => 100.00,
            'category_id' => $category->id
        ];
        $product = \App\Product::create($product_data);

        $data_new= ['description' => 'Novo Produto 1'];
        $this->put('api/product/'.$product->id, $data_new )
            ->assertStatus(201)
            ->assertJson($data_new);
        $this->assertDatabaseHas('products', ['id' => $product->id] + $data_new);   
    }

    public function testDeleteTest()
    {
        $category_data = ['description' => 'categoria 00'];
        $category = \App\Category::create($category_data);

        $product_data = [
            'Im' => 1001,
            'name' => 'Furadeira X',  
            'free_shipping' => 1,
            'description' => 'Furadeira eficiente X',
            'price' => 100.00,
            'category_id' => $category->id
        ];
        $product = \App\Product::create($product_data);
      
        //check in database
        $this->assertDatabaseHas('products', $product_data); 
        $this->delete('api/product/'.$product->id)
            ->assertStatus(200);
        //not in database
        $this->assertDatabaseMissing('products', $product_data);
    }
   
}

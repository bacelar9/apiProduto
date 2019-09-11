<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;    
    
    

    public function testCreateTest()
    {
        $data = ['description' => 'categoria 00'];
        \App\Category::create($data);
        $this->assertDatabaseHas('categories', $data);
    }

    public function testUpdateTest()
    {
        $data = ['description' => 'nova categoria'];
        $altered = ['description' => 'nova categoria 02'];
        $category = \App\Category::create($data);
        $category->update($altered);
        //find new values
        $this->assertDatabaseHas('categories', $altered);
        //not find old values
        $this->assertDatabaseMissing('categories', $data);
    }

    public function testDeleteTest()
    {
        $data = ['description' => 'nova categoria'];
        $category = \App\Category::create($data);
        
        //confirm insert
        $this->assertDatabaseHas('categories', $data);
        $category->delete();

        //confirm removed data
        $this->assertDatabaseMissing('categories', $data);
    }

    public function testHasManyTest()
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
        $this->assertDatabaseHas('products', $product_data);    
        $this->assertEquals($category->toArray(), $product->category->toArray());
    }

    public function testNotHasManyTest()
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
        $this->assertDatabaseHas('products', $product_data);    

        $category_data_1 = ['description' => 'categoria 02'];
        $category_1 = \App\Category::create($category_data_1);
        $product_data_1 = [
            'Im' => 1002,
            'name' => 'Furadeira X',  
            'free_shipping' => 1,
            'description' => 'Furadeira eficiente X',
            'price' => 100.00,
            'category_id' => $category_1->id
        ];
        $product_1 = \App\Product::create($product_data_1); 
        //not in
        $this->assertNotContains($product_1->toArray(), $category->products->toArray() );

    }
}

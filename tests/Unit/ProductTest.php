<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use DatabaseTransactions;    
    
    public function testCreateTest()
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
        \App\Product::create($product_data);        
        $this->assertDatabaseHas('products', $product_data);
    } 
    
    
    public function testUpdateTest()
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

        $new_data = ['description' => 'Furadeira XII'];
        $product->update($new_data);

        //find new values
        $this->assertDatabaseHas('products', $new_data);

        //not find old values
        $this->assertDatabaseMissing('products', $product_data);
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
        $this->assertDatabaseHas('products', $product_data);    
        
        //confirm insert
        $product->delete();

        //confirm removed data
        $this->assertDatabaseMissing('products', $product_data);
    }


    public function testBelongsToTest()
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

    

}

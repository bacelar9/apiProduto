<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileTest extends TestCase
{
    use DatabaseTransactions;    

    public function testCreateTest()
    {
        $data = [
            'path' => 'caminho/file.xlsx'          
        ];
        \App\File::create($data);
        $this->assertDatabaseHas('files', $data);
    }
    
}

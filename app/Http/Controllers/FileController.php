<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \App\Http\Controllers\CategoryController;
use \App\Jobs\Processa;
class FileController extends Controller
{
    public function store(Request $request)
    {
       

        
        $path = $request->file('file')->store('upload');
        $file = File::create(['path' => $path]);
        Processa::dispatch($file);
        return response()->json($file,201);
        
    }
   
    public function show($id)
    {
        $file = File::find($id);
        return response()->json(['done' => $file->done],200);
    }    

    public static function run($file){
            $inputFileName = storage_path().'/app/'.$file->path;
            $spreadsheet = IOFactory::load($inputFileName);
            
            foreach($spreadsheet->getSheetNames() as $sheet){
                $activeSheet = $spreadsheet->getSheetByName($sheet);
                //validate
                if($activeSheet->getCell('A1') == 'Category'){
                    $category_description = $activeSheet->getCell('B1');
                    $category = CategoryController::getByDescription($category_description);
                    $i=3;
                    while($activeSheet->getCell('A'.$i) != ""){
                        $product_data = [
                            'Im' => $activeSheet->getCell('A'.$i)->getValue(),
                            'name' => $activeSheet->getCell('B'.$i)->getValue(),
                            'free_shipping' => $activeSheet->getCell('C'.$i)->getValue(),
                            'description' => $activeSheet->getCell('D'.$i)->getValue(),
                            'price' => $activeSheet->getCell('E'.$i)->getValue(),
                            'category_id' => $category->id
                        ];   
                        $product = \App\Product::create($product_data);                        
                        $i++;
                    }
                }            
            $file->update(['done' => 1]);                   
        }
    }
}

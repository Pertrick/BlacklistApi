<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //

    public function create(Request $request)
    {
        $user_id = Auth::id();

           $category = Category::all();
             //validate
           $product = Product::Factory()->count(7)->create();

    
            if($product)
            {
                return response()->json([
                    'status' => 1,
                    'message' => 'Product added successfully',
                    'data' =>[
                        [
                            $product
                        ]
                    ],
                ], 200);
            }
    
           else{
               return response()->json([
                'status' => false,
                'message' => 'Failed to add Product',
                
            ]);
    
        }

    }

    public function update(Request $request, $product_id)
    {
        $user_id = auth()->user()->id;

        if(Product::where([
            'user_id' => $user_id,
            'id' => $product_id
            ])->exists()){


                $product= Product::findOrFail($product_id);
                $product->name = isset($request->name) ? $request->name : $product->name ;
                $product->price  = isset($request->price) ? $request->price : $product->price;
                $product->category_id = isset($request->category_id) ? $request->category_id : $product->category_id ;

                $product->save();

                if($product->save())
                {
                    return response()->json([
                        'status' => 1,
                        'message' => 'Book Updated Successfully',
                        'data' =>  [ 
                            [
                                'id' => $product->id,
                                'name' => $product->name,
                                'price' => '$'. $product->price,
                                'category_id' => $product->category_id,
                            ]
                        ]
                    ]);
              }

            }   

            else{
                return response()->json([
                    'status' => false,
                    'message' => 'You are not permitted to edit this Product Or Product doesn\'t exist',
                ]);
            }
    }

    public function destroy($product_id)
    {
        //
        $user_id = auth()->user()->id;

        if(Product::where([
            'user_id' => $user_id,
            'id' => $product_id
            ])->exists()){
            $product = Product::findOrFail($product_id);

            $product->delete();

            return response()->json([
                    'status' => true,
                    'message' => 'Product deleted Successfully',
                ]);


         }
         else{
            return response()->json([
                'status' => false,
                'message' => 'You are not permitted to edit this Product Or Product doesn\'t exist',
            ]);
        }
        
    }   

    public function fileImportExport()
    {
       return view('file-import');
    }

    public function fileImport(Request $request) 
    {
        Excel::import(new UsersImport, $request->file('file')->store('temp'));
        return back();
    }

    public function fileExport() 
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }


    

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function create(Request $request)
    {
          
            //create random categories
            $categories = Category::Factory()->count(3)->create();
            
    
            if($categories)
            {
                return response()->json([
                    'status' => 1,
                    'message' => 'Category added successfully',
                    'data' => $categories
                    
                ], 200);
            }
    
           else{
               return response()->json([
                'status' => false,
                'message' => 'Failed to add Category',
                
            ]);
    
        }

    }

    public function update(Request $request, $category_id)
    {
        $user_id = auth()->user()->id;

        if(Category::where([
            'user_id' => $user_id,
            'id' => $category_id
            ])->exists()){

               //accessing the category id
                $category = Category::findOrFail($category_id);

                $category->name = isset($request->name) ? $request->name : $category->name ;
               
                $category->save();

                if ($category->save()) {
                    return response()->json([
                    'status' => 1,
                    'message' => 'category Updated Successfully',
                    'data' => $category,
                ]);
               
            }
        } 

            else{
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permission to edit this category Or Category doesn\'t exist ',
                ]);
            }
    }

    public function destroy($category_id)
    {

        $user_id = auth()->user()->id;


        if(Category::where([
            'user_id' => $user_id,
            'id' => $category_id
            ])->exists()){
            $category = Category::findOrFail($category_id);

            $category->delete();
            
             return response()->json([
                    'status' => true,
                    'message' => 'category deleted Successfully',
                ]);
            
            }

            else{
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permission to delete this category Or Category doesn\'t exist ',
                ]);
            }
    }



}

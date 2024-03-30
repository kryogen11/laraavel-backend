<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModels;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProduct(){
        $data = ProductModels::get();

        return response()->json([
            'status' => true,
            'message' => 'Product Data',
            'data' => $data
        ], 200);
    }
    public function createProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'sometimes',
            'product_description' => 'sometimes',
            'product_quantity' => 'sometimes',
            'product_price' => 'sometimes',
            'category' => 'sometimes',
            'status' => 'sometimes',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $product = ProductModels::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_quantity' => $request->product_quantity,
            'product_price' => $request->product_price,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        if($product){
            return response()->json([
                'status' => true,
                'message' => 'Product Data has been successsfully created.',
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to create Product Data.',
        ], 409);
    }

    public function editProduct(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'sometimes',
            'product_description' => 'sometimes',
            'product_quantity' => 'sometimes',
            'product_price' => 'sometimes',
            'category' => 'sometimes',
            'status' => 'sometimes',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $product = ProductModels::where('id' , $id)->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_quantity' => $request->product_quantity,
            'product_price' => $request->product_price,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        if($product){
            return response()->json([
                'status' => true,
                'message' => 'Product Data has been successsfully changed.',
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to change Product Data.',
        ], 409);
    }

    public function deleteProduct($id){
        $product = ProductModels::find($id);

        if(!$product){
            return response()->json([
                'status' => false,
                'message' => 'Failed to find Product'
            ], 404);
        }

        $product->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Product is deleted successfully'
        ], 200);
    }
}

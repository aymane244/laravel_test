<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        return view("products.index");
    }

    public function products(){
        $products = Product::orderBy("created_at", "ASC")->get();
        return response()->json(['products' => $products]);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'quantity' => 'required|numeric|min:1', 
            'price' => 'required|numeric|min:0.01',
        ]);
        
        if($validate->fails()){
            return response()->json(['errors' => $validate->errors()]);
        }
            
        $product = new Product();
        $product->name = $request->name;
        $product->quantity_stock = $request->quantity;
        $product->unit_price = $request->price;
        $product->save();
        return response()->json(['message' => "The ".$product->name." has been stored successfully"]);
    }

    public function edit($id){
        $product = Product::find($id);
        return response()->json(['product' => $product]);
    }

    public function update(Request $request){
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'quantity' => 'required|numeric|min:1', 
            'price' => 'required|numeric|min:0.01',
        ]);
        
        if($validate->fails()){
            return response()->json(['errors' => $validate->errors()]);
        }
            
        $product = Product::find($request->id);

        if($product){
            $product->name = $request->name;
            $product->quantity_stock = $request->quantity;
            $product->unit_price = $request->price;
            $product->save();
            return response()->json(['message' => "The ".$product->name." has been updated successfully"]);
        }
    }
}
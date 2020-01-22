<?php

namespace App\Http\Controllers;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Exceptions\ProductNotBelongToUser;
use Auth;
class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|max:255|unique:products',
        //     'description' => 'required',
        //     'price' => 'required|max:10',
        //     'stock' => 'required|max:6',
        //     'discount' => 'required|max:2',
        // ]);

        // $product = Product::create([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'stock' => $request->stock,
        //     'discount' => $request->discount,
        // ]); 
            
        $product = new Product;
        $product->name =  $request->name;
        $product->detail =  $request->description;
        $product->price =  $request->price;
        $product->stock =  $request->stock;
        $product->discount =  $request->discount;
        $product->user_id =  Auth::id();
        $product->save();
            return response([
                'data' => new ProductResource($product)
            ],201);
        //return HelperController::api_response_format(200, $product,'product added Successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->PrductUserCheckAuth($product);
        $request['detail'] = $request->description;
        unset($request['description']);
        $product->update($request->all());
        return response([
            'data' => new ProductResource($product)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        $this->PrductUserCheckAuth($product);
        $product->delete();
        return response(null,204);
    }

    public function PrductUserCheckAuth($product)
    {
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongToUser;
            
        }
    }
}

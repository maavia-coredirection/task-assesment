<?php

namespace App\Http\Controllers;

use App\Http\Message;
use App\Http\Requests\SaveOrUpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():JsonResponse
    {
        return response()->json(["data"=>Product::all()], Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveOrUpdateProductRequest $request):JsonResponse
    {

        $product = new Product();

        $this->moveImage($request,$product);
        $product->name= $request->name;
        $product->price = $request->price;
        $product->upc = $request->upc;
        $product->status = $request->status;
        $product->save();

        return response()->json(['data'=>$product],Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id):JsonResponse
    {
        $product = Product::find($id);
        if($product){
            return response()->json(['data'=>$product],Response::HTTP_OK);
        }
            return response()->json(['message'=>Message::PRODUCT_NOT_FOUND],Response::HTTP_NOT_FOUND);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveOrUpdateProductRequest $request, $id):JsonResponse
    {
        //
        $product = Product::find($id);
        if($product){
            $this->moveImage($request,$product);
            $product->name= $request->name;
            $product->price = $request->price;
            $product->upc = $request->upc;
            $product->status = $request->status;
            $product->update();

            return response()->json(['data'=>$product],Response::HTTP_CREATED);
        }
            return response()->json(['message'=>Message::PRODUCT_NOT_FOUND],Response::HTTP_NOT_FOUND);

    }

    /**
     * Remove  resource from storage.
     * @param $products
     * @return JsonResponse
     */
    public function destroy($products):JsonResponse
    {

        $productIds = json_decode($products);
        foreach($productIds as $product){
            Product::destroy($product);
        }
        return response()->json(['message'=>Message::PRODUCT_DELETE_MESSAGE],Response::HTTP_OK);
    }


    public function moveImage(Request $request,Product $product){
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $product->image =  time().'_'.$file->getClientOriginalName();
        }
    }
}

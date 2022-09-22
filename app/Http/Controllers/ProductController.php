<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductIndexResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources;
use App\Http\Resources\ProductIndexResource as ProductInResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{

    public function index(): Resources\Json\AnonymousResourceCollection
    {
        $products = Product::query()->where('expiration_date', '>=', today())->get();
        return ProductIndexResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->views+=1;
        $product->save();
        return new ProductInResource($product);
    }

    public function store(ProductStoreRequest $request): ProductInResource
    {
        $request->headers->set('Accept', 'application/json');
        $user_id = Auth::id();
        $uploadFolder = 'product_images';
        $image = $request->file('image');
        $name = time() . '.jpg';
        $path = 'storage/' . $uploadFolder . '/' . $name;
        Storage::disk('public')->putFileAs($uploadFolder, $image, $name);

        $product = Product::create([
            'user_id' => $user_id,
            'name' => $request->input('name'),
            'image' => $uploadFolder . '/' . $name,
            'expiration_date' => $request->input('expiration_date'),
            'periods' => $request->input('periods'),
            'discounts' => $request->input('discounts'),
            'quantity' => $request->input('quantity'),
            'views' => 0,
            'likes'=>0,
            'details' => $request->input('details'),
            'category_id' => $request->input('category_id'),
            'phone' => $request->input('phone'),
            'facebook' => $request->input('facebook'),
            'price' => $request->input('price'),
            'price_after_discount' => \App\Http\Classes\Discount::discount($request->input('expiration_date'),
                $request->input('price'),
                $request->input('periods'),
                $request->input('discounts'))

        ]);

        return new ProductIndexResource($product);
    }

    public function search(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $products = Product::query()->where($request->search, 'LIKE', $request->value)->get();

        return ProductIndexResource::collection($products);

    }

    public function sort(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $products = Product::query()->orderBy($request->sort, $request->direction)->get();

        return ProductIndexResource::collection($products);

    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $request->headers->set('Accept', 'application/json');
        $user_id = Auth::id();

        if ($user_id == $product->user_id) {
            $uploadFolder = 'product_images';
            $image = $request->file('image');
            $name = time() . '.jpg';
            $path = 'storage/' . $uploadFolder . '/' . $name;
            Storage::disk('public')->putFileAs($uploadFolder, $image, $name);
            $product->name = $request['name'];
            $product->image = $uploadFolder . '/' . $name;
            $product->quantity = $request['quantity'];
            $product->category_id = $request['category_id'];
            $product->phone = $request['phone'];
            $product->facebook = $request['facebook'];
            $product->periods = $request['periods'];
            $product->discounts = $request['discounts'];
            $product->details=$request['details'];

            if( $request['quantity']==0)
            {
                $this->destroy($product);
            }
            else
            $product->save();
            return new ProductIndexResource($product);
        }
        return response()->json(['message' => 'you cant edit the product']);
    }

    public function destroy(Product $product)
    {
        $user_id = Auth::id();
        if ($user_id == $product->user_id) {
            $product->delete();
            return new ProductInResource($product);
        }
        return response()->json(['message' => 'you cant delete the product']);
    }

    public function buy(Request $request, $id): \Illuminate\Http\JsonResponse
    {

//        $product=Product::find($id);
        if ($request->quantity)
        {
            $pall=$request->quantity;

            $product = Product::where('id', $id)->first();

            if($pall==$product->quantity)
            {
                $product->delete();
                return new ProductInResource($product);
            }
            elseif($pall < $product->quantity)
            {

                $newQuantity=$product->quantity - $pall;
                $product->quantity = $newQuantity;
                $product->save();
                return new ProductInResource($product);
            }
            else
            {
                return response()->json([
                    'message','you are buying more than the quantity that exist'
                ]);
            }
        }
        else
        {
            return response()->json([
                'message','insert the quantity of the product'
            ]);
        }


        return response()->json(['message' => 'you cant delete the product']);

    }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('images')->latest()->paginate(10);
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd([
        //     'all' => $request->all(),
        //     'hasFile' => $request->hasFile('images'),
        //     'fileKeys' => $request->files->keys(),
        //     'files' => $request->file('images'),
        // ]);
        // dd($request->file('images'));
        $newProduct = $request->validate([
            'name' => 'required|max:255|unique:products',
            'category' => 'required|max:255',
            'stock' => 'required',
            'description' => 'required',
            'date_time' => 'required|',
            'images.*' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        

        $product = Product::create($newProduct);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
               
                $imagePath = $imageFile->store('products', 'public'); 
    
               
                $product->images()->create([
                    'image' => $imagePath,
                ]);
            }
        }

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
  
        $newProduct = $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|max:255',
            'stock' => 'required',
            'description' => 'required',
            'date_time' => 'required|date_format:Y-m-d H:i:s',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        $product->update($newProduct);

        if ($request->hasFile('images')) {
         
            $product->images()->delete(); 
    
            foreach ($request->file('images') as $imageFile) {
              
                $imagePath = $imageFile->store('products', 'public'); 
    
              
                $product->images()->create([
                    'image' => $imagePath,
                ]);
            }
        }
    
        return response()->json($product->load('images'), 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //

        $product->delete();

        return ['message' => 'Product Deleted Successfully'];
    }

    public function getProductStatistics()
    {
        // Total number of products
        $totalProducts = Product::count();

        // Product with the highest stock
        $highestStockProduct = Product::orderBy('stock', 'desc')->first();

        // Product with the lowest stock
        $lowestStockProduct = Product::orderBy('stock', 'asc')->first();

        // Top category (most frequent)
        $topCategory = Product::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->first();

        // Return the result as JSON
        return response()->json([
            'total_products' => $totalProducts,
            'highest_stock_product' => $highestStockProduct,
            'lowest_stock_product' => $lowestStockProduct,
            'top_category' => $topCategory
        ]);
    }
}

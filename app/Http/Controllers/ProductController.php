<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Trait\RespondsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProductController extends Controller
{
    use RespondsTrait;
    // List all products
    public function index()
    {
        try {
            $products = Product::all();
            // Return a success response
            return $this->success($products);
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }

    }

    // Store a new product
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $product = Product::create($validator->validated());

            return $this->success($product, 'Product created successfully');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }

    // Show a specific product
    public function show(Product $product)
    {
        try {

            return $this->success($product, 'Product');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }

    // Update a product
    public function update(Request $request, Product $product)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'  => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric|min:0',
                'stock' => 'sometimes|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $product->update($validator->validated());
            return $this->success($product, 'Product updated successfully');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }

    // Delete a product
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return $this->success(null, 'Product deleted successfully');
        } catch (Throwable $th) {
            Log::error('processing failed: ' . $th->getMessage());
            return $this->error('Failed to process : ', $th->getMessage());
        }
    }
}

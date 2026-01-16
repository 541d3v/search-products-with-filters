<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProductsRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Filters\ProductFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of products with filters, sorting, and pagination.
     */
    public function index(GetProductsRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $validated = $request->validated();

        // Convert in_stock to boolean if present
        if (isset($validated['in_stock'])) {
            $validated['in_stock'] = filter_var($validated['in_stock'], FILTER_VALIDATE_BOOLEAN);
        }

        $query = Product::query();

        // Apply filters
        ProductFilter::apply($query, $validated);

        // Paginate the results
        $paginated = $query->paginate(
            perPage: $validated['per_page'],
            page: $validated['page']
        );

        // Return paginated response with custom format
        return response()->json([
            'data' => ProductResource::collection($paginated->items()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }
}

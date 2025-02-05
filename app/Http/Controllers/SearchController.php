<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\PublishedProduct;

class SearchController extends Controller
{
    /**
     * Search for published products by product name or WS code.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        // Generate a unique cache key based on the search query
        $cacheKey = 'search_' . md5(strtolower($query)); // Ensure case-insensitive caching

        // Try fetching results from cache first
        $results = Cache::remember($cacheKey, now()->addMinutes(2), function () use ($query) {
            return PublishedProduct::where('product_name', 'ILIKE', '%' . $query . '%')
                ->orWhere('product_ws_code', 'ILIKE', '%' . $query . '%')
                ->get();
        });

        return response()->json($results);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Lọc theo brand nếu có
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        // Lọc theo khoảng giá nếu có
        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Lọc theo màu nếu có
        if ($request->has('color')) {
            $query->where('color', $request->color);
        }

        // Lọc theo loại nếu có
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Sắp xếp
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        // Lấy danh sách các brand, màu và loại để hiển thị bộ lọc
        $brands = Product::distinct()->pluck('brand');
        $colors = Product::distinct()->pluck('color');
        $types = Product::distinct()->pluck('type');

        return view('products.index', compact('products', 'brands', 'colors', 'types'));
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show(Product $product)
    {
        // Lấy các sản phẩm liên quan (cùng brand hoặc cùng loại)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('brand', $product->brand)
                    ->orWhere('type', $product->type);
            })
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Hiển thị sản phẩm nổi bật trên trang chủ
     */
    public function featured()
    {
        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::where('is_featured', true)
            ->take(8)
            ->get();

        // Lấy sản phẩm mới nhất
        $newProducts = Product::latest()
            ->take(8)
            ->get();

        // Lấy sản phẩm theo brand phổ biến
        $popularBrands = Product::select('brand')
            ->groupBy('brand')
            ->orderByRaw('COUNT(*) DESC')
            ->take(4)
            ->pluck('brand');

        $brandProducts = [];
        foreach ($popularBrands as $brand) {
            $brandProducts[$brand] = Product::where('brand', $brand)
                ->take(4)
                ->get();
        }

        return view('products.featured', compact(
            'featuredProducts',
            'newProducts',
            'popularBrands',
            'brandProducts'
        ));
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('brand', 'like', "%{$keyword}%");
            });
        }

        $products = $query->paginate(12);

        return view('products.search', compact('products'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\CategoryRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class DashboardController extends Controller
{
    /**
     * Get all data
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('user.user-dashboard');
    }

    /**
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json(['categories' => $categories]);

    }

    /**
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $products = Product::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json(['products' => $products]);
    }

    /**
     * @return JsonResponse
     */
    public function getCategoryList(): JsonResponse
    {
        $categoryList = Category::where('user_id', auth()->id())->get();
        return response()->json(['category_list' => $categoryList]);
    }

    /**
     * Add category
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     *
     */
    public function addCategory(CategoryRequest $request): JsonResponse
    {
        $name = $request->input('name');
        $description = $request->input('description');

        $category = Category::create([
            'user_id' => auth()->id(),
            'name' => $name,
            'description' => $description
        ]);
        return response()->json([
            'status' => 'success',
            'category' => Category::find($category->id)
        ]);
    }

    /**
     * Edit category
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function editCategory(CategoryRequest $request): JsonResponse
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');

       Category::where('id', $id)->update([
                    'user_id' => auth()->id(),
                    'name' => $name,
                    'description' => $description
                ]);
        $category = Category::where('id', $id)
            ->take(1)
            ->first();
        return response()->json([
            'status' => 'success',
            'category' => $category
        ]);
    }

    /**
     * Delete category
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCategory(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $currentPage = $request->input('current_page');
        Category::find($id)->delete();
        Product::where('category_id', $id)->delete();

        $categoryRow = Category::orderBy('id', 'DESC')
            ->skip($currentPage * 5 - 1)
            ->take(1)
            ->first();
        return response()->json([
            'message' => 'The category successfully deleted.',
            'category' => $categoryRow]);
    }

    /**
     * Add product
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function addProduct(ProductRequest $request): JsonResponse
    {
        $name = $request->input('name');
        $category_id = $request->input('category_id');
        $price = $request->input('price');

        $product = Product::create([
            'user_id' => auth()->id(),
            'name' => $name,
            'category_id' => $category_id,
            'price' => $price,
        ]);
        $product = Product::where('id', $product->id)
            ->with('category')
            ->take(1)
            ->first();
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }

    /**
     * Edit product
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function editProduct(ProductRequest $request): JsonResponse
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $category_id = $request->input('category_id');
        $price = $request->input('price');

        Product::where('id', $id)->update([
                    'user_id' => auth()->id(),
                    'name' => $name,
                    'category_id' => $category_id,
                    'price' => $price,
                ]);
        $product = Product::where('id', $id)
            ->with('category')
            ->take(1)
            ->first();
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }

    /** Delete product
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteProduct(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $currentPage = $request->input('current_page');

        Product::find($id)->delete();
        $productRow = Product::orderBy('id', 'DESC')
            ->with('category')
            ->skip($currentPage * 5 - 1)
            ->take(1)->first();
        return response()->json([
            'message' => 'The Product successfully deleted.',
            'product' => $productRow]);
    }

}


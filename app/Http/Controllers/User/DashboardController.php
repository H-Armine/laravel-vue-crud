<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * add category
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     *
     */
    public function addCategory(CategoryRequest $request)
    {
        $category = Category::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return response()->json([
            'status' => 'success',
            'category' => Category::find($category->id)
        ]);
    }

    /**
     * edit category
     *
     * @param CategoryRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function editCategory(CategoryRequest $request)
    {
        $id = $request->input('id');
        $category = Category::where('id', $id)
            ->update(
                [
                    'user_id' => auth()->id(),
                    'name' => $request->input('name'),
                    'description' => $request->input('description')
                ]);
        return response()->json([
            'status' => 'success',
            'post' => $category
        ]);
    }

    /**
     * delete category
     *
     * @param $id
     * @return JsonResponse
     */
    public function deleteCategory(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('current_page');
        Category::find($id)->delete();
        Product::where('category_id', $id)->delete();
        $categoryRow = Category::orderBy('id', 'DESC')
            ->skip($currentPage * 5 - 1)
            ->take(1)->first();
        return response()->json([
            'message' => 'The category successfully deleted.',
            'category' => $categoryRow]);
    }

    /**
     * add product
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function addProduct(ProductRequest $request)
    {
        $product = Product::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'price' => $request->input('price'),
        ]);
        $product = Product::where('id', $product->id)
            ->with('category')
            ->first();
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }

    /**
     * edit product
     *
     * @param ProductRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function editProduct(ProductRequest $request)
    {
        $id = $request->input('id');
        $product = Product::where('id', $id)
            ->update(
                [
                    'user_id' => auth()->id(),
                    'name' => $request->input('name'),
                    'category_id' => $request->input('category_id'),
                    'price' => $request->input('price'),
                ]);
        $product = Product::where('id', $id)
            ->with('category')
            ->first();
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }

    /**
     * delete product
     *
     * @param $id
     * @return JsonResponse
     */
    public function deleteProduct(Request $request)
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


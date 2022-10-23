<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return view('admin.admin-dashboard')->with(compact('products'));
    }

    /**
     * change product status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        Product::where('id', $id)->update(['status' => $status]);
        return response()->json('The Product status successfully changed.');
    }
}

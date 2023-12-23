<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //direct product list page
    public function list()
    {
        $pizzas = Product::select('products.*','categories.name as category_name')->when(request('key'), function ($query) {
            $query->orWhere('products.name', 'like', '%' . request('key') . '%')
                  ->orWhere('categories.name', 'like', '%' . request('key') . '%');
        })
            ->leftJoin('categories','products.category_id','categories.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(3);

        $pizzas->appends(request()->all());
        return view('admin.product.pizzaList', compact('pizzas'));
    }

    //direct products create page
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.product.create', compact('categories'));
    }
    //create product
    public function create(Request $request)
    {
        $this->productValidationCheck($request, 'create');
        $data = $this->requestProductInfo($request);
        $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;
        Product::create($data);
        return redirect()->route('products#list');
    }
    //delete pizza
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('products#list')->with(['deleteSuccess' => 'The product is deleted']);
    }
    //direct pizza edit page
    public function edit($id)
    {
        $pizza = Product::select('products.*','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->where('products.id', $id)->first();
        return view('admin.product.edit', compact('pizza'));
    }
    //direct update page
    public function updatePage($id)
    {
        $pizza = Product::where('id', $id)->first();
        $category = Category::get();
        return view('admin.product.updatePage', compact('pizza', 'category'));
    }
    // update pizza data
    public function update($id, Request $request)
    {
        $this->productValidationCheck($request, 'update');
        $data = $this->requestProductInfo($request);
        if ($request->hasFile('pizzaImage')) {
            $oldImageName = Product::where('id', $request->id)->first();
            $oldImageName = $oldImageName->image;
            if ($oldImageName != null) {
                Storage::delete('public/' . $oldImageName);
            }
            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        Product::where('id', $request->id)->update($data);
        return redirect()->route('products#list');
    }
    //product validation
    private function productValidationCheck($request, $action)
    {
        $validationRule = [
            'pizzaName' => 'required|min:5|unique:products,name,' . $request->id,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:10',
            'pizzaPrice' => 'required',
            'pizzaWaitingTime' => 'required',
        ];
        $validationRule['pizzaImage'] = $action == 'create' ? 'required|mimes:png,jpg,jpeg,webp|file' : 'mimes:png,jpg,jpeg,webp|file';

        Validator::make($request->all(), $validationRule)->validate();
    }
    //get product data
    private function requestProductInfo($request)
    {
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->pizzaWaitingTime,
        ];
    }
}

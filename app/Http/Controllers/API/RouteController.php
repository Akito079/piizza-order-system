<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function productList() {
        $products = Product::get();
        $user = User::get();
        $data = [
            'products' => $products,
            'users' => $user,
        ];
        return response()->json($data,200);;
    }
    public function categoryList (){
        $category = Category::get();
        return response()->json($category,200);
    }
    public function createCategory(Request $request){
      $data = [
        'name'=> $request->name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ];
     $response = Category::create($data);
    return response()->json($response,200);
    }
    public function createContact (Request $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $response = Contact::create($data);
        return response()->json($response,200);
    }
    public function contactList(){
        $contact = Contact::get();
        return response()->json($contact,200);
    }
    //delete category data
    public function categorydelete(Request $request) {
        $data = Category::where('id',$request->id)->first();
        if(isset($data)) {
            Category::where('id',$request->id)->delete();
            $message = [
             'message' => 'delete success',
             'status' => 'true',
            ];
            return response()->json($message,200);
        }
        $message = [
            'message' => 'delete failed',
            'status' => 'false',
           ];
           return response()->json($message,200);
    }
    public function categoryDetail ($id){
        $category = Category::where('id',$id)->first();
        if(isset($category)) {
            return response()->json($category,200);
        }
        $message = [
            'message' => 'Category not found',
        ];
        return response()->json($message,200);
    }
    public function categoryUpdate(Request $request){
        $dbSource = Category::where('id',$request->id)->first();
        if(isset($dbSource)) {
        $data = $this->getCategoryData($request);
        Category::where('id',$request->id)->update($data);
        $updateData = Category::where('id',$request->id)->first();
        $message = [
            'message' => 'update success',
            'category' => $updateData,
        ];
        return response()->json($message,200);
        }
        $message = [
            'message'=> 'update failed',
            'category' => $dbSource,
        ];
        return response()->json($message,200);
    }
    private function getCategoryData($request) {
        return [
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ];
    }
 }

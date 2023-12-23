<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //user home page
    public function home()
    {
        $pizza = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category','cart','history'));
    }
    public function changePasswordPage()
    {
        return view('user.password.change');
    }
    // change password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashValue = $user->password;
        if (Hash::check($request->oldPassword, $dbHashValue)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make(
                    $request->newPassword
                )
            ]);
            return back()->with(['changeSuccess' => 'Password Changed']);
        }
        return back()->with(['notMatch' => 'Incorrect old password. Try agian']);
    }
    //direct account change page
    public function accountChangePage(){
        return view('user.profile.account');
    }

    // account change
    public function accountChange ($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        //for image
        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        User::where('id', $id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess' => 'Admin Account Updated']);
    }
    //pizza page filter
    public function filter($categoryId){
        $pizza = Product::where('category_id',$categoryId)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category','cart','history'));
    }
    //direct pizza details page
    public function pizzaDetails($pizzaId){
        $pizza = Product::where('id',$pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.detail',compact('pizza','pizzaList'));
    }
    //direct cart list page
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                    ->leftJoin('products','products.id','carts.product_id')
                    ->where('carts.user_id',Auth::user()->id)->get();
        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price * $c->qty;
        }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }
    //direct history page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(4);
        return view('user.main.history',compact('order'));
    }
    //direct userList page
    public function userList(){
        $users = User::where('role','user')->paginate(3);
        return view('admin.user.userList',compact('users'));
    }
    // password validation
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
    }
    //chnage user role to admin
    public function changeRole (Request $request){
       User::where('id',$request->userId)->update(['role' => $request->role,]);
    }
    //account validation
    private function accountValidationCheck ($request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $request->id,
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();
    }
    public function delete($id){
        dd($id);
        User::where('id',$id)->delete();
        return redirect()->route('admin#userList');
    }
      // request user data
      private function getUserData($request)
      {
          return [
              'name' => $request->name,
              'email' => $request->email,
              'gender' => $request->gender,
              'phone'  => $request->phone,
              'address' => $request->address,
              'updated_at' => Carbon::now(),
          ];
      }

}

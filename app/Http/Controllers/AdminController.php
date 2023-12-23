<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //change password page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }
    public function changePassword(Request $request)
    {
        /*
            1. all field must be  filled
            2. new password & confirm password must be greater than 6
            3. new password & confirm password must be same
            4. client old password must be same with db password
            5. password change
           */
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashValue = $user->password;
        if (Hash::check($request->oldPassword, $dbHashValue)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            // Auth::logout();
            // return redirect()->route('auth#loginPage');
            return back()->with(['changeSuccess' => 'Password Changed']);
        }        return back()->with(['notMatch' => 'Incorrect old password. Try agian']);
    }
    //direct admin account details page
    public function details()
    {
        return view('admin.account.details');
    }

    //direct admin profile page
    public function edit()
    {
        return view('admin.account.edit');
    }
    //update profile
    public function update($id, Request $request)
    {
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
    //direct admin list page
    public function list()
    {
        $admin = User::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('email', 'like', '%' . request('key') . '%')
                ->orWhere('gender', 'like', '%' . request('key') . '%')
                ->orWhere('phone', 'like', '%' . request('key') . '%')
                ->orWhere('address', 'like', '%' . request('key') . '%');
        })
            ->where('role', 'admin')->paginate(3);
        return view('admin.account.list', compact('admin'));
    }
    //delete admin accounts
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'an admin account has been deleted']);
    }
    //view user details
    public function userDetails($id){
        $user = User::where('id',$id)->first();
        return view('admin.user.details',compact('user'));
    }
    //ban users
    public function banUser($id)
    {
        User::where('id', $id)->update([
            'status' => 0,
        ]);
        return redirect()->route('admin#userList');
    }
    //unban user
    public function unbanUser($id){
        User::where('id', $id)->update([
            'status' => 1,
        ]);
        return redirect()->route('admin#userList');
    }
    //chnageRole
    public function changeRole(Request $request){
       User::where('id',$request->id)->update([
        'role'=>$request->role,
       ]);
       $response = [
        'message' => 'success',
       ];
       return response()->json($response,200);
    }
    //direct contactList page
    public function contactList(){
        $contact = Contact::orderBy('created_at','desc')->paginate(3);
        return view('admin.contact.message',compact('contact'));
    }
    public function contactDetail ($id){
        $contact = Contact::where('id',$id)->first();
        return view('admin.contact.detail',compact('contact'));
    }
    //check password validation
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
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
    //acount validation
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $request->id,
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();
    }

}

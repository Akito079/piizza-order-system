<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
   public function contactPage(){
    return view('user.contact.contactPage');
   }

   public function contactSend(Request $request){
    $this->checkValidation($request);
    $data =  $this->getContactData($request);
    Contact::create($data);
    return redirect()->route('user#home');
   }
   //check contact validation
   private function checkValidation(Request $request){
    Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required',
        'subject' => 'required|min:5',
        'message' => 'required|min:5'
    ])->validate();
   }
   private function getContactData($request){
    return [
        'name' => $request->name,
        'email' => $request->email,
        'subject' => $request->subject,
        'message' => $request->message,
    ];
   }
}

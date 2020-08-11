<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;
use App\PaymentMethod;


class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user_id = $request->cookie('id');
        $payment_methods = PaymentMethod::where('user_id',$user_id)->get();
        return view('dashboard.payment_method.index')->with('platforms',$payment_methods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $messages = [
            'required' => 'All input fields are required'
        ];
        $validator = Validator::make($request->all(), [
            'platform' =>'required',
            'details' =>"required|max:250|min:3",
            'contact' =>"required|max:250|min:3"
        ], $messages);
   
        if($request->input('platform') == 'others'){
            $validator = Validator::make($request->all(), [
                'platform' =>'required',
                'others' => 'required|min:3',
                'details' =>"required|max:250|min:3",
                'contact' =>"required|max:250|min:3"
            ], $messages);
        }
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', $message);
                    return redirect()->route('gift_methods.index');
            }
        } else {
            try{

                $user_id = $request->cookie('id');
                $check_new = PaymentMethod::where('user_id',$user_id)->where('platform',$request->input('platform'))->get();
                if(count($check_new) > 0){
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"You can not have two gift methods with the same platfrom");
                    return redirect()->route('gift_methods.index');
                }
                $payment_method = new PaymentMethod();
                $payment_method->platform = $request->input('platform');
                $payment_method->details = $request->input('details');
                $payment_method->contact = $request->input('contact');
                if($request->input('platform') == 'others'){
                    $payment_method->platform = $request->input('others');
                }
                $payment_method->user_id =  Cookie::get('id');
                $payment_method->user_name =  Cookie::get('full_name');
                $payment_method->save();

                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', "Platform added successfully");
                return redirect()->route('gift_methods.index');

            }catch(\Exception $e){
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message',"Something went wrong with your request, please try again");
                return redirect()->route('gift_methods.index');
        }
        
            
        }
        return print_r($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $method = PaymentMethod::find($id);
        return view('dashboard.payment_method.show')->with('method',$method);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $method = PaymentMethod::find($id);
        return view('dashboard.payment_method.edit')->with('method',$method);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $messages = [
            'required' => 'All input fields are required'
        ];
        $validator = Validator::make($request->all(), [
            'platform' =>'required',
            'details' =>"required|max:250|min:3",
            'contact' =>"required|max:250|min:3"
        ], $messages);
   
        if($request->input('platform') == 'others'){
            $validator = Validator::make($request->all(), [
                'platform' =>'required',
                'others' => 'required|min:3',
                'details' =>"required|max:250|min:3",
                'contact' =>"required|max:250|min:3"
            ], $messages);
        }
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', $message);
                    return redirect()->route('gift_methods.index');
            }
        } else {
            try{
                $payment_method = PaymentMethod::find($id);
                $payment_method->platform = $request->input('platform');
                $payment_method->details = $request->input('details');
                $payment_method->contact = $request->input('contact');
                if($request->input('platform') == 'others'){
                    $payment_method->platform = $request->input('others');
                }
                $payment_method->save();
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', "Platform updated successfully");
                return redirect()->route('gift_methods.index');
            }catch(\Exception $e){
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message',"Something went wrong with your request, please try again");
                return redirect()->route('gift_methods.edit',$id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        try{
            $method = PaymentMethod::find($id);
            $method->delete();
            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "Paymenthod was successfully");
            return redirect()->route('gift_methods.index');
        }catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message',"Something went wrong with your request, please try again");
            return redirect()->route('gift_methods.index');
    }
        
    }
}

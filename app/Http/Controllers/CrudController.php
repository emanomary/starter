<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getOffer()
    {
        return Offer::get();

    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        //validate data before insert to database
        $rules = $this->getRules();
        $messages = $this->getMessages();
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            //return $validator->errors();
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        //insert to database
        Offer::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'details' => $request->input('details')
        ]);

        return redirect()->back()->with(['success'=>'your offer saved successfully']);
        /*Offer::create([
            'name' => 'eman',
            'price' => '200',
            'details' => 'bcsdjhggdjkcsdkka'
        ]);*/
        //return $request;
    }

    protected function getMessages()
    {
      return $messages = [
            'name.required' => __('message.offer name'),
            'price.required' => 'حقل الثمن مطلوب',
            'details.required' => 'حقل التفاصيل مطلوب',
            'name.max' => 'يجب ألا يزيد طول الاسم عن 100 حرف',
            'name.unique' => 'الاسم موجود مسبقاً',

        ];
    }

    protected function getRules()
    {
        return $rules = [
            'name'=>'required|max:100|unique:offers,name',
            'price'=>'required|numeric',
            'details'=>'required'
        ];
    }
}

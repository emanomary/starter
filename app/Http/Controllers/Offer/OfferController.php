<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use LaravelLocalization;

class OfferController extends Controller
{
    use OfferTrait;

    public function index()
    {
        $offers = Offer::select('id',
            'price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details'
        )->limit(10)->get(); // return array of collection

        return view('ajaxoffers.index',compact('offers'));
    }

    //ajax
    public function create()
    {
        //form to add offer by ajax
        return view('ajaxoffers.create');
    }

    //ajax
    public function store(OfferRequest $request)
    {
        //save offer in database by ajax
        $file_name = $this->saveImage($request->photo, 'images/offers');
        //insert to database
        $offer = Offer::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'price' => $request->input('price'),
            'details_ar' => $request->input('details_ar'),
            'details_en' => $request->input('details_en'),
            'photo' => $file_name
        ]);

        if($offer)
            return response()->json([
                'status' => true,
                'success_msg' => __('message.success_msg')
            ]);
        else
            return response()->json([
                'status' => false,
                'error_msg' => __('message.error_msg')
            ]);

    }

    //ajax
    public function delete(Request $request)
    {
        //check if offer id exists

        $offer = Offer::find($request->id);   // Offer::where('id','$offer_id') -> first();

        if (!$offer)
            return redirect()->back()->with(['error' => __('message.offer not exist')]);

        if($offer->delete())
            return response()->json([
                'status' => true,
                'success_msg' => __('message.success_msg'),
                'id'=> $request->id,
            ]);
        else
            return response()->json([
                'status' => false,
                'error_msg' => __('message.error_msg')
            ]);

    }

    public function edit(Request  $request)
    {
        $offer = Offer::find($request -> id);  // search in given table id only
        if (!$offer)
            return response()->json([
                'status' => false,
                'error_msg' => __('message.error_msg')
            ]);

        $offer = Offer::select(
            'id', 'name_ar', 'name_en', 'details_ar', 'details_en', 'price')
            ->find($request->id);

        return view('ajaxoffers.edit', compact('offer'));

    }

    public  function update(Request $request)
    {
        $offer = Offer::find($request->id);
        if (!$offer)
            return response()->json([
                'status' => false,
                'error_msg' => __('message.error_msg')
            ]);

        //update data
        $offer->update($request->all());

        return response()->json([
            'status' => true,
            'success_msg' => __('message.success_msg'),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use OfferTrait;
    public function create()
    {
        //form to add offer by ajax
        return view('ajaxoffers.create');
    }

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
}

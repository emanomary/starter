<?php

namespace App\Http\Controllers;

use App\Events\VideoViewer;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Models\Video;
use App\Traits\OfferTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class CrudController extends Controller
{
    use OfferTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /*public function getOffer()
    {
        return Offer::get();

    }*/
    public function getOffer()
    {
        return Offer::get();
    }

    public function index()
    {
       /* $offers = Offer::select('id',
            'price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details'
        )->get(); // return collection of all offers*/

        //paginate result
        $offers = Offer::select('id',
            'price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details'
        )->paginate(PAGINATION_COUNT); // return collection of all offers
        return view('offers.index',compact('offers'));
    }

    public function getAllInactiveOffers()
    {
        //where
        //$inactiveoffers = Offer::where('status',0)->get();
        $inactiveoffers = Offer::inactive()->get();
        return $inactiveoffers;
        //return view('offers.index',compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(OfferRequest $request)
    {
        //validate data before insert to database
        /*$rules = $this->getRules();
        $messages = $this->getMessages();
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            //return $validator->errors();
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }*/

        $file_name = $this->saveImage($request->photo, 'images/offers');
        //insert to database
        Offer::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'price' => $request->input('price'),
            'details_ar' => $request->input('details_ar'),
            'details_en' => $request->input('details_en'),
            'photo' => $file_name
        ]);

        return redirect()->back()->with(['success'=>__('message.success')]);

        /*Offer::create([
            'name' => 'eman',
            'price' => '200',
            'details' => 'bcsdjhggdjkcsdkka'
        ]);*/
        //return $request;
    }

    /*protected function getMessages()
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
    }*/

    public function edit($id)
    {
        //$offer = Offer::findOrFail($id);
        //$offer = Offer::find($id);//search in given table id only
        $offer = Offer::select('id','name_ar','name_en','price','details_ar','details_en')->find($id); // return collection
        if(!$offer)
        {
            return redirect()->back();
        }

        return view('offers.edit',compact('offer'));

    }

    public function update(OfferRequest $request,$id)
    {
        //validate
        //select
        $offer = Offer::select('id','name_ar','name_en','price','details_ar','details_en')->find($id);
        if(!$offer)
        {
            return redirect()->back();
        }
        //update
        $offer->update($request->all());

        /*$offer->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'price' => $request->input('price'),
            'details_ar' => $request->input('details_ar'),
            'details_en' => $request->input('details_en'),
        ]);*/

        return redirect()->back()->with(['success'=>__('message.success')]);
    }

    public function getVideo()
    {
        $video = Video::first();
        event(new VideoViewer($video));
        return view('video')->with('video',$video);
    }

    public function delete($id)
    {
        //check if offer id exists

        $offer = Offer::find($id);   // Offer::where('id','$offer_id') -> first();

        if (!$offer)
            return redirect()->back()->with(['error' => __('message.offer not exist')]);

        $offer->delete();

        return redirect()
            ->route('offers.index')
            ->with(['success' => __('message.offer deleted successfully')]);

    }
}

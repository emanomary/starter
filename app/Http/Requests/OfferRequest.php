<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'=>'required|max:100|unique:offers,name_ar',
            'name_en'=>'required|max:100|unique:offers,name_en',
            'price'=>'required|numeric',
            'details_ar'=>'required',
            'details_en'=>'required',
            'photo' => 'required|mimes:png,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => __('message.offer name ar'),
            'name_en.required' => __('message.offer name en'),
            'price.required' => __('message.offer price'),
            'details_ar.required' => __('message.offer details ar'),
            'details_en.required' => __('message.offer details en'),
            'name.max' => 'يجب ألا يزيد طول الاسم عن 100 حرف',
            'name.unique' => 'الاسم موجود مسبقاً',
            'photo.required' =>  'صورة العرض مطلوبوة',
            'photo.mimes' =>  'صورة غير صالحة',
        ];
    }
}

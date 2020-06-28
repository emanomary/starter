<?php

namespace App\Http\Controllers\Relation;

use App\Models\Country;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\Phone;
use App\Models\Service;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Comment\Doc;

class RelationsController extends Controller
{
    /********************* One to one Functions ***********************/
    public function hasOneRelation()
    {
        $user = User::with(['phone'=>function($q){
            $q->select('code','phone_no','user_id');
        }])->find(1);

        //return $user->phone->code;
        //$phone = $user->phone;
        return response()->json($user);
    }

    public function hasOneRelationReverse()
    {
        //to select some fields from database;
        $phone = Phone::with(['user'=>function($q){
            $q->select('id','name');
        }])->find(1);

        //make some attributes visible
        $phone->makeVisible(['user_id']);

        //make some attributes Hidden
        //$phone->makeHidden(['code']);

        //return $phone->user; //return user of this phone no.

        //get all data phone + user name
        //return $phone->user->name; //return user of this phone no.
        return $phone;
    }

    public function getUserHasPhone()
    {
        //to select some fields from database;
        $user = User::whereHas('phone')->get();
        return $user;
    }

    public function getUserNotHasPhone()
    {
        //to select some fields from database;
        $user = User::whereDoesntHave('phone')->get();
        return $user;
    }

    public function getUserHasPhoneWithCondition()
    {
        //to select some fields from database;
        //get user has phone and code = +972
        $user = User::whereHas('phone',function ($q){
            //condition
            $q->where('code','+972');
        })->get();
        return $user;
    }
    /********************* End One to one Functions ***********************/

    /********************* One to many Functions ***********************/
    public function getHospitals()
    {
        $hospital = Hospital::find(1);//Hospital::first(); //Hospital::where('id',1)->first();

        return $hospital->doctor;
    }

    public function getHospitalDoctors()
    {
        /*$hospital = Hospital::with(['doctor'=>function($q){
            $q->select('name','hospital_id');
        }])->find(1);
        return $hospital;*/
        $hospital = Hospital::with('doctor')->find(1);
        $doctors = $hospital->doctor;
        foreach ($doctors as $doctor)
        {
            echo $doctor->name.'<br>';
        }

        $doctor = Doctor::with(['hospital'=>function ($q){
            $q->select('name','id');
        }])->find(3);
        $doctor->makeVisible('hospital_id');
        //return $doctor->hospital->name;
        return $doctor;
    }

    public function hospitals()
    {
        $hospitals = Hospital::all();  //$hospitals = Hospital::select('id','name','address');
        if($hospitals)
            return view('doctors.hospitals',compact('hospitals'));

    }

    public function showDoctors($hospital_id)
    {
        //$doctors = Doctor::where('hospital_id',$hospital_id)->get();
        //we must make validation if it exist
        $hospital = Hospital::find($hospital_id);
        if($hospital)
        {
            $doctors = $hospital->doctor;
            return view('doctors.doctors',compact('doctors'));
        }
        else
            return redirect()->route('hospitals');

    }

    public function HospitalHasDoctors()
    {
        $hospitals = Hospital::whereHas('doctor')->get();
        return $hospitals;
    }

    public function HospitalHasDoctorMale()
    {
        $hospitals = Hospital::with('doctor')->whereHas('doctor',function ($q){
            //condition
            $q->where('sex','male');
        })->get();
        return $hospitals;
    }

    public function HospitalNotHasDoctorMale()
    {
        $hospitals = Hospital::whereDoesntHave('doctor')->get();
        return $hospitals;
    }

    public function deleteHospital($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');
        //delete doctors in this hospital
        $hospital->doctor()->delete();
        $hospital->delete();

        return redirect()->route('hospitals');
    }
    /********************* End One to many Functions ***********************/

    /********************* Begin Many to many Functions ***********************/
    public function getDoctorService()
    {
        $doctor = Doctor::with(['service'=>function($q){
            $q->select('name');
        }])->find(5);
        //$services = $doctor->service;

        return $doctor;
    }

    public function getServiceDoctor()
    {
        //$doctors = Service::with('doctor')->find(1);
        $doctors = Service::with(['doctor'=>function($q){
            $q->select('doctors.id','name','title');
        }])->find(1);

        return $doctors;
    }

    public function getDoctorServicesById($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        $services = $doctor->service;
        $doctors = Doctor::select('id','name')->get();
        $servicess = Service::select('id','name')->get();

        return view('doctors.services',[
            'services' => $services,
            'doctors' => $doctors,
            'servicess' => $servicess]);
    }

    public function saveServicesToDoctors(Request $request)
    {
        //get the selected doctor
        $doctor = Doctor::find($request->doctor_id);
        if(!$doctor)
            return abort('404');
        //get the selected services
       // $doctor->service()->attach($request->service_id); //many to many insert to database and duplicate data
        //$doctor->service()->sync($request->service_id); //many to many insert to database with delete older selection
        $doctor->service()->syncWithoutDetaching($request->service_id); //many to many insert to database without delete older selection
        return  redirect()->back();
    }

    /********************* End Many to many Functions ***********************/

    /********************* Begin has one through Functions ***********************/
    public function getPatientDoctor()
    {
        $patient = Patient::find(2);
        $doctor = $patient->doctor;
        return $doctor;
    }
    /********************* End has one through Functions ***********************/


    /********************* Begin has many through Functions ***********************/
    public function getCountrytDoctor()
    {
        $country = Country::with('doctor')->find(2);
        //$doctor = $country->doctor;
        return $country;
    }

    public function getCountrytHospital()
    {
        $country = Country::with('hospital')->find(2);
        return $country;
    }
    /********************* End has many through Functions ***********************/
}

@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>
            الأطباء
        </h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">title</th>
                <th scope="col">operations</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($doctors) && $doctors->count()>0)
                @foreach($doctors as $doctor)
                <tr>
                    <th scope="row">{{$doctor->id}}</th>
                    <td>{{$doctor->name}}</td>
                    <td>{{$doctor->title}}</td>

                    <td>
                         <a href="{{route('doctors.services',$doctor->id)}}" class="btn btn-success">عرض الخدمات</a>
                        {{-- <a href="{{route('offers.delete',$offer->id)}}" class="btn btn-danger"> {{__('message.delete')}}</a>
                         <a href="" offer_id="{{$offer->id}}" class="delete_btn btn btn-danger"> حذف اجاكس     </a>
                         <a href="{{route('ajaxoffers.edit',$offer->id)}}" class="btn btn-warning"> تعديل</a>--}}
                    </td>

                </tr>
                @endforeach
            @endif

            </tbody>


        </table>
    </div>

@stop


@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>
            المستشفيات
        </h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">address</th>
                <th scope="col">operations</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($hospitals) && $hospitals->count()>0)
                @foreach($hospitals as $hospital)
                    <tr>
                        <th scope="row">{{$hospital->id}}</th>
                        <td>{{$hospital->name}}</td>
                        <td>{!! $hospital->address !!}</td>

                        <td>
                            <a href="{{route('doctors.show',$hospital->id)}}" class="btn btn-success">عرض الأطباء</a>
                            <a href="{{route('hospital.delete',$hospital->id)}}" class="btn btn-danger">حذف</a>
                            {{--<a href="" offer_id="{{$offer->id}}" class="delete_btn btn btn-danger"> حذف اجاكس     </a>
                            <a href="{{route('ajaxoffers.edit',$offer->id)}}" class="btn btn-warning"> تعديل</a>--}}
                        </td>

                    </tr>
                @endforeach
            @endif
            </tbody>


        </table>
    </div>

@stop


@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>
            الخدمات
        </h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">operations</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($services) && $services->count()>0)
                @foreach($services as $service)
                <tr>
                    <th scope="row">{{$service->id}}</th>
                    <td>{{$service->name}}</td>
                    <td></td>

                    <td>
                        {{--<a href="{{route('offers.edit',$offer->id)}}" class="btn btn-success"> {{__('message.update')}}</a>
                        <a href="{{route('offers.delete',$offer->id)}}" class="btn btn-danger"> {{__('message.delete')}}</a>
                        <a href="" offer_id="{{$offer->id}}" class="delete_btn btn btn-danger"> حذف اجاكس     </a>
                        <a href="{{route('ajaxoffers.edit',$offer->id)}}" class="btn btn-warning"> تعديل</a>--}}
                    </td>

                </tr>
                @endforeach
            @endif

            </tbody>
        </table>
            <br>
            <br>
            <form method="post" action="{{route('save.doctors.services')}}" >
                @csrf
                {{--<input name="_token" value="{{csrf_token()}}">--}}

                <div class="form-group">
                    <label for="exampleInputEmail1">اختر طبيب</label>
                    @if(isset($doctors) && $doctors->count()>0)
                    <select name="doctor_id" class="form-control">
                        @foreach($doctors as $doctor)
                            <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">اختر الخدمات</label>
                    @if(isset($servicess) && $servicess->count()>0)
                    <select name="service_id[]" class="form-control" multiple>
                        @foreach($servicess as $servic)
                            <option value="{{$servic->id}}">{{$servic->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
    </div>

@stop


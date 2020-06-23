@extends('layouts.app')

@section('content')

    <div class="alert alert-success" id="success_msg" style="display: none">
        تم الحذف بنجاح
    </div>
    <div class="alert alert-danger" id="error_msg" style="display: none">
        لم يتم الحذف حدث خطأ ما
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('message.Offer Name')}}</th>
            <th scope="col">{{__('message.Offer Price')}}</th>
            <th scope="col">{{__('message.Offer Details')}}</th>
            <th scope="col">صورة العرض</th>
            <th scope="col">{{__('message.operation')}}</th>
        </tr>
        </thead>
        <tbody>


        @foreach($offers as $offer)
            <tr class="offerRow{{$offer->id}}">
                <th scope="row">{{$offer -> id}}</th>
                <td>{{$offer->name}}</td>
                <td>{{$offer->price}}</td>
                <td>{{$offer->details}}</td>
                <td><img  style="width: 90px; height: 90px;" src="{{asset('images/offers/'.$offer->photo)}}"></td>

                <td>
                    <a href="{{route('offers.edit',$offer->id)}}" class="btn btn-success"> {{__('message.update')}}</a>
                    <a href="{{route('offers.delete',$offer->id)}}" class="btn btn-danger"> {{__('message.delete')}}</a>
                    <a href="" offer_id="{{$offer->id}}" class="delete_btn btn btn-danger"> حذف اجاكس     </a>
                    <a href="{{route('ajaxoffers.edit',$offer->id)}}" class="btn btn-warning"> تعديل</a>
                </td>

            </tr>
        @endforeach

        </tbody>


    </table>
@stop


@section('scripts')
    <script>
        $(document).on('click','.delete_btn',function (e) {
            e.preventDefault();

            //to get the id of offer from delete btn
            var offer_id = $(this).attr('offer_id');

            $.ajax({
                type:'post',
                url:"{{route('ajaxoffers.delete')}}",
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': offer_id
                },
                success:function (data) {
                    if(data.status == true)
                        //alert(data.success_msg)
                        $('#success_msg').show();
                    //to delete row from table
                    $('.offerRow'+data.id).remove();
                },
                error:function (reject) {
                    if(reject.status == false)
                        //alert(reject.error_msg)
                        $('#error_msg').show();
                }
            });
        });

    </script>
@stop

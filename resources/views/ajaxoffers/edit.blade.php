@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="alert alert-success" id="success_msg" style="display: none">
            تم التعديل بنجاح
        </div>
        <div class="alert alert-danger" id="error_msg" style="display: none">
            لم يتم التعديل حدث خطأ ما
        </div>

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    {{__('message.Add your offer')}}

                </div>

                <br>
                <form method=""  id="offerFormUpdate" action="" >
                    @csrf
                    {{-- <input name="_token" value="{{csrf_token()}}"> --}}

                    <div class="form-group">
                        <label for="exampleInputEmail1">أختر صوره العرض</label>
                        <input type="file" id="file" class="form-control" name="photo">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('message.Offer Name ar')}}</label>
                        <input type="text" class="form-control" value="{{$offer->name_ar}}" name="name_ar"
                               placeholder="{{__('message.Offer Name')}}">
                    </div>

                    <input type="text" style="display: none;" class="form-control" value="{{$offer->id}}" name="id">

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('message.Offer Name en')}}</label>
                        <input type="text" class="form-control" value="{{$offer->name_en}}" name="name_en"
                               placeholder="{{__('message.Offer Name')}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{__('message.Offer Price')}}</label>
                        <input type="text" class="form-control" value="{{$offer->price}}" name="price"
                               placeholder="{{__('message.Offer Price')}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{__('message.Offer Details ar')}}</label>
                        <input type="text" class="form-control" value="{{$offer->details_ar}}" name="details_ar"
                               placeholder="{{__('message.Offer Details')}}">
                    </div>

                    <div class="form-group">
                        <label for="">{{__('message.Offer Details en')}}</label>
                        <input type="text" class="form-control" value="{{$offer->details_en}}" name="details_en"
                               placeholder="{{__('message.Offer Details')}}">
                    </div>

                    <button id="update_offer" class="btn btn-primary">
                        {{__('message.Update Offer')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).on('click', '#update_offer', function (e) {
            e.preventDefault();
            var formData = new FormData($('#offerFormUpdate')[0]);

            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: '{{route('ajaxoffers.update')}}',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if(data.status == true)
                        //alert(data.success_msg)
                        $('#success_msg').show();
                },
                error: function (reject) {
                    if(reject.status == false)
                        //alert(reject.error_msg)
                        $('#error_msg').show();
                }
            });
        });
    </script>
@stop

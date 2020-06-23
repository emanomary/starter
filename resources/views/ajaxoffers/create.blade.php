@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="alert alert-success" id="success_msg" style="display: none">
            تم الحفظ بنجاح
        </div>
        <div class="alert alert-danger" id="error_msg" style="display: none">
            لم يتم الحفظ
        </div>

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    {{__('message.Add your offer')}}

                </div>

                <br>
                <form method="" id="offerForm" action="" enctype="multipart/form-data">
                    @csrf
                    {{-- <input name="_token" value="{{csrf_token()}}"> --}}

                    <div class="form-group">
                        <label for="exampleInputEmail1">أختر صورة العرض</label>
                        <input type="file" id="file" class="form-control" name="photo">
                        <small id="photo_error" class="form-text text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('message.Offer Name ar')}}</label>
                        <input type="text" class="form-control" name="name_ar"
                               placeholder="{{__('message.Offer Name')}}">
                        <small id="name_ar_error" class="form-text text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">{{__('message.Offer Name en')}}</label>
                        <input type="text" class="form-control" name="name_en"
                               placeholder="{{__('message.Offer Name')}}">
                        <small id="name_en_error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{__('message.Offer Price')}}</label>
                        <input type="text" class="form-control" name="price"
                               placeholder="{{__('message.Offer Price')}}">
                        <small id="price_error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{__('message.Offer Details ar')}}</label>
                        <input type="text" class="form-control" name="details_ar"
                               placeholder="{{__('message.Offer Details')}}">
                        <small id="details_ar_error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{__('message.Offer Details en')}}</label>
                        <input type="text" class="form-control" name="details_en"
                               placeholder="{{__('message.Offer Details')}}">
                        <small id="details_en_error" class="form-text text-danger"></small>
                    </div>

                    <button id="save_offer" class="btn btn-primary">{{__('message.Save Offer')}}</button>
                </form>


            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).on('click','#save_offer',function (e) {
            e.preventDefault();
            //delete all error messages
            $('#photo_error').text('');
            $('#name_ar_error').text('');
            $('#name_en_error').text('');
            $('#price_error').text('');
            $('#details_ar_error').text('');
            $('#details_en_error').text('');

            //take all data of form and save it in formData variable
            var formData = new FormData($('#offerForm')[0]);

            $.ajax({
                type:'post',
                url:"{{route('ajaxoffers.store')}}",
                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                cache:false,
                success:function (data) {
                    if(data.status == true)
                        //alert(data.success_msg)
                        $('#success_msg').show();
                },
                error:function (reject) {
                    //show error validation under fields
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });

    </script>
@stop


@extends('layout.default')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-header py-5">
            <div class="d-flex justify-content-between align-items-center">
                <span id="card_title">
                    <p class="m-0 type">Type / Tempat</p>
                    <h4 class="m-0 position">Position</h4>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="descriptions"></div>
                </div>
                <div class="col-md-4">
                    <div class="detail">
                        <div class="card">
                            <div class="card-body">
                                <p class="company">ASD</p><hr>
                                <img src="" height="300" id="logo" alt="logo perusahaan">
                                <a href="" class="link"><p class="url pt-3"></p></a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>How to apply</p><hr>
                                <div class="how_to"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var id = "{{$id}}";
        $.ajax({
            type: "get",
            url: "http://dev3.dansmultipro.co.id/api/recruitment/positions/" + id ,
            data: "data",
            dataType: "json",
            success: function (response) {
                $('.type').html(response.type +"/"+ response.location);
                $('.position').html(response.title);
                $('.descriptions').html(response.description);
                $('.url').html(response.company_url);
                $('.link').attr('href', response.company_url);
                $('.company').html(response.company);
                $('.how_to').html(response.how_to_apply);

                var logo = "";
                if (response.company_logo != null){
                    logo = response.company_logo;
                }else{
                    logo = '/img/blank.jpg'
                }
                $('#logo').attr('src', logo)
            }
        });
    </script>
@endsection

@extends('layout.default')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="m-0">{{ $message }}</p>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="descriptions" id="descriptions" class="form-control"
                placeholder="Search Description ...">
        </div>
        <div class="col-md-4">
            <input type="text" name="locations" id="locations" class="form-control" placeholder="Search Location ...">
        </div>
        <div class="col-md-2">
            <div class="d-flex align-items-center h-100">
                <div>
                    <input type="checkbox" id="fullTime" name="fullTime" value="Full Time">
                    <label for="full-time" class="m-0"> Full Time</label>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" id="btn-search">Search</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header py-5">
            <div class="d-flex justify-content-between align-items-center">
                <span id="card_title">
                    <h4 class="m-0">{{ __('Job List') }}</h4>
                </span>
            </div>
        </div>
        <div class="card-body job_lists"></div>
    </div>
    <button class="btn btn-primary btn-block mt-5" id="btn-load-more">Load More</button>
@endsection
@section('scripts')
    <script>
        var page = 1;

        function loadData() {
            $.ajax({
                type: "get",
                url: "http://dev3.dansmultipro.co.id/api/recruitment/positions.json?page=" + page,
                data: "data",
                dataType: "json",
                success: function(response) {
                    var html = "";
                    var url = "";
                    console.log(response);
                    $.each(response, function(i, v) {
                        if (v != null) {
                            if (v.company_url != null) {
                                url = "<h5><a href='/application/detail/" + v.id + "' target='_blank'>";
                            } else {
                                url = "<h5><a href='#' target='_blank'>";
                            }
                            html += "<div>" +
                                "<div class='d-flex justify-content-between'>" +
                                url +
                                v.title +
                                "</a></h5>" +
                                "<p><strong>" +
                                v.location +
                                "</strong></p>" +
                                "</div>" +
                                "<div class='d-flex justify-content-between'>" +
                                "<p>" +
                                v.company + " - " + v.type +
                                "</p>" +
                                "<p>" +
                                v.created_at +
                                "</p>" +
                                "</div>" +
                                "</div><hr>";
                        }
                    });
                    $(".job_lists").append(html);
                },
                error: function(response) {
                    $("#btn-load-more").html("On The Last Page")
                }
            });
        }

        loadData();

        $("#btn-load-more").click(function(e) {
            page++;
            loadData();
        });

        $("#btn-search").click(function(e) {
            console.log("aaaaaaaaaaaaaaaa")
            var descriptions = $('#descriptions').val();
            var locations = $('#locations').val();
            var fullTime = "";


            if ($("#fullTime").is(':checked')) {
                fullTime = $('#fullTime').val();
            }

            $.ajax({
                type: "get",
                url: "http://dev3.dansmultipro.co.id/api/recruitment/positions.json?description=" +
                    descriptions + "&location=" + locations + "&type=" + fullTime,
                dataType: "json",
                success: function(response) {
                    var html = "";
                    var url = "";
                    console.log(response);
                    $.each(response, function(i, v) {
                        if (v != null) {
                            if (v.company_url != null) {
                                url = "<h5><a href='/application/detail/" + v.id +
                                    "' target='_blank'>";
                            } else {
                                url = "<h5><a href='#' target='_blank'>";
                            }
                            html += "<div>" +
                                "<div class='d-flex justify-content-between'>" +
                                url +
                                v.title +
                                "</a></h5>" +
                                "<p><strong>" +
                                v.location +
                                "</strong></p>" +
                                "</div>" +
                                "<div class='d-flex justify-content-between'>" +
                                "<p>" +
                                v.company + " - " + v.type +
                                "</p>" +
                                "<p>" +
                                v.created_at +
                                "</p>" +
                                "</div>" +
                                "</div><hr>";
                        }
                    });
                    $(".job_lists").html(html);
                }
            });
        });
    </script>
@endsection

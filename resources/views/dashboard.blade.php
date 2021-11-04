@extends('layout')

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ $user->name }}</h3>
                        <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="mdi mdi-calendar"></i> Today ({{ date('d-m-Y', time()) }})
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people mt-auto">
                        <img src="{{ asset('assets/images/dashboard/people.svg') }}" alt="people">
                        <div class="weather-info">
                            <div class="d-flex">
                                <div>
                                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                                </div>
                                <div class="ml-2">
                                    <h4 class="location font-weight-normal">Großaitingen</h4>
                                    <h6 class="font-weight-normal">Germany</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <style>
                                    .switch {
                                        position: relative;
                                        display: inline-block;
                                        width: 60px;
                                        height: 34px;
                                    }

                                    .switch input {
                                        opacity: 0;
                                        width: 0;
                                        height: 0;
                                    }

                                    .slider {
                                        position: absolute;
                                        cursor: pointer;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        background-color: #ccc;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                    }

                                    .slider:before {
                                        position: absolute;
                                        content: "";
                                        height: 26px;
                                        width: 26px;
                                        left: 4px;
                                        bottom: 4px;
                                        background-color: white;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                    }

                                    input:checked + .slider {
                                        background-color: #2196F3;
                                    }

                                    input:focus + .slider {
                                        box-shadow: 0 0 1px #2196F3;
                                    }

                                    input:checked + .slider:before {
                                        -webkit-transform: translateX(26px);
                                        -ms-transform: translateX(26px);
                                        transform: translateX(26px);
                                    }

                                    /* Rounded sliders */
                                    .slider.round {
                                        border-radius: 34px;
                                    }

                                    .slider.round:before {
                                        border-radius: 50%;
                                    }
                                </style>
                                <p class="mb-4">Layout One</p>

                                <form action="">
                                    <label class="switch">
                                        <input id="sectionON" name="active" onclick="getMessage()" type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
            </div>
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
            </div>
        </footer>
        <!-- partial -->
    </div>

@endsection

@section('scripts')
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        @parent
    <script>

        function getMessage() {
            var checkvalue = document.getElementById("sectionON").checked;

            var checkmeet = '';
            if(checkvalue == true){
                $.ajax({
                    headers: {
                        "_token": "{{ csrf_token() }}",
                    },
                    type:'POST',
                    url: '{{route("sliderOnOff")}}',
                    data:{
                        _token: "{{ csrf_token() }}",
                        _host: '{{\Illuminate\Support\Facades\Auth::user()->name}}',
                        auth: '{{\Illuminate\Support\Facades\Auth::user() }}',
                        slug: 'Slider Section',
                        value: 1,
                    },
                    success:function(data) {
                        console.log(data);
                    }
                });
            }else{
                $.ajax({
                    headers: {
                        "_token": "{{ csrf_token() }}",
                    },
                    type:'POST',
                    url: '{{route("sliderOnOff")}}',
                    data:{
                        _token: "{{ csrf_token() }}",
                        _host: '{{\Illuminate\Support\Facades\Auth::user()->name }}',
                        auth: '{{\Illuminate\Support\Facades\Auth::user() }}',
                        slug: 'Slider Section',
                        value: 0,
                    },
                    success:function(data) {
                        console.log(data);
                    }
                });
            }
        }
    </script>
@endsection

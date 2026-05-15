
@extends('_layouts._exec-dashboard')

@section('styles')

<link href="{{ asset('/assets/vendor/css/swiper.css') }}" rel="stylesheet" type="text/css">
    <style>
        .swiper-container {
            width: 100%;
            border: none;
            padding:20px 20px;
        }

        .swiper-pagination {
            bottom: -5px!important;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-pagination-bullet {
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            color: #000;
            opacity: 1;
            background: rgba(0, 0, 0, 0.2);
        }

        .swiper-pagination-bullet {
            width: 15px;
            height: 15px;
        }

        .swiper-pagination-bullet-active {
            color: #fff;
            background: #1b39a8;
        }

        .swiper-button-next, .swiper-button-prev {
            font-weight:bold;
            font-size: 10px;
            color: rgb(168, 168, 168);
        }

    </style>

@endsection


@section('content')
    <div class="row pop-up-wrapper"></div>
    <h1 class="display-4"><i class="fas fa-users"></i> Show Sale</h1>

    @include('admin.inc._messages')


        <div class="s-card-header alert-light px-3 border-bottom-0">
            <div class="row pt-2">
                <div class="col-6">
                    <span class="fs-120 ">{{$sale->exec->name}} </span> - <span class="normal"> Sale</span>
                </div>
                <div class="col-6 text-end">
                    <a href="{{route('exec.dashboard')}}" class="btn btn-border sister py-0">Back</a>
                </div>
            </div>
        </div>
        <div class="line mb-4"></div>

        <div class="s-card-body p-0 border-top-0 ">

            <form action="{{route('exec.sale.update', [$sale->id])}}" enctype="multipart/form-data" method="POST">
                {{csrf_field()}}


                {{--Customer Details and Contact--}}
                    <div class="row">

                        {{--Customer Details--}}
                            <div class="col-lg-6">
                                <div class="s-card shadow">
                                    <div class="s-card-header bg-brand p-3 ">
                                        Customer Details
                                    </div>

                                    <div class="s-card-body alert-light">
                                        <div class="form-group">
                                            <div class="row border-bottom pb-2">
                                                <div class="col-lg-5 bold border-right">
                                                    Customer name
                                                </div>
                                                <div class="col">
                                                    {{ $sale->book->title}}  {{ $sale->book->name}} {{ $sale->book->surname }}
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        {{--END--}}


                    </div>
                {{--END--}}

                {{--Safe Prospects and View Sale Buttons--}}
                    <div class="js-btn-holder">
                        @if($sale)
                            <a href="javascript:void(0)" class="btn btn-default success js-view-sale mr-2"  sale-id="{{$sale->id}}"><i class="fas fa-handshake mr-2"></i> View Sale </a>
                        @endif

                        <button type="submit" name="button" class="btn btn-default brother "><i class="fas fa-save mr-2"></i> Save Changes </button>
                    </div>
                {{--END--}}

            </form>
        </div>



@endsection


@section('scripts')



    <script>
        $(function(){




        });



    </script>

@endsection

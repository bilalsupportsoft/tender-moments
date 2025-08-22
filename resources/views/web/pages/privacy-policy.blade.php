@extends('web.layouts.app')
@section('content')
<style>
    .ulli ul li {
            list-style-type: disc;
            list-style: disc;
        }
        .ulli ul {
            margin: 10px;
        }
        .text-color{
             color: black!important;
        }
        body {
            overflow: visible !important;
            }
</style>
<div class="main-wrapper-inner bg-white">
    <div class="clearfix"></div>
    <div class="booking-flow-web">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <section class="s-banner-with-text section-pd banner-text-pet ms-top-gap ">
                        <div class="container">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="heing-sing">
                                        <div class="mybookinginfo">
                                            <h3>{{ $page->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="privecy-text ulli text-justify text-color">
                                        {!! html_entity_decode($page->value) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection
@section('script')
@endsection

@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Admin</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ number_format($TotalSlots) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Booked Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ number_format($TotalBooking) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Pending Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ $TotalPending }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Cancelled Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ $TotalCancelled }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Active Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ $TotalActiveSlots }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    <!-- / Footer -->
@endsection
@section('script')
@endsection

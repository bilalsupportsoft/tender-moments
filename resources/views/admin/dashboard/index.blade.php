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
                                                <h5 class="card-title">Total Active Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ $TotalActiveSlots }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Users</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ $TotalUser }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-10 col-lg-10">
                                                <h5 class="card-title mb-0">Recent Users</h5>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 text-end">
                                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">View All</a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Residency</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($Recentusers as $Recentuser)
                                                        <tr>
                                                            <td>{{ $Recentuser->name }}</td>
                                                            <td>{{ $Recentuser->email }}</td>
                                                            <td>{{ $Recentuser->residency }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

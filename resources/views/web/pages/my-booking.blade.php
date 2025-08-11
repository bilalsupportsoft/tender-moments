@extends('web.layouts.app')
@section('content')
    <div class="clearfix"></div>
    <!-- End Popup Mobile Menu  -->
    <div class="main-wrapper-inner  bg-white">
        <div class="booking-flow-web">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 mx-auto">
                        <div class="d-flex justify-content-between">
                            <div class="heing-sing">
                                <div class="mybookinginfo">
                                    <h3> <img src="assets/web/list-of-icon.png" alt="" width="60"> My Booking
                                    </h3>
                                </div>
                            </div>
                            <div class="filter">
                                <div class="filter-box">
                                    <div class="fi-infodate">
                                        <span> <img src="assets/web/short.png" alt="" width="60"> Sort By:
                                        </span>
                                        <select id="bookingFilter" onchange="filterChange(this.value)">
                                            <option value="reset">-- Select --</option>
                                            <option value="active">Active Booking</option>
                                            <option value="upcoming">Upcoming Booking</option>
                                            <option value="completed">Completed Booking</option>
                                            <option value="cancelled">Cancelled Booking</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="booking-list">
                            @include('web.pages.partials.booking-list', [
                                'filteredBookings' => $bookings ?? [],
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
@section('script')
    <script>
        function filterChange(value) {
            if (value === "reset") {
                location.reload();
            } else {
                console.log("Selected Filter:", value);
                $.ajax({
                    url: "{{ route('bookings.filter') }}",
                    method: 'GET',
                    data: {
                        filter: value
                    },
                    success: function(response) {
                        $('#booking-list').html(response);
                    }
                });
            }
        }
    </script>
@endsection

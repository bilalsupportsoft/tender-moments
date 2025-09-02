@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="row">
                            {{-- <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Admin</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-lg-12">
                                <div class="row">
                                     <div class="col-lg-2 col-md-6 col-12 mb-4">
                                        <div class="card text-white bg-info">
                                            <a href="{{ route('admin.users.index') }}">
                                            <div class="card-body">
                                                <h5 class="card-title" style="color: white">Total Users</h5>
                                                <h3 style="color: white">{{ $TotalUser }}</h3>
                                            </div>
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12 mb-4">
                                        <div class="card text-white bg-primary">
                                            <a href="{{ route('admin.bookings.index', ['status' => 'Booked']) }}">
                                            <div class="card-body">
                                                <h5 class="card-title" style="color: white">Today Booking</h5>
                                                <h3 style="color: white" >{{ $TodayBooking }}</h3>
                                            </div>
                                        </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12 mb-4">
                                        <div class="card text-white bg-warning">
                                            <a href="{{ route('admin.bookings.index',['status' => '1']) }}">
                                            <div class="card-body">
                                                <h5 class="card-title" style="color: white">Upcoming Booking</h5>
                                                <h3 style="color: white">{{ $UpcomingBooking }}</h3>
                                            </div>
                                        </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12 mb-4">
                                        <div class="card text-white bg-danger">
                                            <a href="{{ route('admin.bookings.index',['status' => '0']) }}">
                                            <div class="card-body">
                                                <h5 class="card-title" style="color: white">Cancelled Bookings</h5>
                                                <h3 style="color: white">{{ $CancelledBooking }}</h3>
                                            </div>
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12 mb-4">
                                        <div class="card text-white bg-success">
                                            <a href="{{ route('admin.bookings.index', ['status' => 'Completed']) }}">
                                            <div class="card-body">
                                                <h5 class="card-title" style="color: white">Completed Bookings</h5>
                                                <h3 style="color: white">{{ $CompletedBooking }}</h3>
                                            </div>
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-10 col-lg-10">
                                                <h5 class="card-title mb-0">Sign-in Recent Users</h5>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 text-end">
                                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">View All</a>
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

                            <div class="col-xl-6 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-10 col-lg-10">
                                                <h5 class="card-title mb-0">Recent Bookings</h5>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 text-end">
                                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary btn-sm">View All</a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                        <th>Slot Date</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($RecentBookings as $RecentBooking)
                                                        @php
                                                            $slot = $RecentBooking->slot;
                                                            $slotDate = \Carbon\Carbon::parse($slot->slot_date ?? null);
                                                            $today = \Carbon\Carbon::today();
                                                            $status = '';

                                                            if ($RecentBooking->status == 0) {
                                                                $status = 'Cancelled';
                                                            } elseif ($RecentBooking->status === 'confirmed') {
                                                                if ($slotDate->isToday()) {
                                                                    $status = 'Today Booking';
                                                                } elseif ($slotDate->isFuture()) {
                                                                    $status = 'Upcoming';
                                                                } elseif ($slotDate->isPast()) {
                                                                    $status = 'Completed';
                                                                }
                                                            } else {
                                                                $status = 'Not Booked';
                                                            }
                                                            // print_r($Recentslot->toArray());
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $RecentBooking->user->name }}</td>
                                                            <td>{{ $RecentBooking->total_amount }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($slotDate)->format('d-M-Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($RecentBooking->slot->start_time)->format('h:i A') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($RecentBooking->slot->end_time)->format('h:i A') }}</td>
                                                            <td>
                                                                @switch($status)
                                                                @case('Today Booking')
                                                                    <span class="badge bg-info w-100">{{ $status }}</span>
                                                                    @break
                                                                @case('Upcoming')
                                                                    <span class="badge bg-warning w-100">{{ $status }}</span>
                                                                    @break
                                                                @case('Cancelled')
                                                                    <span class="badge bg-danger w-100">{{ $status }}</span>
                                                                    @break
                                                                @case('Completed')
                                                                    <span class="badge bg-success w-100">{{ $status }}</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge bg-secondary w-100">{{ $status }}</span>
                                                                @endswitch
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="container-fluid flex-grow-1 container-p-y">
                                    {{-- <h5 class="card-title">Users</h5> --}}
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-10 col-lg-10">
                                                        <h5 class="card-title mb-0">Users Traffic</h5>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 text-end">
                                                         <select id="orderYear" class="form-select w-auto">
                                                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                                            <option value="{{ $y }}">{{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div id="monthlyOrdersChart" style="height: 350px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6">
                                <div class="container-fluid flex-grow-1 container-p-y">
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-10 col-lg-10">
                                                        <h5 class="card-title mb-0">Booked Slots</h5>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 text-end">
                                                        <select id="bookingYear" class="form-select w-auto">
                                                            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                                                <option value="{{ $y }}">{{ $y }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div id="monthlyBookingsChart" style="height: 350px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
@section('script')
<script>
    let chart;

    function loadMonthlyOrders(year) {
        fetch(`{{ route('admin.UserChartData') }}?year=${year}`)
            .then(res => res.json())
            .then(response => {
                const data = response.data;
                const maxValue = Math.max(...data);
                const yAxisMax = Math.ceil((maxValue + 1) / 5) * 5 || 5;

                const options = {
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Orders',
                        data: data
                    }],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.6,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                        ]
                    },
                    yaxis: {
                        min: 0,
                        max: yAxisMax,
                        forceNiceScale: true,
                        labels: {
                            formatter: function(val) {
                                return Math.floor(val);
                            }
                        }
                    },
                    tooltip: {
                        x: {
                            format: 'MMM'
                        }
                    },
                    colors: ['#3B82F6']
                };

                if (chart) {
                    chart.updateOptions({
                        series: options.series,
                        yaxis: options.yaxis
                    });
                } else {
                    chart = new ApexCharts(document.querySelector("#monthlyOrdersChart"), options);
                    chart.render();
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const yearDropdown = document.getElementById('orderYear');

        loadMonthlyOrders(yearDropdown.value);

        yearDropdown.addEventListener('change', function() {
            loadMonthlyOrders(this.value);
        });
    });
</script>
<script>
      let bookingChart;

function loadMonthlyBookings(year) {
    fetch(`{{ route('admin.BookingChartData') }}?year=${year}`)
        .then(res => res.json())
        .then(response => {
            const data = response.data;
            const maxValue = Math.max(...data);
            const yAxisMax = Math.ceil((maxValue + 1) / 5) * 5 || 5;

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Confirmed Bookings',
                    data: data
                }],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: "50%"
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ]
                },
                yaxis: {
                    min: 0,
                    max: yAxisMax,
                    forceNiceScale: true,
                    labels: {
                        formatter: function(val) {
                            return Math.floor(val);
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'MMM'
                    }
                },
                colors: ['#49eb36']
            };

            if (bookingChart) {
                bookingChart.updateOptions({
                    series: options.series,
                    yaxis: options.yaxis
                });
            } else {
                bookingChart = new ApexCharts(document.querySelector("#monthlyBookingsChart"), options);
                bookingChart.render();
            }
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const yearDropdown = document.getElementById('bookingYear');

    loadMonthlyBookings(yearDropdown.value);

    yearDropdown.addEventListener('change', function() {
        loadMonthlyBookings(this.value);
    });
});
</script>
@endsection

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
                                    <div class="col-lg-6 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Users</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ $TotalUser }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Slots</h5>
                                                <h3 class="card-title text-nowrap mb-1">{{ number_format($TotalSlots) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
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

                            <div class="col-xl-6 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-xl-10 col-lg-10">
                                                <h5 class="card-title mb-0">Recent Slots</h5>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 text-end">
                                                <a href="{{ route('admin.slot.index') }}" class="btn btn-secondary btn-sm">View All</a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Price</th>
                                                        <th>Slot Date</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($Recentslots as $Recentslot)
                                                        <tr>
                                                            <td>{{ $Recentslot->price }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($Recentslot->slot_date)->format('d-M-Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($Recentslot->start_time)->format('h:i A') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($Recentslot->end_time)->format('h:i A') }}</td>
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
                                    <h5 class="card-title">Users</h5>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <select id="orderYear" class="form-select w-auto">
                                                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                                            <option value="{{ $y }}">{{ $y }}</option>
                                                        @endfor
                                                    </select>
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
                                    <h5 class="card-title">Booked Slots</h5>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <select id="bookingYear" class="form-select w-auto">
                                                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                                            <option value="{{ $y }}">{{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <div id="monthlyBookingsChart" style="height: 350px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-xl-6 col-lg-6">
                                <div class="container-fluid flex-grow-1 container-p-y">
                                    <h5 class="card-title"> Booked Slots</h5>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <select id="bookingYear" class="form-select w-auto">
                                                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                                            <option value="{{ $y }}">{{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                   <div id="monthlyBookingsChart" style="height: 350px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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

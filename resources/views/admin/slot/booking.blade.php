@extends('admin.layouts.app')

@section('style')
<style>
    .confirmed {
        background-color: #ff9007;
        color: #fff;
        width: 50%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-5">
        <span class="fw-light">Bookings</span>
    </h5>

    <div class="mb-3">
        <form method="GET" action="{{ route('admin.bookings.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Show All</option>
                        <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Today Booking</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Upcoming</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="slot_date" value="{{ request('slot_date') }}" class="form-control" onchange="this.form.submit()">
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary ms-2">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="bannersTable">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No.</th>
                                    <th>Price</th>
                                    <th>Slot Date</th>
                                    <th>Slot Time Start</th>
                                    <th>Slot Time End</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookingslots as $key => $bookingslot)
                                    @php
                                        $slot = $bookingslot->slot;
                                        $slotDate = \Carbon\Carbon::parse($slot->slot_date ?? null);
                                        $today = \Carbon\Carbon::today();
                                        $status = '';

                                        if ($bookingslot->status == 0) {
                                            $status = 'Cancelled';
                                        } elseif ($bookingslot->status === 'confirmed') {
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
                                        // print_r($bookingslot->toArray());
                                    @endphp
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $bookingslot->user->name ?? '-' }}</td>
                                        <td>{{ $bookingslot->user->email ?? '-' }}</td>
                                        <td>{{ $bookingslot->user->phone ?? '-' }}</td>
                                        <td>${{ $bookingslot->total_amount }}</td>
                                        <td>{{ $slotDate->format('d-M-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
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
                                        <td>
                                            @if ($status === 'Today Booking' || $status === 'Upcoming')
                                                {{-- <a href="{{ route('admin.users.show', $bookingslot->user->id) }}"
                                                    class="btn btn-sm btn-primary mb-1">User</a> --}}

                                                <a href="javascript:void(0);"
                                                    onclick="cancelBooking('{{ $bookingslot->id }}')"
                                                    class="btn btn-sm btn-danger mb-1">Cancel</a>
                                            {{-- @elseif ($status === 'Upcoming' || $status === 'Cancelled')
                                                <form class="status-form" data-id="{{ $bookingslot->id }}"
                                                    data-route="{{ route('admin.bookings.updateStatus', $bookingslot->id) }}">
                                                    @csrf
                                                    @method('POST')
                                                    <select name="status"
                                                        class="form-select form-select-sm status-dropdown {{ $status === 'Upcoming' ? 'confirmed' : 'bg-danger text-white w-50' }}">
                                                        <option value="1" {{ $status === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                        <option value="0" {{ $status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </form> --}}
                                            @else
                                                <span class="text-muted">No action</span>
                                            @endif


                                        </td>
                                        <td><a href="{{ route('admin.bookings.download.invoice', $bookingslot->id) }}">
                                            <img src="{{ asset('assets/web/bill.png') }}" alt="" width="32">Download Invoice
                                        </a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bookingslots->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function cancelBooking(bookingId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to cancel this booking?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url('admin/bookings/cancel') }}/' + bookingId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Cancelled!', res.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        Swal.fire('Error!', res.message || 'Failed to cancel.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
}
</script>
@endsection

@extends('admin.layouts.app')
@section('style')
<style>
    .confirmed{
        background-color: #ff9007;
        color: #fff;
        width: 50%;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h5 class="py-2 mb-5">
            <span class=" fw-light">Bookings</span>
        </h5>
        <div class="mb-3">
            <form method="GET" action="{{ route('admin.bookings.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Upcoming</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Cancelled</option>
                            <option value="Not Booked" {{ request('status') == 'Not Booked' ? 'selected' : '' }}>Not Booked</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="slot_date" value="{{ request('slot_date') }}" class="form-control" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary ms-2">Reset</a>
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
                                        <th>Price</th>
                                        <th>Slot Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookingslots as $bookingslot)
                                        @php
                                            $slotDate = \Carbon\Carbon::parse($bookingslot->slot_date);
                                            $status = '';

                                            if (
                                                $bookingslot->booking &&
                                                $bookingslot->booking->status === 'confirmed'
                                            ) {
                                                $status = 'Booked';
                                            } elseif ($bookingslot->status == 0) {
                                                $status = '0';
                                            } elseif (!$bookingslot->booking && $slotDate->isFuture()) {
                                                $status = '1';
                                            } elseif (!$bookingslot->booking && $slotDate->isPast()) {
                                                $status = 'Not Booked';
                                            }
                                        @endphp
                                        <tr>
                                            <td>${{ $bookingslot->price }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bookingslot->slot_date)->format('d-M-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bookingslot->start_time)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bookingslot->end_time)->format('h:i A') }}</td>
                                            <td>
                                                @if ($status === '1' || $status === '0')
                                                    <form class="status-form" data-id="{{ $bookingslot->id }}"
                                                        data-route="{{ route('admin.bookings.updateStatus', $bookingslot->id) }}">
                                                        @csrf
                                                        @method('POST')
                                                        <select name="status"
                                                            class="form-select form-select-sm status-dropdown
                                                    {{ $status === '1' ? 'confirmed' : 'bg-danger text-white w-50' }}">
                                                            <option value="1" {{ $status === '1' ? 'selected' : '' }}>
                                                                Upcoming</option>
                                                            <option value="0" {{ $status === '0' ? 'selected' : '' }}>
                                                                Cancelled</option>
                                                        </select>
                                                    </form>
                                                @else
                                                    @if ($status === 'Booked')
                                                    <span class="badge bg-success w-50">{{ $status }}</span>
                                                    <a href="{{ route('admin.users.show', @$bookingslot->booking->user->id) }}"
                                                       class="btn btn-sm btn-primary ms-2">
                                                        View Details
                                                    </a>
                                                @elseif ($status === 'Not Booked')
                                                    <span class="badge bg-secondary w-50">{{ $status }}</span>
                                                @endif
                                                @endif
                                            </td>
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
@endsection
@section('script')
    <script>
        $('#bannersTable').DataTable({});
        $(document).on('focusin', '.status-dropdown', function() {
            $(this).data('old', $(this).val());
        });

        $(document).on('change', '.status-dropdown', function(e) {
            const $select = $(e.currentTarget);
            const $form = $select.closest('.status-form');
            const route = $form.data('route');
            const newVal = $select.val();
            const oldVal = $select.data('old');
            const message = (newVal === '0') ?
                'Are you sure you want to Cancel this slot?' :
                'Mark this slot as Upcoming?';

            Swal.fire({
                title: 'Confirm',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'No'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: route,
                        data: $form.serialize(),
                        success: function(resp) {
                            if (resp.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: resp.message,
                                    timer: 1200,
                                    showConfirmButton: false
                                });
                                refreshSelectColor($select);
                                $select.data('old', newVal);
                            } else {
                                Swal.fire('Error', resp.message || 'Update failed', 'error');
                                $select.val(oldVal);
                                refreshSelectColor($select);
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                            $select.val(oldVal);
                            refreshSelectColor($select);
                        }
                    });
                } else {
                    $select.val(oldVal);
                    refreshSelectColor($select);
                }
            });
        });

        function refreshSelectColor($el) {
            $el.removeClass('bg-success bg-danger text-white');
            if ($el.val() === '1') {
                $el.addClass('confirmed');
            } else {
                $el.addClass('bg-danger text-white w-50');
            }
        }
    </script>
@endsection

@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h5 class="py-2 mb-2">
            <span class=" fw-light">Slots</span>
        </h5>
        <div class="mb-3 text-end">
            <a href="{{ route('admin.slot.create') }}" class="btn btn-primary">
                + Add Slot
            </a>
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
                                        <th>Booking Status</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slots as $slot)
                                        <tr>
                                            <td>${{ $slot->price }}</td>
                                            <td>{{ \Carbon\Carbon::parse($slot->slot_date)->format('d-M-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                                            <td>
                                                @php
                                                    $slotDateTime = \Carbon\Carbon::parse(
                                                        $slot->slot_date . ' ' . $slot->end_time,
                                                    );
                                                @endphp

                                                @if ($slot->bookingSlot)
                                                    @if ($slotDateTime->isPast())
                                                        <div class="active-booking">
                                                            <span class=""
                                                                style="background-color: #52012c;color: rgb(255, 255, 255);font-size: 15px;padding: 1px 11px;border-radius: 3px;display: inline-block;height: 45px;width: 250px;text-align: center;line-height: 45px;">
                                                                {{ $slot->bookingSlot->status == 'confirmed' ? 'Completed' : ucfirst($slot->bookingSlot->status) }}</span>
                                                        </div>
                                                    @else
                                                        <form
                                                            action="{{ route('admin.slot.booking.updateStatus', $slot->bookingSlot->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <select name="status" class="form-select"
                                                                onchange="changeSelectColor(this); this.form.submit();"
                                                                style="width: 100%;">
                                                                <option value="confirmed"
                                                                    {{ $slot->bookingSlot->status == 'confirmed' ? 'selected' : '' }}>
                                                                    Confirmed</option>
                                                                <option value="pending"
                                                                    {{ $slot->bookingSlot->status == 'pending' ? 'selected' : '' }}>
                                                                    Pending</option>
                                                                <option value="cancelled"
                                                                    {{ $slot->bookingSlot->status == 'cancelled' ? 'selected' : '' }}>
                                                                    Cancelled</option>
                                                            </select>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if ($slotDateTime->isPast())
                                                        <button type="button" style="width: 100%;"
                                                            class="btn btn-secondary" disabled>Time Over</button>
                                                    @else
                                                        <button type="button" style="width: 100%;"
                                                            class="btn btn-primary">Available</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <button
                                                    class="toggle-status btn btn-sm {{ $slot->status ? 'btn-success' : 'btn-danger' }}"
                                                    data-id="{{ $slot->id }}">
                                                    {{ $slot->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            </td>
                                            <td>
                                                <a onclick="deleteslot('{{ $slot->id }}',this)"
                                                    class="btn btn-danger btn-sm" style="color: white">Delete</a>
                                                <a href="{{ route('admin.slot.edit', $slot->id) }}"
                                                    class="btn btn-secondary btn-sm">Edit</a>
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

        function deleteslot(id, e) {
            let url = '{{ route('admin.slot.destroy', ':id') }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed == true) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status == true) {
                                $(e).closest("tr").remove();
                                setFlesh('success', 'deleted successfully');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                setFlesh('error', 'Something went wrong please try again');
                            }
                        },
                        error: function(data) {
                            setFlesh('error', 'Something went wrong please try again');
                        }
                    });

                }
            })
        }
        const csrfToken = '{{ csrf_token() }}';
        $('.toggle-status').on('click', function() {
            let btn = $(this);
            let id = btn.data('id');
            let url = '{{ route('admin.slot.status', ':id') }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the status.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'change'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            if (response.status) {
                                btn.text(response.new_status ? 'Active' : 'Inactive');
                                if (response.new_status) {
                                    btn.removeClass('btn-danger').addClass('btn-success');
                                } else {
                                    btn.removeClass('btn-success').addClass('btn-danger');
                                }
                                setFlesh('success',
                                    'status updated successfully');
                            } else {
                                Swal.fire('Failed!', 'Status update failed', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong', 'error');
                        }
                    });
                }
            });
        });

        function changeSelectColor(select) {
            // Reset style
            select.style.backgroundColor = '';

            if (select.value === 'confirmed') {
                select.style.backgroundColor = '#71dd37';
                select.style.color = 'white';
            } else if (select.value === 'pending') {
                select.style.backgroundColor = 'orange';
                select.style.color = 'white'; // For better text contrast
            } else if (select.value === 'cancelled') {
                select.style.backgroundColor = 'red';
                select.style.color = 'white';
            }
        }

        // Set initial color on page load
        document.querySelectorAll('select[name="status"]').forEach(function(sel) {
            changeSelectColor(sel);
        });
    </script>
@endsection

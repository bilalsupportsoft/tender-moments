@extends('admin.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    input[readonly] {
        background-color: #fff !important;
        cursor: not-allowed;
    }
</style>
    <div class="container-fluid flex-grow-1 container-p-y">
        <h5 class="py-2 mb-2">
            <span class=" fw-light">Edit Slot</span>
        </h5>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card">
                    <div class="card-body  pb-5">
                        <h4>Edit Slots for {{ \Carbon\Carbon::parse($slot->slot_date)->format('d-M-Y') }}</h4>

                        <table class="table table-bordered" id="bannersTable">
                            <thead>
                                <tr>
                                    <th>Slot Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($slots as $s)
                                <tr>
                                    <form action="{{ route('admin.slot.update', $s->id) }}" method="POST">
                                        @csrf
                                        <td>
                                            <input type="text" id="datepicker" name="slot_date" value="{{ \Carbon\Carbon::parse($s->slot_date)->format('d-m-Y') }}" class="form-control">
                                            @error('slot_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </td>
                                        <td>
                                            <input type="text" id="start_time" name="start_time" value="{{ $s->start_time }}" class="form-control">
                                            @error('start_time')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </td>
                                        <td>
                                            <input type="text" id="end_time" name="end_time" value="{{ $s->end_time }}" class="form-control">
                                            @error('end_time')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </td>
                                        <td>
                                            <a
                                            class="toggle-status btn btn-sm {{ $s->status ? 'btn-success' : 'btn-danger' }}"
                                            data-id="{{ $s->id }}" style="color: #fff">
                                            {{ $s->status ? 'Active' : 'Inactive' }}
                                        </a>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>

                                            <a onclick="deleteslot('{{ $s->id }}',this)"
                                                class="btn btn-danger btn-sm" style="color: white">Delete</a>
                                        </td>
                                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $('#bannersTable').DataTable({});

    flatpickr("#datepicker", {
    dateFormat: "d-m-Y",
    minDate: new Date().fp_incr(2),
    disableMobile: true,
    onChange: function(selectedDates) {
        const today = new Date();
        const selectedDate = selectedDates[0];
        const isToday =
            selectedDate.getDate() === today.getDate() &&
            selectedDate.getMonth() === today.getMonth() &&
            selectedDate.getFullYear() === today.getFullYear();
    }
});


    flatpickr("#start_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
    });

    flatpickr("#end_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
    });

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
</script>

</script>
@endsection

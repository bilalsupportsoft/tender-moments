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
            <span class=" fw-light">View Slot</span>
        </h5>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card profile-card">
                    <div class="card-body  pb-5">
                        <h4>Slots for {{ \Carbon\Carbon::parse($slot->slot_date)->format('d-M-Y') }}</h4>

                        <table class="table table-bordered" id="bannersTable">
                            <thead>
                                <tr>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($slots as $s)
                                <tr>
                                        <td>{{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</td>
                                        <td>

                                            <a onclick="deleteslot('{{ $s->id }}',this)"
                                                class="btn btn-danger btn-sm" style="color: white">Delete</a>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
</script>

</script>
@endsection

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
                                        <th>Total Slot</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slots as $slot)
                                        <tr>
                                            <td>${{ $slot->price }}</td>
                                            <td>{{ \Carbon\Carbon::parse($slot->slot_date)->format('d-M-Y') }}</td>
                                            <td> ( {{ $slot->slot_count }} )</td>
                                            <td>
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

        function changeSelectColor(select) {
            // Reset style
            select.style.backgroundColor = '';

            if (select.value === 'confirmed') {
                select.style.backgroundColor = '#71dd37';
                select.style.color = 'white';
            } else if (select.value === 'pending') {
                select.style.backgroundColor = 'orange';
                select.style.color = 'white';
            } else if (select.value === 'cancelled') {
                select.style.backgroundColor = 'red';
                select.style.color = 'white';
            }
        }

        document.querySelectorAll('select[name="status"]').forEach(function(sel) {
            changeSelectColor(sel);
        });
    </script>
@endsection

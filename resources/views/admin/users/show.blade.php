@extends('admin.layouts.app')

@section('content')
<style>
    .thumb-image{
        height: 100px;
        width: 100px;
        border: 1px solid lightgray;
        padding: 1px;
    }
    .header-title{
        text-transform: capitalize;
        font-size:;
    }
</style>
<div class="container-fluid flex-grow-1 container-p-y">
    <!-- User Info -->
    <h5 class="py-2 mb-2">
        <span class="text-dark fw-light"><strong> User Profile </strong></span>
    </h5>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="header-title">
                <span>
                @if(!empty($user->avatar) && file_exists(public_path('/').$user->avatar))
                    <img src="{{asset($user->avatar)}}" alt="User Image" class="thumb-image rounded-circle">
                @else
                    <img src="{{asset("assets/admin/img/avatars/no-user.jpg")}}"  alt="User Image" class="thumb-image rounded-circle">
                @endif
                </span>
                <span >{{$user->first_name}} {{$user->last_name}}</span>
            </h4>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <!-- User Slots -->
    <h2></h2>
    <h5 class="py-2 mb-2">
        <span class="text-dark fw-light"><strong> Slots </strong></span>
    </h5>
    {{-- @if($bookings->count() > 0) --}}
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Slot Time</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $key => $booking)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->slot_date)->format('d-M-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('h:i A') }}</td>
                                        <td>${{ $booking->price }}</td>
                                        <td>
                                            @if($booking->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @elseif($booking->status == 'pending')
                                                <span class="badge bg-secondary">Pending</span>
                                            @elseif($booking->status == 'confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @else
                                                <span class="badge bg-danger">cancelled</span>
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
    {{-- @else
    <p>No slots booked yet.</p>
@endif --}}

</div>
@endsection

@section('script')
<script>
$('#usersTable').DataTable({
});
</script>
@endsection

@extends('admin.layouts.app')
@section('style')

@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Users</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Residency</th>
                                    <th>Slots</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <th>{{ $user->name }}</th>
                                    <th>{{ $user->email }}</th>
                                    <th>{{ $user->residency }}</th>

                                    <th><a href="{{ route("admin.users.show",$user->id) }}" class="btn btn-sm btn-primary">View</a></th>
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
$('#usersTable').DataTable({
});



function userStatus(userid,status){
    var message = '';
    if(status == 'active'){
        message = 'User able to login after active!';
    }else{
        message = 'User cannot login after Inactive!';
    }


    Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Okey'
    }).then((result) => {
        if(result.isConfirmed == true) {
            $.ajax({
                type: "POST",
                url: "{{route('admin.users.status')}}",
                data: {'userid':userid,'status':status,'_token': "{{ csrf_token() }}"},
                success: function(response) {
                    if(response.success){
                        if(status == 1){
                            setFlesh('success','User Activate Successfully');
                        }else{
                            setFlesh('success','User Inactivate Successfully');
                        }
                        $('#usersTable').DataTable().ajax.reload();
                    }else{
                        setFlesh('error','There is some problem to change status!Please contact to your server adminstrator');
                    }
                }
            });
        }else{
            $('#usersTable').DataTable().ajax.reload();
        }
    })
}


function deleteUser(userid){
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if(result.isConfirmed == true) {
            var url = '{{ route("admin.users.destroy", ":userid") }}';
            url = url.replace(':userid', userid);
            $.ajax({
                type: "DELETE",
                url: url,
                data: {'_token': "{{ csrf_token() }}"},
                success: function(response) {
                    if(response.success){
                        setFlesh('success','User Deleted Successfully');
                        $('#usersTable').DataTable().ajax.reload();
                    }else{
                        setFlesh('error','There is some problem to delete user!Please contact to your server adminstrator');
                    }
                }
            });
        }
    })
}
</script>
@endsection

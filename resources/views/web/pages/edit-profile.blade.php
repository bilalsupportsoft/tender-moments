@extends('web.layouts.app')
@section('content')
    <!-- End Popup Mobile Menu  -->
    <div class="main-wrapper-inner bg-white">
        <div class="clearfix"></div>
        <div class="booking-flow-web">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 mx-auto">
                        <div class="heing-sing">
                            <div class="mybookinginfo">
                                <h3> <img src="assets/web/edit-profile.png" alt="" width="60"> Edit Profile</h3>
                            </div>
                        </div>
                        <div class="profile-container">
                            <div id="message" style="margin-top: 10px;"></div>
                            <form id="editProfileForm" enctype="multipart/form-data">
                                @csrf
                                <div class="profile-pisc">
                                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/web/images/no-user.jpg') }}"id="preview"
                                        alt="Profile Picture">
                                    <br />
                                    <label class="upload-label" for="profileUpload">Change Photo (Optional)</label>
                                    <input type="file" id="profileUpload" name="profile_image" accept="image/*"
                                        onchange="loadImage(event)">
                                </div>
                                <span class="text-danger error-text profile_image_error"></span>
                                <h2 class="edit-profile-info">Edit Profile</h2>

                                <label for="fullname" class="name-of-fild">Full Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Name"class="fild-profile-info">
                                <span class="text-danger error-text name_error"></span><br>

                                <label for="email" class="name-of-fild">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" placeholder="Email"class="fild-profile-info">
                                <span class="text-danger error-text email_error"></span><br>
                                {{-- <label for="mobile" class="name-of-fild">Mobile No.</label>
                                <input type="text" name="mobile" value="{{ Auth::user()->phone }}"
                                    placeholder="+61 2568 69265265" class="fild-profile-info"> --}}
                                <span class="text-danger error-text mobile_error"></span>
                                <button type="submit" class="submit-btn">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
@section('script')
    <script>
        function loadImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        $('#editProfileForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('user.update.profile') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $('#message').html("Updating...");
                },
                success: function(response) {
                    $('#message').html(
                        '<div class="alert alert-success">Profile updated successfully!</div>');
                    setTimeout(function() {
                    location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    $('.error-text').text('');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        $('#message').html(
                            '<div class="alert alert-danger">Something went wrong.</div>');
                    }
                }
            });
        });
    </script>
@endsection

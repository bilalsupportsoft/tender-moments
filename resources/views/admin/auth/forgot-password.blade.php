@extends('admin.layouts.login_layout')
@section('content')

<div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
        <!-- Forgot Password -->
        <div class="card">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                    <a href="index.html" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img class="logo-dark" src="{{asset('assets/admin/img/logo.png')}}" width="120" alt="">
                        </span>
                    </a>
                </div>
                <!-- /Logo -->
                <h4 class="mb-2">Forgot Password? 🔒</h4>
                <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>

                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{route('admin.forget.password.post')}}" method="POST" class="mb-3">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">E-Mail Address</label>
                        <input class="form-control" id="email" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autofocus required="">
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-primary d-grid w-100">Send Password Reset Link</button>
                    </div>
                </form>
                <div class="text-center">
                    <a href="{{route('admin.login')}}" class="d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                        Back to login
                    </a>
                </div>
            </div>
        </div>
        <!-- /Forgot Password -->
    </div>
</div>


@endsection

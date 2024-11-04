<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="row vh-100">
    <div class="col-12">
        <div class="p-0">
            <div class="row d-flex align-items-center">
                <div class="col-md-6 col-xl-6 col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="mb-0 border-0">
                                <div class="p-0">
                                    <div class="text-center">
                                        <div class="mb-4">
                                            <!-- <a href="{{ url('/') }}" class="auth-logo">
                                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" class="mx-auto" height="28" />
                                            </a> -->
                                        </div>

                                        <div class="auth-title-section mb-3"> 
                                            <h3 class="text-dark fs-20 fw-medium mb-2">Admin Login</h3>
                                            <p class="text-dark text-capitalize fs-14 mb-0">Please enter your details.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-0">
                                    <!-- Display error and success messages -->
                                    @if ($errors->any() || session('message') || session('error'))
                                        <div class="mb-4">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            @if (session('message'))
                                                <div class="alert alert-success">
                                                    {{ session('message') }}
                                                </div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.login') }}" method="POST" class="my-4">
                                        @csrf <!-- CSRF token for form security -->
                                        <div class="form-group mb-3">
                                            <label for="emailaddress" class="form-label">Email address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="emailaddress" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                            
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Enter your password">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
<!--                             
                                        <div class="form-group d-flex mb-3">
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" name="remember" checked>
                                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                </div>
                                            </div>
                                        </div> -->
                                        
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-6 col-lg-6 p-0 vh-100 d-flex justify-content-center account-page-bg">
                    <!-- Optional background section -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

<!-- Apexcharts JS -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- For basic area chart (external link remains unchanged) -->
<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>

<!-- Widgets Init Js -->
<script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>

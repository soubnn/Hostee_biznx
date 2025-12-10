<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | Hostee the Planner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Inventory for Hostee the Planner" name="description" />
        <meta content="Hostee the Planner" name="author" />
        <!-- PWA  -->
        <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">


    </head>

    <body style="background-image: url('{{ asset("assets/images/bg_one.jpg") }}'); background-repeat: 'no-repeat';background-size: cover;">
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>biznx.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-2">
                                    <form method="post" action="{{ route('loginsubmit.total_ales') }}">
                                        @csrf
                                        <div class="mb-3 mt-4">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        <div class="mt-5 d-grid mb-3">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <div>
                                <p>© <script>document.write(new Date().getFullYear())</script> biznx. Developed by techsoul.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        {!! Toastr::message() !!}
        <script src="{{ asset('sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("sw.js").then(function (reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>

</html>

<!doctype html>
<html lang="en">
<head>
        
        <meta charset="utf-8" />
        <title>Maintenance Page | Biznx From Techsoul</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Inventory by Techsoul" name="description" />
        <meta content="Techsoul" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <!--<div class="home-btn d-none d-sm-block">-->
        <!--    <a href="{{ route('dashboard') }}" class="text-dark"><i class="fas fa-home h2"></i></a>-->
        <!--</div>-->

        <section class="my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="home-wrapper">
                            <div class="mb-5">
                                <a href="{{ route('dashboard') }}" class="d-block auth-logo">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="20" class="auth-logo-dark mx-auto">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="20" class="auth-logo-light mx-auto">
                                </a>
                            </div>
                            

                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <div class="maintenance-img">
                                        <img src="{{ asset('assets/images/maintenance.svg') }}" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                            <h3 class="mt-5">Site is Under Maintenance</h3>
                            <p>Please check back in sometime.</p>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mt-4 maintenance-box">
                                        <div class="card-body">
                                            <i class="bx bx-broadcast mb-4 h1 text-primary"></i>
                                            <h5 class="font-size-15 text-uppercase">Why is the Site Down?</h5>
                                            <p class="text-muted mb-0">We believe our system should be perfect. Perfect things needs regular updates to be better.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mt-4 maintenance-box">
                                        <div class="card-body">
                                            <i class="bx bx-time-five mb-4 h1 text-primary"></i>
                                            <h5 class="font-size-15 text-uppercase">
                                                What is the Downtime?</h5>
                                            <p class="text-muted mb-0">This page will be down for 24 hours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mt-4 maintenance-box">
                                        <div class="card-body">
                                            <i class="bx bx-envelope mb-4 h1 text-primary"></i>
                                            <h5 class="font-size-15 text-uppercase">
                                                Do you need Support?</h5>
                                            <p class="text-muted mb-0">Contact us on <a
                                                        href="mailto:techsoultechnologies@gmail.com"
                                                        class="text-decoration-underline">techsoultechnologies@gmail.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>

    </body>

</html>

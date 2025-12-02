<!doctype html>
<html lang="en">
@include('layouts.head')

    <body data-topbar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('layouts.header')

            @include('layouts.sidenav')


            @yield('content')

            <!--<div id="warningModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"-->
            <!--    aria-labelledby="myLargeModalLabel" aria-hidden="true">-->
            <!--    <div class="modal-dialog modal-lg">-->
            <!--        <div class="modal-content">-->
            <!--            <div class="modal-header">-->
            <!--                <h5 class="modal-title add-task-title">Maintenance Warning!</h5>-->
            <!--                <button type="button" class="btn-close" data-bs-dismiss="modal"-->
            <!--                    aria-label="Close"></button>-->
            <!--            </div>-->
            <!--            <div class="modal-body">-->
            <!--                <div class="row justify-content-center">-->
            <!--                    <div class="col-md-12">-->
            <!--                        <div class="maintenance-img">-->
            <!--                            <img src="{{ asset('assets/images/maintenance.svg') }}" alt="" class="img-fluid mx-auto d-block" height="200" width="200">-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <h3 class="mt-5 text-center">There will be a scheduled Server maintenance on <a class="text-danger" href="#">06-10-2022 05:30 AM - 01:00PM</a></h3>-->
            <!--                <p class="text-center">We are extremely sorry for the inconvenience caused. Please cooperate with us make wonderful things</p>-->
            <!--                <p class="text-center">Please complete the work you are doing in 5 minutes or else contact the developer at <a href="tel:+918848787656">+91 8848787656</a></p>-->
            <!--            </div>-->
            <!--        </div> -->
            <!--    </div>-->
            <!--</div>-->

            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.script')

</body>

</html>

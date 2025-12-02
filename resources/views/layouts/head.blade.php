<head>
    <meta charset="utf-8" />
    <title>Admin | Techsoul Cyber Solutions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Inventory for Techsoul Cyber Solutions" name="description" />
    <meta content="Techsoul" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
     <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- select2 css -->
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- dropzone css -->
    <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> --}}


    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}

    <style>
        .product-images{
            height:150px;
        }
        .jobcard-images{
            height:250px;
            width:250px;
        }
        .profile-images{
            height:150px;
            width:150px;
        }
        .upper-case{
            text-transform: uppercase;
        }

    </style>
    <style type="text/css" media="print">
        @media print
        {
           @page {
             margin-top: 0;
             margin-bottom: 0;
           }
           body  {
             padding-top: 72px;
             padding-bottom: 72px ;
           }
        }
    </style>
    <!--<script>-->
    <!--    $(function() {-->
    <!--            $('input').keyup(function() {-->
    <!--                this.value = this.value.toLocaleUpperCase();-->
    <!--            });-->
    <!--            $('textarea').keyup(function() {-->
    <!--                this.value = this.value.toLocaleUpperCase();-->
    <!--            });-->
    <!--    });-->
    <!--</script>-->
</head>

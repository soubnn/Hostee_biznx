@extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
    });
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Vehicles</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Vehicles</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Vehicle Number</th>
                                                <th>Vehicle Name</th>
                                                <th>RC Owner</th>
                                                <th>RC Validity</th>
                                                <th>Insurance Validity</th>
                                                <th>View</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($vehicle as $vehicle)
                                                <tr>
                                                    <td>{{ $vehicle->vehicle_number }}</td>
                                                    <td>{{ $vehicle->vehicle_name }}</td>
                                                    <td>{{ $vehicle->rc_owner }}</td>
                                                    <td>{{ $vehicle->reg_validity }}</td>
                                                    <td>{{ $vehicle->insurance_validity }}</td>
                                                    <td><a href="{{ route( 'vehicle.show',$vehicle->id ) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->





@endsection

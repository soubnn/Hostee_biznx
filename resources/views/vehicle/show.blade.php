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
                                    <h4 class="mb-sm-0 font-size-18">Vehicle Details</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">

                                                <tbody>

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Vehicle Number</th>
                                                    <td colspan="6">{{ $vehicle->vehicle_number }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#vnumber_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="vnumber_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Vehicle Number</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_number',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Vehicle Model</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="vehicle_number" value="{{ $vehicle->vehicle_number }}" placeholder="Enter Vehicle Number">
                                                                        @error('vehicle_number')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Vehicle Name</th>
                                                    <td colspan="6">{{ $vehicle->vehicle_name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#vname_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="vname_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Vehicle Name</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_name',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Vehicle Name</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="vehicle_name" value="{{ $vehicle->vehicle_name }}" placeholder="Enter Vehicle Name">
                                                                        @error('vehicle_name')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Vehicle Model</th>
                                                    <td colspan="6">{{ $vehicle->vehicle_model }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#vmodel_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="vmodel_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Vehicle Model</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_model',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Vehicle Model</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="vehicle_model" value="{{ $vehicle->vehicle_model }}" placeholder="Enter Vehicle Model">
                                                                        @error('vehicle_model')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Engine Number</th>
                                                    <td colspan="6">{{ $vehicle->engine_number }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#engine_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="engine_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Engine No</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_engine_number',$vehicle->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Customer Phone</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="engine_number" value="{{ $vehicle->engine_number }}" placeholder="Enter Engine No">
                                                                        @error('engine_number')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Chasis Number</th>
                                                    <td colspan="6">{{ $vehicle->chasis_number }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#chasis_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="chasis_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Chasis Number</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_chasis_number',$vehicle->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Chasis Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="chasis_number" value="{{ $vehicle->chasis_number }}" placeholder="Enter Chasis Number">
                                                                        @error('chasis_number')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}


                                                <tr>
                                                    <th class="text-nowrap" scope="row">RC Owner</th>
                                                    <td colspan="6"> {{ $vehicle->rc_owner }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#rcowner_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="rcowner_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit RC Owner</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_rc_owner',$vehicle->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Vehicle Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="rc_owner" value="{{ $vehicle->rc_owner }}" placeholder="Enter RC Owner">
                                                                        @error('rc_owner')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">RC Validity</th>
                                                    <td colspan="6">{{ $vehicle->reg_validity }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#rcval_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="rcval_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit RC Validity</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_reg_validity',$vehicle->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">RC Validity</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="date" class="form-control" name="reg_validity" value="{{ $vehicle->reg_validity }}" placeholder="Enter RC Validity">
                                                                        @error('reg_validity')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Insurance Number</th>
                                                    <td colspan="6">{{ $vehicle->insurance_number }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#ins_number_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="ins_number_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Insurance Number</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_insurance_number',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Insurance Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="insurance_number" value="{{ $vehicle->insurance_number }}" placeholder="Enter Insurance Number">
                                                                        @error('insurance_number')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Insurance Validity</th>
                                                    <td colspan="6">{{ $vehicle->insurance_validity }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#ins_val_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="ins_val_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Insurance Validity</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_insurance_validity',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Insurance Validity</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="date" class="form-control" name="insurance_validity" value="{{ $vehicle->insurance_validity }}" >
                                                                        @error('insurance_validity')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Pollution Validity</th>
                                                    <td colspan="6">{{ $vehicle->pollution_validity }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#pollution_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="pollution_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Pollution Validity</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_pollution_validity',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Pollution Validity</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="date" class="form-control" name="pollution_validity" value="{{ $vehicle->pollution_validity }}" >
                                                                        @error('pollution_validity')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Permit Validity</th>
                                                    <td colspan="6">{{ $vehicle->permit_validity }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#permit_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="permit_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Permit Validity</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_permit_validity',$vehicle->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Permit Validity</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="date" class="form-control" name="permit_validity" value="{{ $vehicle->permit_validity }}" >
                                                                        @error('permit_validity')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">RC Document</th>
                                                    @if ($vehicle->rc_doc == Null)
                                                        <td colspan="6">No document available</td>
                                                    @else
                                                        <td colspan="6"><a href="{{ asset('storage/vehicle/'.$vehicle->rc_doc) }}" target="_blank">RC_{{ $vehicle->vehicle_number }}</a></td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#rcdoc_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="rcdoc_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit RC Document</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_rcdoc',$vehicle->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">RC Document</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control mt-4" name="rc_doc" type="file">
                                                                        @error('rc_doc')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Insurance Document</th>
                                                    @if ($vehicle->insurance_doc == Null)
                                                        <td colspan="6">No document available</td>
                                                    @else
                                                        <td colspan="6"><a href="{{ asset('storage/vehicle/'.$vehicle->insurance_doc) }}" target="_blank">INSURANCE_{{ $vehicle->vehicle_number }}</a></td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#ins_doc_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                    {{-- modal start --}}

                                                    <div id="ins_doc_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Insurance Document</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                <form method="POST" action="{{ route('vehicle_edit_insurancedoc',$vehicle->id) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label" style="float:left;">Insurance Document</label>
                                                                        <div class="col-lg-12">
                                                                            <input class="form-control mt-4" name="insurance_doc" type="file">
                                                                            @error('insurance_doc')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                    {{-- modal end --}}
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Pollution Documnet</th>
                                                    @if ($vehicle->pollution_doc == Null)
                                                        <td colspan="6">No document available</td>
                                                    @else
                                                        <td colspan="6"><a href="{{ asset('storage/vehicle/'.$vehicle->pollution_doc) }}" target="_blank">POLLUTION_{{ $vehicle->vehicle_number }}</a></td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#pollution_doc_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="pollution_doc_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Insurance Document</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('vehicle_edit_pollutiondoc',$vehicle->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Insurance Document</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control mt-4" name="pollution_doc" type="file">
                                                                        @error('pollution_doc')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Permit Document</th>
                                                    @if ($vehicle->permit_doc == Null)
                                                        <td colspan="6">No document available</td>
                                                    @else
                                                        <td colspan="6"><a href="{{ asset('storage/vehicle/'.$vehicle->permit_doc) }}" target="_blank">PERMIT_{{ $vehicle->vehicle_number }}</a></td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#permit_doc_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                    {{-- modal start --}}

                                                    <div id="permit_doc_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Insurance Document</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                <form method="POST" action="{{ route('vehicle_edit_permitdoc',$vehicle->id) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label" style="float:left;">Insurance Document</label>
                                                                        <div class="col-lg-12">
                                                                            <input class="form-control mt-4" name="permit_doc" type="file">
                                                                            @error('permit_doc')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                    {{-- modal end --}}
                                                </tr>




                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="button-items mt-4" style="float:right;">

                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->


                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection

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
<script>
$(document).ready(function(){
    $("#datatable").dataTable({
        "pageLength" : 100
    });
});
function whatsappEstimate(estimateId) {
    var website = document.getElementById("hiddenURL_" + estimateId).value;
    window.open(website, '_blank');
    document.getElementById("downloadEstimateForm_" + estimateId).submit();
}
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Estimate</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Estimates</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Est No</th>
                                                    <th>Type</th>
                                                    <th>Customer</th>
                                                    <th>Phone</th>
                                                    <th>Added On</th>
                                                    <th>Expire On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                @foreach ($estimates as $estimate)
                                                    <tr>
                                                        <td data-sort="">#EST{{ $estimate->id }}</td>
                                                        <td>{{ $estimate->estimate_type }}</td>
                                                        @php
                                                            $name_length = strlen($estimate->customer_name);
                                                        @endphp
                                                        @if ($name_length > 30 && $name_length <= 60)
                                                            @php
                                                                $customer_name1 = substr($estimate->customer_name,0,30);
                                                                $customer_name2 = substr($estimate->customer_name,30);
                                                            @endphp
                                                                <td>{{ $customer_name1 }}<br>{{ $customer_name2 }}</td>
                                                        @elseif($name_length > 60)
                                                            @php
                                                                $customer_name1 = substr($estimate->customer_name,0,30);
                                                                $customer_name2 = substr($estimate->customer_name,30,30);
                                                                $customer_name3 = substr($estimate->customer_name,60);
                                                            @endphp
                                                                <td>{{ $customer_name1 }}<br>{{ $customer_name2 }}<br>{{ $customer_name3 }}</td>
                                                        @else
                                                            <td>{{ $estimate->customer_name }}</td>
                                                        @endif
                                                        <td>{{ $estimate->customer_phone }}</td>
                                                        <td>{{  Carbon\carbon::parse($estimate->estimate_date)->format('d M Y') }}</td>
                                                        <td>{{  Carbon\carbon::parse($estimate->valid_upto)->format('d M Y') }}</td>
                                                        <td>
                                                            @if($estimate->status == 'active')
                                                                <button type="button" class="btn btn-light text-danger" data-bs-toggle="modal" data-bs-target="#disable_estimate_modal{{$estimate->id}}">
                                                                    <i class="mdi mdi-trash-can"></i>
                                                                </button>
                                                            @elseif( $estimate->status == 'disabled' )
                                                                <button type="button" class="btn btn-light text-success" data-bs-toggle="modal" data-bs-target="#enable_estimate_modal{{$estimate->id}}">
                                                                    <i class="mdi mdi-check"></i>
                                                                </button>
                                                            @endif
                                                            <a href="{{ route('estimate.edit',$estimate->id) }}">
                                                                <button class="btn btn-light text-primary">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </button>
                                                            </a>
                                                            <a href="{{ route('estimate.show',$estimate->id) }}">
                                                                <button class="btn btn-light text-primary">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </button>
                                                            </a>
                                                            <a href="!#" onclick="whatsappEstimate({{ $estimate->id }})" target="_blank">
                                                                <button class="btn btn-light text-primary">
                                                                    <i class="mdi mdi-whatsapp"></i>
                                                                </button>
                                                            </a>
                                                            <a href="{{ route('generate_estimate',$estimate->id ) }}" class="btn btn-light text-primary" target="_blank">
                                                                <i class="mdi mdi-printer"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        @foreach ($estimates as $estimate)
                            @include('estimate.modals.enable-modal')
                            @include('estimate.modals.disable-modal')
                            <input type="hidden" id="hiddenURL_{{ $estimate->id }}" value="{{ $estimate->url }}">
                            <form action="{{ route('WhatsappEstimate', $estimate->id) }}" id="downloadEstimateForm_{{ $estimate->id }}">
                            </form>
                        @endforeach
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection

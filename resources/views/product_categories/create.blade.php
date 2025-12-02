@extends('layouts.layout')
@section('content')
<script>
$(document).ready(function(){
    $("#datatable").dataTable({
        "pageLength" : 100
    });
});
</script>
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
                                    <h4 class="mb-sm-0 font-size-18">View Categories</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <button class="btn btn-primary" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#newCategoryModal">New Category</button>
                                        <br>
                                        @error('category_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <br><br><br>

                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100 mt-5" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Edit</th>

                                            </tr>
                                            </thead>


                                            <tbody>
                                                @php
                                                    $categories = DB::table('product_categories')->get();
                                                @endphp
                                             @foreach($categories as $category)


                                            <tr>
                                                <td>{{ $category->category_name }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect text-info" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#stModal{{$category->id}}">
                                                        Edit
                                                    </button>
                                                </td>
                                                {{-- <td>
                                                    <form action="{{ route('product_category.destroy', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" class="btn btn-danger waves-effect">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td> --}}
                                                <!-- Modal -->
                                                <div id="stModal{{$category->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title">Edit Category</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="NewtaskForm" method="POST" action="{{ route('product_category.update',$category->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-group mb-3">
                                                                        <label for="taskname" class="col-form-label">Category</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="taskname" name="category_name" type="text" class="form-control validate" placeholder="" Value="{{$category->category_name}}">
                                                                            @error('category_name')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Update Details</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                        <!-- new category modal -->
                                        <div id="newCategoryModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title add-task-title">New Category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="NewtaskForm" method="POST" action="{{ route('product_category.store') }}">
                                                            @csrf
                                                            <div class="form-group mb-3">
                                                                <label for="taskname" class="col-form-label">Category</label>
                                                                <div class="col-lg-12">
                                                                    <input id="taskname" name="category_name" type="text" class="form-control validate" placeholder="" Value="{{ old('category_name') }}">
                                                                    @error('category_name')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-end">
                                                                    <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Update Details</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->




            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



@endsection

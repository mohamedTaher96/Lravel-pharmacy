@extends('admin/layout/adminLayout')
@section('style')
    <style>
        .form-control
        {
            padding: 0px 12px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
            <h1>
            Add Company 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title">new company   </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="add" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Company Name </label>
                            <input type="text" class="form-control" name="company" required >                 
                        </div>
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary">add</button>
                      </div>
                    </form>
                  </div>
    </section>        
    @section('script')
        <script>
        </script>
    @endsection
@endsection
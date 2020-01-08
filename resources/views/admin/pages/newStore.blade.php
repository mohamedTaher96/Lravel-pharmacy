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
            Add Store 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title"> New Store  </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="new/add" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">  Store Name</label>
                            <input type="text" class="form-control" name="store" >                 
                        </div>
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary">Add</button>
                      </div>
                    </form>
                  </div>
    </section>        
    @section('script')
        <script>
        </script>
    @endsection
@endsection
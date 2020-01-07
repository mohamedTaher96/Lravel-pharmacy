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
            Modify The Category
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title">Category Information    </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="update" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Category Name </label>
                            <input type="text" class="form-control" name="name" required value="{{$makeup->name}}" >    
                            <label for="exampleInputEmail1"> Price </label>
                            <input type="number" step="0.01" class="form-control" name="cost" required value="{{$makeup->cost}}">       
                            <label for="exampleInputEmail1">  Makeup Photo </label>
                            <input type="file" class="form-control" name="file" required>       
                            <input type="hidden" name="id" value="{{$makeup->id}}">
                        </div>
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary">Edit</button>
                      </div>
                    </form>
                  </div>
    </section>        
    @section('script')
        <script>
        </script>
    @endsection
@endsection







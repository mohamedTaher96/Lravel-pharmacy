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
@if (session('exist'))
    <div class='alert alert-warning'><strong></strong> This category is exist  </div>
@endif
    <section class="content-header">
            <h1>
            Add Category 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title"> New Category  </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="new/add" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">  Trade Name</label>
                            <input type="text" class="form-control" name="name" required >  
                            <label for="exampleInputEmail1">  Scientific Name</label>
                            <input type="text" class="form-control" name="material" required >  
                            <label for="exampleInputEmail1"> Stripe </label>
                            <input type="number" class="form-control" name="stripe" required >    
                            <label for="exampleInputEmail1"> Price </label>
                            <input type="number" step="0.01" class="form-control" name="cost" required >  
                            <label for="exampleInputEmail1">  Medicine Photo </label>
                            <input type="file" class="form-control" name="file" required>                   
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
                  if($(".alert"))
        {
            window.setTimeout(function() {
                    $(".alert").fadeTo(5000, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 1000);
        }
        </script>
    @endsection
@endsection







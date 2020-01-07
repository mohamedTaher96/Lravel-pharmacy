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
@if (session('error'))
    <div class='alert alert-danger'><strong></strong> The file must be an image  </div>
@endif
    <section class="content-header">
            <h1>
            Add Bill 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title">new Store Bill   </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="add" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Date </label>
                            <input type="date" class="form-control" name="date" required >             
                            <label for="exampleInputEmail1"> Total </label>
                            <input type="number" step="0.01" min="0" class="form-control" name="total" required >                       
                            <label for="exampleInputEmail1"> Bill Photo </label>
                            <input type="file" class="form-control" name="file" required>  
                            <input type="hidden" value="{{$id}}" name='source_id' >
                               
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
            if($(".alert"))
            {
                window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                        });
                    }, 1000);
            }
        </script>
    @endsection
@endsection
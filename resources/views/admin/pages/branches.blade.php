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
@if (session('add'))
    <div class='alert alert-success'><strong></strong> The Branch has been successfully added. </div>
@endif
    <section class="content-header">
            <h1>
            branches Section 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                <div class="box">
                    <div class="form-group">
                        <br>
                        <label for="exampleFormControlSelect1">Branches </label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            @foreach ($branches as $branche)
                                <option>{{$branche->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="box-header with-border">
                      <h2 class="box-title">New Branche   </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="branches/add" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Branche Name </label>
                            <input type="text" class="form-control" name="name" required >                 
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
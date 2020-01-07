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
@if (session('addCompnay'))
    <div class='alert alert-warning'><strong></strong> Missing data<br>  Add a source first </div>
@endif
@if (session('changecode'))
    <div class='alert alert-warning'><strong></strong> This code hase been used<br> Change the code  </div>
@endif
    <section class="content-header">
            <h1>
            Add Packet 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title"> New Packet  </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="add" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">  Packet Code</label>
                            <input type="text" class="form-control" name="code" required >  
                            <label for="exampleInputEmail1">  Packet Source</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="source_id">
                              @foreach ($sources as $source)
                                <option value="{{$source->id}}">{{$source->name}}</option>
                              @endforeach  
                            </select> 
                            <label for="exampleInputEmail1">  Discount %</label>
                            <input type="number" step="0.01" min="1" max="100" class="form-control" name="precentage" required > 
                            <label for="exampleInputEmail1">  Expired Date</label>
                            <input type="date"  class="form-control" name="expired" required >     
                            <input type="hidden" name="id" value="{{$id}}"  >            
                        </div>
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary">Add</button>
                      </div>
                    </form>
                  </div>
    </section>        
    @section('script')
    <!-- DataTables -->
    <script src="{{asset('js/admin/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/admin/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $("#example1").DataTable();
        if($(".alert"))
        {
            window.setTimeout(function() {
                    $(".alert").fadeTo(3500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 1000);
        }
    </script>
@endsection
@endsection







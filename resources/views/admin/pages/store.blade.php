@extends('admin/layout/adminLayout')
@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('css/admin/dataTables.bootstrap.css')}}">
    <style>
        td
        {
            word-break: break-word;
        }
        .form-control
        {
            padding: 0px 12px;
        }
        img
        {
            width: 50px;
            height: 50px;
        }
    </style>
@endsection
@section('content')
@if (session('add'))
    <div class='alert alert-success'><strong></strong> The store has been successfully added. </div>
@endif
@if (session('delete'))
    <div class='alert alert-success'><strong></strong>  The store has been successfully deleted. </div>
@endif
@if (session('edit'))
    <div class='alert alert-success'><strong></strong> The store has been successfully edited. </div>
@endif
<section class="content-header">
        <h1>
          Stores Section 
        <small> </small>
        </h1>
        <br>
</section>
<section class="">
        <div class="box">
                <div class="box-header">
                  <a href="http://localhost:8000/admin/store/new/" role="button" class="btn btn-primary" > Add Store</a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th> company Name </th>
                        <th>   medicines</th>
                        <th> mackup</th>
                        <th> bills</th>
                        <th>edit/delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td> {{$store->name}}</td>
                                <td><a href="http://localhost:8000/admin/store/medicine?id={{$store->id}}"  class="btn btn-primary" role="button">Medicines</a></td>
                                <td><a href="http://localhost:8000/admin/store/makeup?id={{$store->id}}"  class="btn btn-primary" role="button">Mackup</a></td>
                                <td><a href="http://localhost:8000/admin/store/bills?id={{$store->id}}" class="btn btn-primary" role="button">Bills</a></td>
    
                                <td>
                                    <a href="http://localhost:8000/admin/store/edit?id={{$store->id}}" class="btn btn-primary" role="button">Edit</a>
                                    <a href="http://localhost:8000/admin/store/delete?id={{$store->id}}" class="btn btn-primary" role="button" onclick="return confirm(  ' All related to the packet will be deleted \n are you sure you want to delete the packet ?   '  );">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                                <th> company Name </th>
                                <th>   medicines</th>
                                <th> mackup</th>
                                <th> bills</th>
                                <th>edit/delete</th>
                        </tr>
                    </tfoot>
                  </table>
                </div>
        </div>
</section>

@endsection
@section('script')
        <!-- DataTables -->
        <script src="{{asset('js/admin/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/admin/dataTables.bootstrap.min.js')}}"></script>
        <script>
            $("#example1").DataTable();
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
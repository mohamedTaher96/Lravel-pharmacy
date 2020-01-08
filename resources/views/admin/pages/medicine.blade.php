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
    <div class='alert alert-success'><strong></strong> The category has been successfully added. </div>
@endif
@if (session('delete'))
    <div class='alert alert-success'><strong></strong>  The category has been successfully deleted. </div>
@endif
@if (session('edit'))
    <div class='alert alert-success'><strong></strong> The category has been successfully edited. </div>
@endif
<section class="content-header">
        <h1>
            Medicine Section
        <small> </small>
        </h1>
        <br>
</section>
<section class="content">
        <div class="box">
                <div class="box-header">
                  <a href=" /admin/medicine/new/" role="button" class="btn btn-primary" > Add Category</a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                            <th> trade name  </th>
                            <th> scientific name  </th>
                            <th> packets number  </th>
                            <th>  stripe</th>
                            <th>  price</th>
                            <th>edit/delete </th>
                      </tr>
                    </thead>
                    <tbody>
                        {!!$html!!}
                    </tbody>
                    <tfoot>
                        <tr>
                                <th> trade name  </th>
                                <th> scientific name  </th>
                                <th> packets number  </th>
                                <th>  stripe</th>
                                <th>  price</th>
                                <th>edit/delete </th>
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
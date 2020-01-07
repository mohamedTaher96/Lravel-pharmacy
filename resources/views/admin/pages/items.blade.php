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
        .item
        {
          font-weight: bold;
          font-size: 2rem;
          color: blue;
        }
    </style>
@endsection
@section('content')
@if (session('add'))
    <div class='alert alert-success'><strong></strong> The packet has been successfully added. </div>
@endif
@if (session('delete'))
    <div class='alert alert-success'><strong></strong>  The packet has been successfully deleted. </div>
@endif
@if (session('edit'))
    <div class='alert alert-success'><strong></strong> The packet has been successfully edited. </div>
@endif
<section class="content-header">
        <h1>
         Category Packets 
        <small> </small>
        </h1>
        <br>
</section>
<section class="content">
        <div class="box">
                <div class="box-header">
                  <h3 class="box-title">  Category : </h3><span class="item"> {{$medicine->name}}</span> <br><br>
                  <a href="http://localhost:8000/admin/medicine/item/new?id={{$id}}" role="button" class="btn btn-primary" >Add Packet </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>source</th>
                          <th>  code</th>
                          <th> Discount %</th>
                          <th>   expire date</th>
                          <th> edit/delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        {!!$html!!}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>source</th>
                            <th>  code</th>
                            <th> Discount %</th>
                            <th>   expire date</th>
                            <th> edit/delete</th>
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
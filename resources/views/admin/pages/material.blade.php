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
        .material
        {
          font-weight: bold;
          font-size: 2.5rem;
          color: blue;
        }

    </style>
@endsection
@section('content')
<section class="content-header">
        <h1>
            Alternatives Section    
        <small> </small>
        </h1>
        <br>
</section>
<section class="content">
        <div class="box">
                <div class="box-header">
                  <h2 class="box-title"><span class="material"> {{$material}} </span> :  Effective Material     </h2>
                  
                  <hr>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table  class="table table-bordered table-striped">
                    <th>category name </th>
                    <th>packets number </th>
                    <th>price </th>
                        {!!$html!!}
                  </table>
                </div>
        </div>
</section>

@endsection

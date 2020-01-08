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
    <div class='alert alert-success'><strong></strong> The company has been successfully added. </div>
@endif
@if (session('delete'))
    <div class='alert alert-success'><strong></strong>  The company has been successfully deleted. </div>
@endif
@if (session('edit'))
    <div class='alert alert-success'><strong></strong> The company has been successfully edited. </div>
@endif
<section class="content-header">
        <h1>
           Company Section
        <small> </small>
        </h1>
        <br>
</section>
<section class="content">
        <div class="box">
                <div class="box-header">
                  <a href=" /admin/company/new/" role="button" class="btn btn-primary" >Add Company </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped ">
                    <thead>
                      <tr>
                        <th>  company name</th>
                        <th>  medicines </th>
                        <th> makeup</th>
                        <th> bills</th>
                        <th> edit/delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr>
                                <td> {{$company->name}}</td>
                                <td><a href=" /admin/company/medicine?id={{$company->id}}"  class="btn btn-primary" role="button">medicines</a></td>
                                <td><a href=" /admin/company/makeup?id={{$company->id}}"  class="btn btn-primary" role="button">makeup</a></td>
                                <td><a href=" /admin/company/bills?id={{$company->id}}" class="btn btn-primary" role="button">bills</a></td>
    
                                <td>
                                    <a href=" /admin/company/edit?id={{$company->id}}" class="btn btn-primary" role="button">edit</a>
                                    <a href=" /admin/company/delete?id={{$company->id}}" class="btn btn-primary" role="button" onclick="return confirm(  ' All related to the company will be deleted \n are you sure you want to delete the company ?   '  );">delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                                <th>  company name</th>
                                <th>  medicines </th>
                                <th> makeup</th>
                                <th> bills</th>
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
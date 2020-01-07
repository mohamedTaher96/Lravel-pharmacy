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
            width: 100%;
            height: 175px;
            margin-top: 2px;
        }
        .item
        {
          font-weight: bold;
          font-size: 2rem;
          color: blue;
        }
        h5
        {
            color: blue;
        }
        .box-body
        {
            /* display:-webkit-inline-box; */
        }
        .card
        {
            text-align: center;
            border: 1px solid #ccc;
            background-color: #eeee;
            margin: 3%;
            padding-top: 1px;
        }
    </style>
@endsection
@section('content')
@if (session('add'))
    <div class='alert alert-success'><strong></strong> The Bill has been successfully added. </div>
@endif
@if (session('delete'))
    <div class='alert alert-success'><strong></strong>  The company has been successfully deleted. </div>
@endif
@if (session('edit'))
    <div class='alert alert-success'><strong></strong> The company has been successfully edited. </div>
@endif
<section class="content-header">
        <h1>
           Stores Bills Section
        <small> </small>
        </h1>
        <br>
</section>
<section class="content">
        <div class="box">
                <div class="box-header">
                    <h3 class="box-title">  Store : </h3><span class="item"> {{$source->name}}</span><br><br>
                    <a href="http://localhost:8000/admin/store/bill/new?id={{$source->id}}" role="button" class="btn btn-primary" >Add Bill </a>
                </div><!-- /.box-header -->
                <div class="box-body">
                        <input type="month" name="date" id="month">
                        <input type="button" class="btn btn-primary" value="Show Bills" id="show">
                        <input type="button" class="btn btn-primary" value="Show All Bills" id="showAll">
                        <input type="hidden" id="id" value="{{$source->id}}">
                </div>
        </div>
        <div class="box">
                <div class="box-header">
                        <h3 class="box-title">  Bills : </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body row" id="html">

                    </div>
        </div>
</section>

@endsection
@section('script')
        <!-- DataTables -->
        <script src="{{asset('js/admin/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/admin/dataTables.bootstrap.min.js')}}"></script>
        <script>
            $("#show").click(function(){
                var month = $("#month").val();
                var id = $("#id").val();
                $.ajax({
                    url:'bills/show',
                    type:'get',
                    data:{id:id,month:month},
                    success:function(data)
                    {
                        $("#html").html(data);
                    }
                })
            })
            $("#showAll").click(function(){
                var id = $("#id").val();
                $.ajax({
                    url:'bills/showAll',
                    type:'get',
                    data:{id:id},
                    success:function(data)
                    {
                        $("#html").html(data);
                    }
                })
            })

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
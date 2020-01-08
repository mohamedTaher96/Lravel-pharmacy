@extends('admin/layout/adminLayout')
@section('style')
    
@endsection
@section('content')
        @if (session('access'))
            <div class='alert alert-danger'><strong></strong>     Access Denied </div>
        @endif
        <section class="content-header">
                <h1>
                Home
                <small> </small>
                </h1>
        </section>

      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-sm-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <p>  Companies </p>
                <hr>
                <p> No : {{$companies}} </p>
                <div class="container">
                    <h6>
                        
                    </h6>
                </div>
              </div>
              <div class="icon">
                <i class="   "></i>
              </div>
              <a href=" /admin/company/" class="small-box-footer"> Edit <i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-sm-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <p>  Stores </p>
                  <hr>
                  <p> No : {{$stores}} </p>
                  <div class="container">
                      <h6>
                          
                      </h6>
                  </div>
                </div>
                <div class="icon">
                  <i class="   "></i>
                </div>
                <a href=" /admin/store/" class="small-box-footer"> Edit <i class="fa fa-arrow-circle-left"></i></a>
              </div>
            </div><!-- ./col -->

          <div class="col-lg-3 col-sm-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <p>  Drugs </p>
                  <hr>
                  <p> No : {{$medicines}} </p>
                  <div class="container">
                      <h6>
                          
                          
                      </h6>
                  </div>
  
                </div>
                <div class="icon">
                  <i class=""></i>
                </div>
                <a href=" /admin/medicine/" class="small-box-footer"> Edit <i class="fa fa-arrow-circle-left"></i></a>
              </div>
            </div><!-- ./col -->

              <div class="col-lg-3 col-sm-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3></h3>
                      <p>  Cosmetics</p>
                      <hr>
                      <p> No : {{$makeups}} </p>
                    </div>
                    <div class="icon">
                      <i class=""></i>
                    </div>
                    <a href=" /admin/makeup/" class="small-box-footer"> Edit <i class="fa fa-arrow-circle-left"></i></a>
                  </div>
                </div><!-- ./col -->
        </div><!-- /.row -->
    </section>
@endsection
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
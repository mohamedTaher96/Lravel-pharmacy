<!DOCTYPE html>
<html>
  <head>
    <title>Login </title>
    <link rel="icon" type="image/png" href="{{asset('images/cashier/logo.jpg')}}">
    <meta charset="UTF-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{asset('css/admin/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/admin/fonts-fa.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/admin/AdminLTE.min.css')}}">
  </head>
  <body class="login-page">
    @if (session('errorEmail'))
        <div class='alert alert-danger'>access denied not exist email</div>
    @endif
    @if (session('errorPass'))
    <div class='alert alert-danger'>access denied not correct password</div>
@endif
@if (session('access'))
<div class='alert alert-danger'>access denied</div>
@endif
    <div class="login-box">
      <div class="login-logo">
        <a href=""><b>Pharmacy</b>Admin</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="check" method="get">
          <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="pass" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group">
              <label for="exampleFormControlSelect1">Branchs</label>
              <select class="form-control" name="branch" id="exampleFormControlSelect1">
                @foreach ($branchs as $branch)
                  <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach  
              </select>
            </div>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
        </form>



      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/admin/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.4 -->
    <script src="{{asset('js/admin/bootstrap.min.js')}}"></script>
    <!-- iCheck -->
    <script>
      if($(".alert"))
            {
                window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                        });
                    },2000);
            }
    </script>
  </body>
</html>

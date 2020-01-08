<html>
  <head>
    <title>Cashier </title>
    <link rel="icon" type="image/png" href="{{asset('images/cashier/logo.jpg')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/admin/bootstrap.min.css')}}">
    <link href={{asset("css/cashier/main.css")}} rel="stylesheet" />
    <link href={{asset("css/cashier/edit.css")}} rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        img{
          width: 50px;
          height: 50px;
        }
      </style>
  </head>
  <body  >
      @if (session('success'))
        <div class='alert alert-success done'><strong></strong>  Done </div>
      @endif
      @if (session('fail'))
      <div class='alert alert-danger done'><strong></strong>  No retrieve had benn added </div>
      @endif
      <div class='alert alert-danger noData '><strong></strong> No found Data. </div>
      <div class='alert alert-danger repeat '><strong></strong>  Data has been added. </div>

    <div class="s132">
            <header class="header-basic-light">

                    <div class="header-limiter">
                
                        <h1><a href="#">Shefaa<span>Pharmacy<img alt='image not found' src="../../../../images/cashier/logo.jpg"></span></a></h1>
                
                        <nav>
                            <a href=" /" >search</a>
                            <a href=" /buy"  >Buy</a>
                            <a href=" /retrieve" class="selected" >Retrieve</a>
                            <a href=" /cashier/logout" >Logout</a>
                        </nav>
                    </div>
                
            </header>
                  <!--Main Navigation-->
                  <section class="center upper_body">
                        <form>
                                <div class="inner-form">
                                  <div class="input-field second-wrap">
                                    <input id="code" autocomplete="off" type="text" name="code" placeholder="Enter Code" />
                                  </div>
                                  <div class="input-field third-wrap">
                                    <button id="add" class="btn-search result_btn" type="button">Retrieve</button>
                                  </div>
                                </div>
                              </form>
                </section>
                <section id="bill" class="retrieve">
                    
                      <form action="retrieve/data" enctype="multipart/form-data">
                        <div class="table-responsive" id="scroll">
                          <table class="table">
                              <thead>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Stripe No</th>
                                <th>Packet/price</th>
                                <th>Cancle</th>
                              </thead>
                              <tbody id="body">
      
                              </tbody>
                            </table>
                          </div>
                          <input type="submit" id="done" class="btn btn-primary" value="done">
                        </form>   
                </section>
                    <!-- Footer -->
            <footer class="page-footer font-small white">

                <!-- Copyright -->
                <div class="footer-copyright text-center py-3">© 2019 Copyright:
                  <a href=> M_Taher</a>
                </div>
                <!-- Copyright -->
              
            </footer>
              <!-- Footer -->
        
    </div>
    <script>
        var allCode = [""];
        var test;
        var flag;
        var i;
        $("#add").click(function(){  
            flag=false;
            code = $("#code").val();
            for(i=0;i<allCode.length;i++)
            {
              
              if(code==allCode[i])
              {
                flag=true;
                $(".repeat").show();
                $(".repeat").fadeOut(2000);
              }
            }
            if(flag==false)
            {
              allCode.push(code);
                $.ajax({
                url:'retrieve/add',
                type:'get',
                data:{code:code},
                success:function(data)
                {
                  if(data=="noData")
                  {
                    $(".noData").show();
                    $(".noData").fadeOut(2000);
                  }else
                  {
                    $("#bill").show();
                    $("#body").append(data);
                  }
                }
            }) 
            }
          
            if($("#scroll").height()>350)
            {
              $("#scroll").css('max-height','420px');
              $("#scroll").css('overflow','auto');
            }
        })
        $(".table").on('click','.cancle',function(){
            var deleteCode =$(this).parent().parent().children().eq(0).children().eq(0).val();
            $(this).parent().parent().remove();
            Array.prototype.remove = function() {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
            }
        return this;
        };
        allCode.remove(deleteCode);

          
        })
        if($(".done"))
            {
                window.setTimeout(function() {
                        $(".done").fadeTo(1000, 0).slideUp(500, function(){
                            $(this).remove(); 
                        });
                    }, 1000);
            }
    </script>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

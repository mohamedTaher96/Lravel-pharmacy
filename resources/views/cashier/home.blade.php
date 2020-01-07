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
  <body >
        <div class='alert alert-danger noType '><strong></strong> Select a type. </div>
        <div class='alert alert-danger noData '><strong></strong> No found Data. </div>

    <div class="s132">
            <header class="header-basic-light">

                    <div class="header-limiter">
                
                        <h1><a href="#">shefaa<span>Pharmacy<img alt='image not found' src="../../../../images/cashier/logo.jpg"></span></a></h1>
                
                        <nav>
                            <a href="http://https://pharmacy-20.herokuapp.com/" class="selected" >search</a>
                            <a href="http://https://pharmacy-20.herokuapp.com/buy"  >Buy</a>
                            <a href="http://https://pharmacy-20.herokuapp.com/retrieve" >Retrieve</a>
                            <a href="http://https://pharmacy-20.herokuapp.com/cashier/logout" >Logout</a>
                        </nav>
                    </div>
                
                </header>
                  <!--Main Navigation-->
        <section class="center upper_body">
                <form>
                        <div class="inner-form">
                          <div class="input-field first-wrap">
                            <div class="input-field">
                              <select data-trigger="" id="type" name="type">
                                <option placeholder="" value="0">Type</option>
                                <option value="2">Mackup</option>
                                <option value="1">Medicine</option>
                                
                              </select>
                            </div>
                          </div>
                          <div class="input-field second-wrap">
                            <input id="search" autocomplete="off" type="text" name="key" placeholder="Enter Keywords" />
                          </div>
                          <div class="input-field third-wrap">
                            <button class="btn-search result_btn" type="button">Search</button>
                          </div>
                        </div>
                      </form>
                    <div class="guess"></div>
        </section>
        <section class="result ">
            <div class="box table-responsive ">
                    <table class="table table_result">
                            <tbody id="body">

                            </tbody>
                          </table>
            </div>
            
        </section>
        {{-- <div id="down"> <a href="bill" role="button"  class="btn btn-primary">Add Bill</a></div> --}}
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
    <script src={{asset("js/cashier/extention/choices.js")}}></script>
    <script>
      const choices = new Choices('[data-trigger]',
      {
        searchEnabled: false,
        itemSelectText: '',
      });

      $(".result_btn").click(function(){
         $(".guess").hide();
          var search = $("#search").val();
          var type = $("#type").val();
          if(type==0)
          {
            $(".noType").show();
            $(".noType").fadeOut(2000);
          }else
          {
            
            $.ajax({
              url:'search',
              type:"get",
              data:{search:search,type:type},
              headers:
		        {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
              success:function(data)
              {
                  if(data=="noData")
                  {
                    $(".noData").show();
                    $(".noData").fadeOut(2000);
                  }else
                  {
                    $(".result").fadeIn();
                    $("#body").html(data);
                  }

              }
          })
          }

      })
      $("#search").keyup(function(){
          var key = $("#search").val();
          $(".guess").slideDown();
        $(".result").hide();
        $.ajax({
            url:"searchKey",
            type:"get",
            data:{key:key},
            headers:
		        {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success:function(data)
            {
                $(".guess").html(data);
                if($(".guess").html()=="")
            {
            $(".guess").slideUp();
            }
            }
        })
      })
      $(".guess").on('click',".each",function(){
          $("#search").val($(this).text());
          $(".guess").slideUp();
      })
    </script>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table
{
    width: 80%;
    text-align: center;
}
#logo
{
    height: 60px;
}
    #invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:2mm;
  margin: 0 auto;
  width: 80mm;
  background: #FFF;
  
  
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}
 
#top, #mid,#bot{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}

#top{min-height: 100px;}
#mid{min-height: 80px;} 
#bot{ min-height: 50px;}

#top .logo{
  //float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
	background-size: 60px 60px;
}
.clientlogo{
  float: left;
	height: 60px;
	width: 60px;
	background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  //float:left;
  margin-left: 0;
}
.title{
  float: right;
}
.title p{text-align: right;} 
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  //padding: 5px 0 5px 15px;
  //border: 1px solid #EEE
}
.tabletitle{
  //padding: 5px;
  font-size: .5em;
  background: #EEE;
}
.service{border-bottom: 1px solid #EEE;}
.item{width: 24mm;}
.itemtext{font-size: .5em;}

#legalcopy{
  margin-top: 5mm;
}


  
  
}

</style>
<body>
        <?php $i=0; ?> 
  <div id="invoice-POS">

    <section id="top">
      <div class=""><img id="logo" src="{{asset('images/cashier/logo.jpg')}}"></div>
      <div class="info"> 
         <h2>Shefaa Pharmacy <h2>
      </div><!--End Info-->
    </section><!--End InvoiceTop-->
    <br>
    <hr>

    <div id="bot">

					<div class="table-responsive" >
						<table class="table">
                            <thead>
                                    <th > Item </th>
                                    <th>Name</th>
                                    <th > Stripe </th>
                                    <th > Price</th>
                            </thead>
                            <tbody>
                            @foreach ($medicinesPrint as $item)
                                <tr class="">
                                    <td>{{$i+1}}-</td>
                                    <td class=""> {{$item}} </td>
                                    <td class=""> {{$stripPrint[$i]}} </td>
                                    <td class=""> {{$costPrint[$i]}} </td>
                                </tr>     
                                <?php $i++; ?> 
                            @endforeach
                            </tbody>  
						</table>
                    </div><!--End Table-->
                    <br>
                    <hr><br>
                    <h4>Total : {{$total}} </h4><br>
                    <h5>Date : {{$date}} </h5>
					<div id="legalcopy">
						<p class="legal"><strong>Thank you for your Vist!</strong>  we wish you a good health. 
                        </p>
                        <br><br>
                        <hr>
					</div>

				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->
<script>
    window.print();
    setTimeout(function () { document.location.href = "http://localhost:8000/buy";; }, 100);
    // document.location.href = "http://localhost:8000/buy"; 
    // window.location.assign('http://localhost:8000/buy');
</script>
</body>
</html>
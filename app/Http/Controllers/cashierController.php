<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as IlluminateRequest;
use Illuminate\Support\Facades\DB;
use App\bill;
use App\sell;
use App\item;
use App\makeupItem;

class cashierController extends Controller
{
    public function cashierLogin()
    {
        $branches = DB::table('branches')->get();
        return view('cashier/login')->with(['branchs'=>$branches]);
    }
    public function cashierLogout()
    {
        session_start();
        unset($_SESSION['cashier']);
        return redirect('cashier/login');
    }
    public function cashierCheck(Request $request)
    {
        $cashier = DB::table('cashier')->where('email',$request->email)->first();
        if($cashier)
        {
            if($cashier->pass==$request->pass)
            {
                session_start();
                $_SESSION['cashier']='true';
                $_SESSION['branch']=$request->branch;
                return redirect('/');
            }else
            {
                return back()->with(['errorPass'=>'true']);
            } 
        }else
        {
            return back()->with(['errorEmail'=>'true']);
        }    
        return view('cashier/login');
    }
    public function home()
    {
        session_start();
        if(!isset($_SESSION['cashier']))
        {
            return redirect('cashier/login')->with(['access'=>'true']);
        }
        return view('cashier/home');
    }
    public function search(Request $request)
    {
        session_start();
        if(!isset($_SESSION['cashier']))
        {
            return redirect('cashier/login')->with(['access'=>'true']);
        }
        $html = "";
        if($request->type==1)
        {
            $medicine = DB::table('medicines')->where('name',$request->search)->where('branche_id',$_SESSION['branch'])->first();
            if($medicine)
            {
                $src_path = "../../../../images/medicine/".$medicine->photo;
                $items = DB::table('items')->where('medicine_id',$medicine->id)->count();
                $html.="
                <tr>
                <td class='white'>Type :</td>
                <td class='white'>Medicine</td>
              </tr>
              <tr>
              <td class='white'>Name :</td>
                <td class='white' >$medicine->name</td>
                </tr>
              <tr>
              <td class='white'>Price :</td>
                <td class='white'>$medicine->cost</td>
              </tr>
              <tr>
              <td class='white'>Packet NO :</td>
                 <td class='white'>$items</td>
              </tr>
              <tr>
              <td class='white'> Photo :</td>
                 <td class='white'>
                     <a target='_blank' rel='noopener noreferrer' href='http://localhost:8000/images/medicine/".$medicine->photo."' >
                         <img class='card-img-top' alt='image not found'src=\"$src_path\">
                     </a>
                 </td>
              </tr>
                ";
            }else
            {
               return("noData");
            }

        }else
        {
            $makeup = DB::table('makeups')->where('name',$request->search)->where('branche_id',$_SESSION['branch'])->first();
            $src_path = "../../../../images/makeup/".$makeup->photo;
            if($makeup)
            {
                $items = DB::table('makeup_items')->where('makeup_id',$makeup->id)->count();
                $html.="
                <tr>
                <td class='white'>Type :</td>
                <td class='white'>Mackup</td>
              </tr>
              <tr>
                <td class='white'>Name :</td> 
                <td class='white' >$makeup->name</td> 
            </tr>
              <tr>
              <td class='white'>Price :</td>
              <td class='white'>$makeup->cost</td>
                
              </tr>
              <tr>
              <td class='white'>Packet NO :</td>
                <td class='white'>$items</td>
                
              </tr>
              <tr >
              <td class='white'> Photo :</td>
                 <td class='white' rowspan='5'>
                     <a target='_blank' rel='noopener noreferrer' href='http://localhost:8000/images/makeup/".$makeup->photo."' >
                         <img class='card-img-top' alt='image not found'src=\"$src_path\">
                     </a>
                 </td>
              </tr>
                ";
            }else
            {
                return("noData");
            }

        }
        return($html);
        
    }
    public function searchKey(Request $request)
    {
        session_start();
        $html = "";
        $medicines = DB::table('medicines')->where('name',"LIKE","%{$request->key}%")->where('branche_id',$_SESSION['branch'])->get();
        $makeups = DB::table('makeups')->where('name',"LIKE","%{$request->key}%")->where('branche_id',$_SESSION['branch'])->get();
        foreach($medicines as $medicine)
        {
            $html .= "
                <div class='each'>$medicine->name</div>
            ";
        }
        foreach($makeups as $makeup)
        {
            $html .= "
            <div class='each'>$makeup->name</div>
        "; 
        }
        return($html);
    }
    public function buy()
    {
        session_start();
        if(!isset($_SESSION['cashier']))
        {
            return redirect('cashier/login')->with(['access'=>'true']);
        }
        return view('cashier/buy');
    }
    public function addBuy(Request $request)
    {
        session_start();
        $item = DB::table('items')->where('code',$request->code)->first();
        if($item)
        {
            $medicine = DB::table('medicines')->where('id',$item->medicine_id)->where('branche_id',$_SESSION['branch'])->first();
            $html ="
            <tr>
                <td><input type='text' value=\"$item->code\" name='code[]' readonly</td>
                <td><input type='text' value=\"$medicine->name\" name='name[]' readonly></td>";
                if($item->stripe==0)
                {
                    $html .="<td><input type='number' max=\"$item->stripe\" min='0' name='stripe[]' value=\"$item->stripe\"></td>";
                }else
                {
                   $html .= " <td><input type='number' max=\"$item->stripe\" min='1' name='stripe[]' value=\"$item->stripe\"></td>";
                }
                $html .= "
                <td><input type='number' value=\"$medicine->cost\" name='cost[]' readonly></td>
                <td>
                <button class='btn btn-primary cancle'>cancle</button>
                </td>  
            </tr>
        ";
        return($html);
        }else 
        {
            $mackup_item = DB::table('makeup_items')->where('code',$request->code)->first();
            if($mackup_item)
            {
                $makeup = DB::table('makeups')->where('id',$mackup_item->makeup_id)->where('branche_id',$_SESSION['branch'])->first();
                $html ="
                <tr>
                    <td><input type='text' value=\"$mackup_item->code\" name='code[]' readonly</td>
                    <td><input type='text' value=\"$makeup->name\" name='name[]' readonly></td>
                    <td><input type='number' max='0' min='0' name='stripe[]' value='0'></td>
                    <td><input type='number' value=\"$makeup->cost\" name='cost[]' readonly></td>
                    <td>
                    <button class='btn btn-primary cancle'>cancle</button>
                    </td>  
                </tr>
            ";
            return($html);                
            }else
            {
                return('noData');
            }
            
        }    

    }
    public function tableData(Request $request)
    {
        $date = date("Y/m/d") ."  " .date("h:i:sa");
        $medicinesPrint = array();
        $stripPrint = array();
        $costPrint = array();
        session_start();
        if(!$request->code)
        {
            return back()->with(['failure'=>'true']);
        }
        $total = 0;
        $newBill = new bill;
        $newBill->total = 0;
        $newBill->branche_id = $_SESSION['branch'];
        $newBill->save();
        $id = DB::getPdo()->lastInsertId();
        for($i=0;$i<count($request->code);$i++)
        {
           
            $item = DB::table('items')->where('code',$request->code[$i])->first();
            if($item)
            {
                
                $medicinestripe = DB::table('medicines')->where('id',$item->medicine_id)->first();
                $itemstripe=DB::table('items')->where('id',$item->id)->first()->stripe;
                $stripeNo = (int)$request->stripe[$i]; 
                $newSell = new sell;
                $newSell->code = $item->code;
                $newSell->category_id = $item->medicine_id;
                $newSell->source_id = $item->source_id;
                $newSell->precentage = $item->precentage;
                $newSell->stripe = $request->stripe[$i];
                $newSell->expiration = $item->expiration;
                $newSell->bill_id=$id;
                $newSell->branche_id = $_SESSION['branch'];
                $newSell->type = "medicine";
                $newSell->save();
                array_push($medicinesPrint,$medicinestripe->name);
                array_push($costPrint,$medicinestripe->cost);
                array_push($stripPrint,$request->stripe[$i]);
                if($medicinestripe->stripe==0)
                {
                    $total += $request->cost[$i];
                }else
                {

                    $total +=($request->cost[$i]*$request->stripe[$i]/$medicinestripe->stripe);
                }
                if($stripeNo==$itemstripe)
                {
                    
                    $newItem =new item;
                    $deleteItem = $newItem::find($item->id);
                    $deleteItem->delete();
                }else
                {
                    DB::table('items')->where('id',$item->id)->update(['stripe'=>$itemstripe-$stripeNo]);
                }
            }else
            {
                $total += $request->cost[$i];
                $makeupItem = DB::table('makeup_items')->where('code',$request->code[$i])->first();
                $makeupPrint = DB::table('makeups')->where('id',$makeupItem->makeup_id)->first();
                $newSell = new sell;
                $newSell->code = $makeupItem->code;
                $newSell->category_id = $makeupItem->makeup_id;
                $newSell->source_id = $makeupItem->source_id;
                $newSell->precentage = $makeupItem->precentage;
                $newSell->expiration = $makeupItem->expiration;
                $newSell->stripe = 0;
                $newSell->type = "makeup";
                $newSell->bill_id=$id;
                $newSell->branche_id = $_SESSION['branch'];
                $newSell->save();
                array_push($medicinesPrint,$makeupPrint->name);
                array_push($costPrint,$makeupPrint->cost);
                array_push($stripPrint,0);
                $newMakeupItem =new makeupItem;;
                $deleteMakeupItem = $newMakeupItem::find($makeupItem->id);
                $deleteMakeupItem->delete();
            }
        }
        $total = $total-(5*$total/100);
        DB::table('bills')->where('id',$id)->update(['total'=>$total]);
        return view('cashier/print')->with(['date'=>$date,'total'=>$total,'medicinesPrint'=>$medicinesPrint,'costPrint'=>$costPrint,'stripPrint'=>$stripPrint]);
        // return back()->with(['success'=>'true']);
    }
    //Retrive
    public function retrieve()
    {
        session_start();
        if(!isset($_SESSION['cashier']))
        {
            return redirect('cashier/login')->with(['access'=>'true']);
        }
        return view('cashier/retrieve');
    }
    public function addRetrieve(Request $request)
    {
        session_start();
        $item = DB::table('sells')->where('code',$request->code)->where('branche_id',$_SESSION['branch'])->first();
        if($item)
        {
            if($item->type=="medicine")
            {
                $medicine = DB::table('medicines')->where('id',$item->category_id)->where('branche_id',$_SESSION['branch'])->first();
                $html ="
                <tr>
                    <td><input type='text' value=\"$item->code\" name='code[]' readonly</td>
                    <td><input type='text' value=\"$item->type\" name='type[]' readonly</td>";
                    $html .= "<td><input type='text' value=\"$medicine->name\" name='name[]' readonly></td>";
                    if($item->stripe==0)
                    {
                        $html .="<td><input type='number' max=\"$item->stripe\" min='0' name='stripe[]' value=\"$item->stripe\"></td>";
                    }else
                    {
                       $html .= " <td><input type='number' max=\"$item->stripe\" min='1' name='stripe[]' value=\"$item->stripe\"></td>";
                    }
                    $html .= " <td><input type='number' value=\"$medicine->cost\" name='cost[]' readonly></td>";
            }else
            {
                $makeup = DB::table('makeups')->where('id',$item->category_id)->where('branche_id',$_SESSION['branch'])->first();
                $html ="
                <tr>
                    <td><input type='text' value=\"$item->code\" name='code[]' readonly</td>
                    <td><input type='text' value=\"$item->type\" name='type[]' readonly</td>";
                    $html .= "<td><input type='text' value=\"$makeup->name\" name='name[]' readonly></td>";
                    $html .="<td><input type='number' max=\"$item->stripe\" min='0' name='stripe[]' value=\"$item->stripe\"></td>";
                    $html .= " <td><input type='number' value=\"$makeup->cost\" name='cost[]' readonly></td>";
            }
                $html .= "
                
                <td>
                <button class='btn btn-primary cancle'>cancle</button>
                </td>  
            </tr>
        ";
        return($html);            
            }else
            {
                return('noData');
            }
        }    
        public function dataRetrieve(request $request)
        {
            session_start();
            $retrieveMoney=0;
            for($i=0;$i<count($request->code);$i++)
            {
                $sell = DB::table('sells')->where('code',$request->code[$i])->first();
                if($request->type[$i]=="medicine")
                {
                    
                    $packet = DB::table('items')->where('code',$request->code[$i])->first();
                    $medicine =  DB::table('medicines')->where('id',$sell->category_id)->where('branche_id',$_SESSION['branch'])->first();
                    if($packet)
                    {
                        if($packet->stripe==0)
                        {
                            $retrieveMoney = $request->cost[$i];
                            $newSell = new sell;
                            $deleteItem = $newSell::find($sell->id);  
                            $deleteItem->delete();  
                        }else
                        {
                            $retrieveMoney = $request->cost[$i]*$request->stripe[$i]/$medicine->stripe;
                            if($sell->stripe-$request->stripe[$i]==0)
                            {
                                $newSell = new sell;
                                $deleteItem = $newSell::find($sell->id);  
                                $deleteItem->delete();  
                            }else
                            {
                                DB::table('sells')->where('id',$sell->id)->update(['stripe'=>$sell->stripe-$request->stripe[$i]]);   
                            }
                            
                        }

                        DB::table('items')->where('code',$request->code[$i])->update(['stripe'=>$packet->stripe+$request->stripe[$i]]);
                    }else
                    {
                        if($medicine->stripe==0)
                        {
                            $retrieveMoney = $request->cost[$i];
                        }else
                        {
                            $retrieveMoney = $request->cost[$i]*$request->stripe[$i]/$medicine->stripe;
                        }
                        
                        $item = new item;
                        $item->code = $request->code[$i];
                        $item->expiration = $sell->expiration;
                        $item->precentage = $sell->precentage;
                        $item->source_id = $sell->source_id;
                        $item->medicine_id = $sell->category_id;
                        $item->stripe = $request->stripe[$i];
                        $item->save();
                        if($sell->stripe-$request->stripe[$i]==0)
                        {
                            $newSell = new sell;
                            $deleteItem = $newSell::find($sell->id);  
                            $deleteItem->delete();  
                        }else
                        {
                            DB::table('sells')->where('id',$sell->id)->update(['stripe'=>$sell->stripe-$request->stripe[$i]]);
                        }
                    }
                    
                }elseif($request->type[$i]=="makeup")
                {
                    $retrieveMoney = $request->cost[$i];
                    $makeupItem = new makeupItem;
                    $makeupItem->code = $sell->code;
                    $makeupItem->expiration = $sell->expiration;
                    $makeupItem->precentage = $sell->precentage;
                    $makeupItem->source_id = $sell->source_id;
                    $makeupItem->makeup_id = $sell->category_id;
                    $makeupItem->save();
                    $newSell = new sell;
                    $deleteItem = $newSell::find($sell->id);  
                    $deleteItem->delete();  
                }else
                {
                    return back()->with(['fail'=>'noData']);
                }
                $bill = DB::table('bills')->where('id',$sell->bill_id)->first();
                if($bill->total-$retrieveMoney<0)
                {
                    $newBill = new bill;
                    $deleteBill = $newBill::find($sell->bill_id);
                    $deleteBill->delete();
                }else
                {
                    
                    DB::table('bills')->where('id',$sell->bill_id)->update(['total'=>$bill->total-$retrieveMoney]);
                }
            

            }
            return back()->with(['success'=>'true']);
        }


}

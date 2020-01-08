<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\company;
use App\store;
use App\medicine;
use App\item;
use App\source;
use App\makeup;
use App\makeupItem;
use App\transaction;
use App\branch;


class adminController extends Controller
{
    public function login()
    {
        $branches = DB::table('branches')->get();
        return view('admin/pages/login')->with(['branchs'=>$branches]);
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['admin']);
        return redirect('admin/login');
    }
    public function adminCheck(Request $request)
    {
        $admin = DB::table('admins')->where('email',$request->email)->first();
        if($admin)
        {
            if($admin->pass==$request->pass)
            {
                session_start();
                $_SESSION['admin']='true';
                $_SESSION['branch']=$request->branch;
                return redirect('admin/dashboard');
            }else
            {
                return back()->with(['errorPass'=>'true']);
            } 
        }else
        {
            return back()->with(['errorEmail'=>'true']);
        }    
        return view('admin/pages/login');
    }
    public function dashboard()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $medicines = DB::table('medicines')->where('branche_id',$_SESSION['branch'])->get()->count();
            $makeups = DB::table('makeups')->where('branche_id',$_SESSION['branch'])->get()->count();
            $companies = DB::table('sources')->where('type','company')->where('branche_id',$_SESSION['branch'])->get()->count();
            $stores = DB::table('sources')->where('type','store')->where('branche_id',$_SESSION['branch'])->get()->count();
           return view('admin/pages/dashboard')->with(['medicines'=>$medicines,'makeups'=>$makeups,'companies'=>$companies,'stores'=>$stores]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }


    //company
    public function company()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $companies = DB::table('sources')->where('type','company')->where('branche_id',$_SESSION['branch'])->get();
            return view('admin/pages/company')->with(['companies'=>$companies]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function newCompany()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view('admin/pages/newCompany');
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
        
    }
    public function addCompany(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $company = new source();
            $company->name = $request->company;
            $company->type = 'company';
            $company->branche_id = $_SESSION['branch'];
    
            $company->save();
            return redirect('admin/company')->with(['add'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function editCompany(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $source = DB::table('sources')->where('id',$request->id)->first();
            return view('admin/pages/editCompany')->with(['source'=>$source]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function updateCompany(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            DB::table('sources')->where('id',$request->id)->update(['name'=>$request->name]);
            return redirect('admin/company')->with(['edit'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function deleteCompany(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $newCompany = new source;
            $company = $newCompany::find($request->id);
            $company->items()->delete();
            $company->delete();
            return redirect('admin/company')->with(['delete'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function companyMedicine(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $items = DB::table('items')->where('source_id',$request->id)->orderBy('expiration')->get();
            $html = "";
            $medicines =DB::table('medicines')->get();
            foreach($medicines as $medicine)
            {
                $item = DB::table('items')->where('source_id',$request->id)->where('medicine_id',$medicine->id)->first();
                $packetNo =  DB::table('items')->where('source_id',$request->id)->where('medicine_id',$medicine->id)->count();
                if($item)
                {
                    $html .= "
                    <tr>
                    <td> $medicine->name</td>
                    <td><a href=\"medicines/items?id=$request->id&medicine_id=$medicine->id\" class='btn btn-primary' role='button'> $packetNo </a></td>
                    <td><a>$medicine->material</a> </td>
                    <td><a>$medicine->cost</a></td>
                </tr>
                    ";
                }
    
                
            }
            return view('admin/pages/companyMedicines')->with(['company'=>$company,'html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function companyMedicineItems(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $medicine = DB::table('medicines')->where('id',$request->medicine_id)->first();
            $items = DB::table('items')->where('medicine_id',$request->medicine_id)->where('source_id',$request->id)->orderBy('expiration')->get();
            foreach($items as $item)
            {
                $source_name = DB::table('sources')->where('id',$item->source_id)->first()->name;
                $html .= "
                <tr>
                <td> $item->code</td>
                
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
            </tr>
                ";
            }
            return view('admin/pages/companyMedicineItems')->with(['medicine'=>$medicine,'source'=>$company,'html'=>$html,'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function companyMakeup(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $items = DB::table('makeup_items')->where('source_id',$request->id)->orderBy('expiration')->get();
            $html = "";
            $makeups =DB::table('makeups')->get();
            foreach($makeups as $makeup)
            {
                $item = DB::table('makeup_items')->where('source_id',$request->id)->where('makeup_id',$makeup->id)->first();
                $packetNo =  DB::table('makeup_items')->where('source_id',$request->id)->where('makeup_id',$makeup->id)->count();
                if($item)
                {
                    $html .= "
                    <tr>
                    <td> $makeup->name</td>
                    <td><a href=\"admin/company/makeup/items?id=$request->id&makeup_id=$makeup->id\" class='btn btn-primary' role='button'> $packetNo </a></td>
                    <td><a>$makeup->cost</a></td>
                </tr>
                    ";
                }
    
                
            }
            return view('admin/pages/companyMakeups')->with(['company'=>$company,'html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function companyMakeupItems(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $makeup = DB::table('makeups')->where('id',$request->makeup_id)->first();
            $items = DB::table('makeup_items')->where('makeup_id',$request->makeup_id)->where('source_id',$request->id)->orderBy('expiration')->get();
            foreach($items as $item)
            {
                $source_name = DB::table('sources')->where('id',$item->source_id)->first()->name;
                $html .= "
                <tr>
                <td> $item->code</td>
                
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
            </tr>
                ";
            }
            return view('admin/pages/companyMakeupItems')->with(['makeup'=>$makeup,'source'=>$company,'html'=>$html,'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function companyBills(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $source = DB::table('sources')->where('id',$request->id)->first();
            return view('admin/pages/companyBills')->with(['source'=>$source]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
    }
    public function newCompanyBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view('admin/pages/newCompanyBill')->with(['id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
        
    }
    public function addCompanyBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $validator = validator::make($request->all(),[
                'file' => 'required',
                'file.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
        if($validator->fails())
        {
            return back()->with(['error'=>'true']);
        }else
        {
            $getimageName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('images/Bills'), $getimageName);
            $newTransaction = new transaction;
            $newTransaction->date = $request->date;
            $newTransaction->total = $request->total;
            $newTransaction->source_id = $request->source_id;
            $newTransaction->branche_id = $_SESSION['branch'];

    
            $newTransaction->src = $getimageName;
            $newTransaction->save();
            return redirect("/admin/company/bills?id=$request->source_id")->with(['add'=>'true']);
        }
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function showCompanyBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $month = date("m",strtotime($request->month));
            $year = date("Y",strtotime($request->month));
            $html = "";
            $transactions = DB::table('transactions')->where('source_id',$request->id)->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date')->get();
            foreach($transactions as $transaction)
            {
                $src_path = "../../../../images/Bills/".$transaction->src;
                $html .="
                
                    <div class='card col-lg-2 col-sm-4 col-xs-5' >
                        <a target='_blank' rel='noopener noreferrer' href='images/Bills/".$transaction->src."' >
                            <img class='card-img-top' alt='image not found'src=\"$src_path\">
                        </a>
                        <div clas='card-body'>
                            <h5 class='card-title'>Date :$transaction->date</h5>
                            <h5 class='card-title'>Total :$transaction->total</h5>
                        </div>
                    </div>
                ";
            }
            return($html);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function showAllCompanyBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $transactions = DB::table('transactions')->where('source_id',$request->id)->orderBy('date')->get();
            foreach($transactions as $transaction)
            {
                $src_path = "../../../../images/Bills/".$transaction->src;
                $html .="
                
                    <div class='card col-lg-2 col-sm-4 col-xs-5' >
                        <a target='_blank' rel='noopener noreferrer' href='images/Bills/".$transaction->src."' >
                            <img class='card-img-top' alt='image not found'src=\"$src_path\">
                        </a>
                        <div clas='card-body'>
                            <h5 class='card-title'>Date :$transaction->date</h5>
                            <h5 class='card-title'>Total :$transaction->total</h5>
                        </div>
                    </div>
                ";
            }
            return($html);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }


    //store
    public function store()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $stores = DB::table('sources')->where('type','store')->where('branche_id',$_SESSION['branch'])->get();
            return view('admin/pages/store')->with(['stores'=>$stores]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function newStore()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view('admin/pages/newStore');
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function addStore(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $store = new source();
            $store->name = $request->store;
            $store->type = 'store';
            $store->branche_id = $_SESSION['branch'];

            $store->save();
            return redirect('admin/store')->with(['add'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function editStore(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $store = DB::table('sources')->where('id',$request->id)->first();
            return view('admin/pages/editStore')->with(['store'=>$store]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function updateStore(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            DB::table('sources')->where('id',$request->id)->update(['name'=>$request->name]);
            return redirect('admin/store')->with(['edit'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function deleteStore(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $newStore = new source;
            $store = $newStore::find($request->id);
            $store->items()->delete();
            $store->delete();
            return redirect('admin/store')->with(['delete'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function storeMedicine(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $items = DB::table('items')->where('source_id',$request->id)->orderBy('expiration')->get();
            $html = "";
            $medicines =DB::table('medicines')->get();
            foreach($medicines as $medicine)
            {
                $item = DB::table('items')->where('source_id',$request->id)->where('medicine_id',$medicine->id)->first();
                $packetNo =  DB::table('items')->where('source_id',$request->id)->where('medicine_id',$medicine->id)->count();
                if($item)
                {
                    $html .= "
                    <tr>
                    <td> $medicine->name</td>
                    <td><a href=\"medicines/items?id=$request->id&medicine_id=$medicine->id\" class='btn btn-primary' role='button'> $packetNo </a></td>
                    <td><a>$medicine->material</a> </td>
                    <td><a>$medicine->cost</a></td>
                </tr>
                    ";
                }
    
                
            }
            return view('admin/pages/storesMedicines')->with(['company'=>$company,'html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function storeMedicineItems(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $medicine = DB::table('medicines')->where('id',$request->medicine_id)->first();
            $items = DB::table('items')->where('medicine_id',$request->medicine_id)->where('source_id',$request->id)->orderBy('expiration')->get();
            foreach($items as $item)
            {
                $source_name = DB::table('sources')->where('id',$item->source_id)->first()->name;
                $html .= "
                <tr>
                <td> $item->code</td>
                
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
            </tr>
                ";
            }
            return view('admin/pages/storeMedicineItems')->with(['medicine'=>$medicine,'source'=>$company,'html'=>$html,'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function storeMakeup(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $items = DB::table('makeup_items')->where('source_id',$request->id)->orderBy('expiration')->get();
            $html = "";
            $makeups =DB::table('makeups')->get();
            foreach($makeups as $makeup)
            {
                $item = DB::table('makeup_items')->where('source_id',$request->id)->where('makeup_id',$makeup->id)->first();
                $packetNo =  DB::table('makeup_items')->where('source_id',$request->id)->where('makeup_id',$makeup->id)->count();
                if($item)
                {
                    $html .= "
                    <tr>
                    <td> $makeup->name</td>
                    <td><a href=\"admin/store/makeup/items?id=$request->id&makeup_id=$makeup->id\" class='btn btn-primary' role='button'> $packetNo </a></td>
                    <td><a>$makeup->cost</a></td>
                </tr>
                    ";
                }
    
                
            }
            return view('admin/pages/storeMakeups')->with(['company'=>$company,'html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function storeMakeupItems(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $makeup = DB::table('makeups')->where('id',$request->makeup_id)->first();
            $items = DB::table('makeup_items')->where('makeup_id',$request->makeup_id)->where('source_id',$request->id)->orderBy('expiration')->get();
            foreach($items as $item)
            {
                $source_name = DB::table('sources')->where('id',$item->source_id)->first()->name;
                $html .= "
                <tr>
                <td> $item->code</td>
                
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
            </tr>
                ";
            }
            return view('admin/pages/storeMakeupItems')->with(['makeup'=>$makeup,'source'=>$company,'html'=>$html,'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }

    public function storeBills(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $source = DB::table('sources')->where('id',$request->id)->first();
            return view('admin/pages/storeBills')->with(['source'=>$source]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function newStoreBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view('admin/pages/newStoreBill')->with(['id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
        
    }
    public function addStoreBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $validator = validator::make($request->all(),[
                'file' => 'required',
                'file.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
        if($validator->fails())
        {
            return back()->with(['error'=>'true']);
        }else
        {
            $getimageName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('images/Bills'), $getimageName);
            $newTransaction = new transaction;
            $newTransaction->date = $request->date;
            $newTransaction->total = $request->total;
            $newTransaction->source_id = $request->source_id;
            $newTransaction->branche_id = $_SESSION['branch'];
            $newTransaction->src = $getimageName;
            $newTransaction->save();
            return redirect("/admin/store/bills?id=$request->source_id")->with(['add'=>'true']);
        }
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function showStoreBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $month = date("m",strtotime($request->month));
            $year = date("Y",strtotime($request->month));
            $html = "";
            $transactions = DB::table('transactions')->where('source_id',$request->id)->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date')->get();
            foreach($transactions as $transaction)
            {
                $src_path = "../../../../images/Bills/".$transaction->src;
                $html .="
                
                    <div class='card col-lg-2 col-sm-4 col-xs-5' >
                        <a target='_blank' rel='noopener noreferrer' href='images/Bills/".$transaction->src."' >
                            <img class='card-img-top' alt='image not found'src=\"$src_path\">
                        </a>
                        <div clas='card-body'>
                            <h5 class='card-title'>Date :$transaction->date</h5>
                            <h5 class='card-title'>Total :$transaction->total</h5>
                        </div>
                    </div>
                ";
            }
            return($html);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function showAllStoreBill(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $transactions = DB::table('transactions')->where('source_id',$request->id)->orderBy('date')->get();
            foreach($transactions as $transaction)
            {
                $src_path = "../../../../images/Bills/".$transaction->src;
                $html .="
                
                    <div class='card col-lg-2 col-sm-4 col-xs-5' >
                        <a target='_blank' rel='noopener noreferrer' href='images/Bills/".$transaction->src."' >
                            <img class='card-img-top' alt='image not found'src=\"$src_path\">
                        </a>
                        <div clas='card-body'>
                            <h5 class='card-title'>Date :$transaction->date</h5>
                            <h5 class='card-title'>Total :$transaction->total</h5>
                        </div>
                    </div>
                ";
            }
            return($html);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    //medicine
    public function medicine()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $medicines = DB::table('medicines')->where('branche_id',$_SESSION['branch'])->get();
            $html="";
            foreach($medicines as $medicine)
            {
                $packetNo = DB::table('items')->where('medicine_id',$medicine->id)->count();
                $html.="
                <tr>
                <td>  $medicine->name </td>
                <td><a href=\"material?material= $medicine->material \"  class='btn btn-primary' role='button'> $medicine->material </a></td>
                <td><a href=\"medicine/items?id= $medicine->id \"  class='btn btn-primary' role='button'> $packetNo</a></td>
                <td><a> $medicine->stripe</a></td>
                <td><a > $medicine->cost </a></td>
    
                <td>
                    <a href=\"admin/medicine/edit?id= $medicine->id \" class='btn btn-primary' role='button'>edit</a>
                    <a href=\"admin/medicine/delete?id= $medicine->id \" class='btn btn-primary' role='button'  onclick=\"return confirm(  ' All related to the category will be deleted \\n are you sure you want to delete the category ?   '  );\">delete</a>
                </td>
            </tr>
                ";
            }
            return view('admin/pages/medicine')->with(['medicines'=>$medicines,'html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function newMedicine()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view('admin/pages/newMedicine');
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function addMedicine(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $medicines = DB::table('medicines')->where('name',$request->name)->where('branche_id',$_SESSION['branch'])->first();
            if($medicines)
            {
                return back()->with(['exist'=>'true']);
            }
            $validator = validator::make($request->all(),[
                'file' => 'required',
                'file.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if($validator->fails())
            {
                return back()->with(['error'=>'true']);
            }else
            {
                $getimageName = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path('images/medicine'), $getimageName);
                $medicine = new medicine();
                $medicine->name = $request->name;
                $medicine->material = $request->material;
                $medicine->stripe = $request->stripe;
                $medicine->cost = $request->cost;
                $medicine->branche_id = $_SESSION['branch'];
                $medicine->photo = $getimageName;

                $medicine->save();
                return redirect('admin/medicine')->with(['add'=>'true']);
            }

        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function editMedicine(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $medicine = DB::table('medicines')->where('id',$request->id)->first();
            return view('admin/pages/editMedicine')->with(['medicine'=>$medicine]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function updateMedicine(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $validator = validator::make($request->all(),[
                'file' => 'required',
                'file.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if($validator->fails())
            {
                return back()->with(['error'=>'true']);
            }else
            {
                $ImageName = DB::table('medicines')->where('id',$request->id)->first()->photo;
                $filepath = public_path()."/images/medicine/$ImageName";
                unlink($filepath);
                $getimageName = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path('images/medicine'), $getimageName); 
                DB::table('medicines')->where('id',$request->id)->update(['photo'=>$getimageName,'name'=>$request->name,'cost'=>$request->cost,'material'=>$request->material,'stripe'=>$request->stripe]);
                return redirect('admin/medicine')->with(['edit'=>'true']);
            }

        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function deleteMedicine(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $ImageName = DB::table('medicines')->where('id',$request->id)->first()->photo;
            $filepath = public_path()."/images/medicine/$ImageName";
            unlink($filepath);
            $newMedicine= new medicine;
            $medicine = $newMedicine::find($request->id);
            $medicine->items()->delete();
            $medicine->delete();
            return redirect('admin/medicine')->with(['delete'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function material(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $i = 0;
            $medicines = DB::table('medicines')->where('material',$request->material)->get();
            foreach($medicines as $medicine)
            {
                $i++;
                $packetNo = DB::table('items')->where('medicine_id',$medicine->id)->count();
                $html .="
                <tr>
                <td>$medicine->name-$i</td>
                <td>$packetNo</td>
                <td>$medicine->cost</td>
              </tr>
                ";
            }
            
            return view('admin/pages/material')->with(['html'=>$html,'material'=>$request->material]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function items(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $medicine = DB::table('medicines')->where('id',$request->id)->first();
            $items = DB::table('items')->where('medicine_id',$request->id)->orderBy('expiration')->get();
            foreach($items as $item)
            {
                $source_name = DB::table('sources')->where('id',$item->source_id)->first()->name;
                $html .= "
                <tr>
                <td><a href=\"admin/source/medicine?id=$item->source_id\"  class='btn btn-primary' role='button'>$source_name</a></td>
                <td> $item->code</td>
                
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
                <td>
                    <a href=\"item/edit?id=$item->id&medicine_id=$request->id\" class='btn btn-primary' role='button'>edit</a>
                    <a href=\"item/delete?id=$item->id&medicine_id=$request->id\" class='btn btn-primary' role='button' onclick= 'return confirm(\"All related to the packet will be deleted \\n are you sure you want to delete the packet ? \")');'>delete</a>
                </td>
            </tr>
                ";
            }
            return view('admin/pages/items')->with(['medicine'=>$medicine,'html'=>$html,'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
        

    }
    public function newItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $sources = DB::table('sources')->get();
            return view('admin/pages/newItem')->with(['sources'=>$sources , 'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function addItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $code = DB::table('items')->where('code',$request->code)->first();
            if(!$request->source_id)
            {
                return back()->with(['addCompnay'=>'true']);
            }
            if($code)
            {
                return back()->with(['changecode'=>'true']);
            }
            $medicineStripe = DB::table('medicines')->where('id',$request->id)->first()->stripe;
            $item = new item();
            $item->code = $request->code;
            $item->medicine_id = $request->id;
            $item->source_id = $request->source_id;
            $item->precentage = $request->precentage;
            $item->expiration = $request->expired;
            $item->stripe = $medicineStripe;
    
            $item->save();
            return redirect("admin/medicine/items?id=$request->id")->with(['add'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function editItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $sources = DB::table('sources')->get();
            $item = DB::table('items')->where('id',$request->id)->first();
            return view('admin/pages/editItem')->with(['sources'=>$sources,'item'=>$item,'id'=>$request->id,'medicine_id'=>$request->medicine_id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function updateItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            DB::table('items')->where('id',$request->id)->update(['code'=>$request->code,'source_id'=>$request->source_id,'expiration'=>$request->expired,'precentage'=>$request->precentage]);
            return redirect("admin/medicine/items?id=$request->medicine_id")->with(['edit'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function deleteItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $item = DB::table('items')->where('id',$request->id);
            $item->delete();
            return redirect("admin/medicine/items?id=$request->medicine_id")->with(['delete'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }


    //makeup section
    public function makeup()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $makeups = DB::table('makeups')->where('branche_id',$_SESSION['branch'])->get();
            foreach($makeups as $makeup)
            {
                $packetNo = DB::table('makeup_items')->where('makeup_id',$makeup->id)->count();
                $html.="
                <tr>
                <td>  $makeup->name </td>
                <td><a href=\"makeup/items?id= $makeup->id \"  class='btn btn-primary' role='button'> $packetNo</a></td>
                <td><a > $makeup->cost </a></td>
    
                <td>
                    <a href=\"makeup/edit?id= $makeup->id \" class='btn btn-primary' role='button'>edit</a>
                    <a href=\"makeup/delete?id= $makeup->id \" class='btn btn-primary' role='button'  onclick=\"return confirm(  ' All related to the category will be deleted \\n are you sure you want to delete the category ?   '  );\">delete</a>
                </td>
            </tr>
                ";
            }
            return view('admin/pages/makeup')->with(['html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function newMakeup()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view('admin/pages/newMakeup');
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function addMakeup(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $makeups = DB::table('makeups')->where('name',$request->name)->first();
            if($makeups)
            {
                return back()->with(['exist'=>'true']);
            }
            $validator = validator::make($request->all(),[
                'file' => 'required',
                'file.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if($validator->fails())
            {
                return back()->with(['error'=>'true']);
            }else
            {
                $getimageName = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path('images/makeup'), $getimageName);
                $makeup = new makeup();
                $makeup->name = $request->name;
                $makeup->cost = $request->cost;
                $makeup->branche_id = $_SESSION['branch'];
                $makeup->photo = $getimageName;
                $makeup->save();
                return redirect('admin/makeup')->with(['add'=>'true']);
            }

        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function editMakeup(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $makeup = DB::table('makeups')->where('id',$request->id)->first();
            return view('admin/pages/editMakeup')->with(['makeup'=>$makeup]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function updateMakeup(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $validator = validator::make($request->all(),[
                'file' => 'required',
                'file.*' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);
            if($validator->fails())
            {
                return back()->with(['error'=>'true']);
            }else
            {
                $ImageName = DB::table('makeups')->where('id',$request->id)->first()->photo;
                $filepath = public_path()."/images/makeup/$ImageName";
                unlink($filepath);
                $getimageName = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path('images/makeup'), $getimageName); 
                DB::table('makeups')->where('id',$request->id)->update(['photo'=>$getimageName,'name'=>$request->name,'cost'=>$request->cost]);
                return redirect('admin/makeup')->with(['edit'=>'true']);
            }
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function deleteMakeup(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $newMakeup = new makeup();
            $makeup = $newMakeup::find($request->id);
            $makeup->makeupItems()->delete();
            $makeup->delete();
            return redirect('admin/makeup')->with(['delete'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function makeupItems(request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $makeup = DB::table('makeups')->where('id',$request->id)->first();
            $items = DB::table('makeup_items')->where('makeup_id',$request->id)->orderBy('expiration')->get();
            foreach($items as $item)
            {
                $source_name = DB::table('sources')->where('id',$item->source_id)->first()->name;
                $html .= "
                <tr>
                <td><a href=\"admin/source/makeup?id=$item->source_id\"  class='btn btn-primary' role='button'>$source_name</a></td>
                <td> $item->code</td>
                
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
                <td>
                    <a href=\"admin/makeup/item/edit?id=$item->id&makeup_id=$request->id\" class='btn btn-primary' role='button'>edit</a>
                    <a href=\"admin/makeup/item/delete?id=$item->id&makeup_id=$request->id\" class='btn btn-primary' role='button' onclick=\"return confirm(  ' All related to the packet will be deleted \\n are you sure you want to delete the packet ?   '  );\">delete</a>
                </td>
            </tr>
                ";
            }
            return view('admin/pages/makeupItems')->with(['makeup'=>$makeup,'html'=>$html,'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function newMakeupItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $sources = DB::table('sources')->get();
            return view('admin/pages/newMakeupItem')->with(['sources'=>$sources , 'id'=>$request->id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function addMakeupItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $code = DB::table('makeup_items')->where('code',$request->code)->first();
            if(!$request->source_id)
            {
                return back()->with(['addCompnay'=>'true']);
            }
            if($code)
            {
                return back()->with(['changecode'=>'true']);
            }
            
            $item = new makeupItem();
            $item->code = $request->code;
            $item->makeup_id = $request->id;
            $item->source_id = $request->source_id;
            $item->precentage = $request->precentage;
            $item->expiration = $request->expired;
    
            $item->save();
            return redirect("admin/makeup/items?id=$request->id")->with(['add'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function editMakeupItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $sources = DB::table('sources')->get();
            $item = DB::table('makeup_items')->where('id',$request->id)->first();
            return view('admin/pages/editMakeupItem')->with(['sources'=>$sources,'item'=>$item,'id'=>$request->id,'makeup_id'=>$request->makeup_id]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function updateMakeupItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            DB::table('makeup_items')->where('id',$request->id)->update(['code'=>$request->code,'source_id'=>$request->source_id,'expiration'=>$request->expired,'precentage'=>$request->precentage]);
            return redirect("admin/makeup/items?id=$request->makeup_id")->with(['edit'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function deletesMakeupItem(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $item = DB::table('makeup_items')->where('id',$request->id);
            $item->delete();
            return redirect("admin/makeup/items?id=$request->makeup_id")->with(['delete'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function sourceMakeup(request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $company = DB::table('sources')->where('id',$request->id)->first()->name;
            $items = DB::table('makeup_items')->where('source_id',$request->id)->orderBy('expiration')->get();
            $html = "";
            foreach($items as $item)
            {
                $category = DB::table('makeups')->where('id',$item->makeup_id)->first();
                $html .= "
                <tr>
                <td> $category->name</td>
                <td> $item->code</td>
                <td><a >$item->precentage %</a></td>
                <td><a >$item->expiration</a></td>
    
                <td>
                    <a href=\"admin/makeup/item/edit?id=$item->id&makeup_id=$category->id\" class='btn btn-primary' role='button'>edit</a>
                    <a href=\"admin/makeup/item/delete?id=$item->id&makeup_id=$category->id\" class='btn btn-primary' role='button' onclick=\"return confirm(  ' All related to the packet will be deleted \\n are you sure you want to delete the packet ?   '  );\">delete</a>
                </td>
            </tr>
                ";
            }
            return view('admin/pages/companyMedicine')->with(['company'=>$company,'html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }


    //sells
    public function sells()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $bills = DB::table('bills')->where('branche_id',$_SESSION['branch'])->get();
            foreach($bills as $bill)
            {
                $sells = DB::table('sells')->where('bill_id',$bill->id)->get();
                $sellNo = $sells->count();
                $html .= "
                    <tr>
                        <td><a>$bill->created_at</a></td>
                        <td><a href=\"sells/items?id=$bill->id\" class='btn btn-primary' role='button'>$sellNo</a></td>
                        <td><a>$bill->total</a></td>
                    </tr>
                ";
            }
            return view('admin/pages/sells')->with(['html'=>$html]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function sellItems(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $sells = DB::table('sells')->where('bill_id',$request->id)->get();
            $bill = DB::table('bills')->where('id',$request->id)->first();
            foreach($sells as $sell)
            {
                if($sell->type =="medicine")
                {
                    $category = DB::table('medicines')->where('id',$sell->category_id)->first();
                }else
                {
                    $category = DB::table('makeups')->where('id',$sell->category_id)->first();
                }
                $html .= "
                    <tr>
                        <td><a>$category->name</a></td>
                        <td><a>$sell->type</a></td>
                        <td><a>$sell->code</a></td>
                        <td><a>$sell->stripe</a></td>
                        <td><a>$category->cost</a></td>
                        <td><a>$sell->expiration</a></td>
                    </tr>
                ";
            }
            return view('admin/pages/sellItems')->with(['html'=>$html,'bill_total'=>$bill->total]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function bills()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            return view("admin/pages/allBills");
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
        
    }
    public function showAllBills(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $html = "";
            $transactions = DB::table('transactions')->where('branche_id',$_SESSION['branch'])->orderBy('date')->get();
            foreach($transactions as $transaction)
            {
                $src_path = "../../../../images/Bills/".$transaction->src;
                $html .="
                
                    <div class='card col-lg-2 col-sm-4 col-xs-5' >
                        <a target='_blank' rel='noopener noreferrer' href='images/Bills/".$transaction->src."' >
                            <img class='card-img-top' alt='image not found'src=\"$src_path\">
                        </a>
                        <div clas='card-body'>
                            <h5 class='card-title'>Date :$transaction->date</h5>
                            <h5 class='card-title'>Total :$transaction->total</h5>
                        </div>
                    </div>
                ";
            }
            return($html);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
  
    }
    public function showBills(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $month = date("m",strtotime($request->month));
            $year = date("Y",strtotime($request->month));
            $html = "";
            $transactions = DB::table('transactions')->where('branche_id',$_SESSION['branch'])->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date')->get();
            foreach($transactions as $transaction)
            {
                $src_path = "../../../../images/Bills/".$transaction->src;
                $html .="
                
                    <div class='card col-lg-2 col-sm-4 col-xs-5' >
                        <a target='_blank' rel='noopener noreferrer' href='images/Bills/".$transaction->src."' >
                            <img class='card-img-top' alt='image not found'src=\"$src_path\">
                        </a>
                        <div clas='card-body'>
                            <h5 class='card-title'>Date :$transaction->date</h5>
                            <h5 class='card-title'>Total :$transaction->total</h5>
                        </div>
                    </div>
                ";
            }
            return($html);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }
    }
    public function branches()
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $branches = DB::table('branches')->get();
            return view("admin/pages/branches")->with(['branches'=>$branches]);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }
    public function addBranch(Request $request)
    {
        session_start();
        if(isset($_SESSION['admin']))
        {
            $branche = new branch;
            $branche->name = $request->name;
            $branche->save();
            return back()->with(['add'=>'true']);
        }else
        {
            return redirect('admin/login')->with(['access'=>'true']);
        }

    }

}

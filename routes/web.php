<?php
use App\Http\Controllers\adminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//admin
route::get('/admin/dashboard','adminController@dashboard');
route::get('/admin/login','adminController@login');
route::get('/admin/check','adminController@adminCheck');
route::get('/admin/logout','adminController@logout');
route::get('/cashier/login','cashierController@cashierLogin');
route::get('/cashier/check','cashierController@cashierCheck');
route::get('/cashier/logout','cashierController@cashierLogout');





//company
route::get('/admin/company','adminController@company');
route::get('/admin/company/new','adminController@newCompany');
route::post('/admin/company/new/add','adminController@addCompany');
route::get('/admin/company/edit','adminController@editCompany');
route::post('/admin/company/updata','adminController@updateCompany');
route::get('/admin/company/delete','adminController@deleteCompany');
route::get('/admin/source/medicine','adminController@companyMedicine');
route::get('/admin/company/medicine','adminController@companyMedicine');
route::get('/admin/company/medicines/items','adminController@companyMedicineItems');
route::get('/admin/company/makeup','adminController@companyMakeup');
route::get('/admin/company/makeup/items','adminController@companyMakeupItems');
route::get('/admin/company/bills','adminController@companyBills');
route::get('/admin/company/bill/new','adminController@newCompanyBill');
route::post('/admin/company/bill/new/add','adminController@addCompanyBill');
route::get('/admin/company/bills/show','adminController@showCompanyBill');
route::get('/admin/company/bills/showAll','adminController@showAllCompanyBill');








//store
route::get('/admin/store','adminController@store');
route::get('/admin/store/new','adminController@newStore');
route::post('/admin/store/new/add','adminController@addStore');
route::get('/admin/store/edit','adminController@editStore');
route::post('/admin/store/updata','adminController@updateStore');
route::get('/admin/store/delete','adminController@deleteStore');
route::get('/admin/store/medicine','adminController@storeMedicine');
route::get('/admin/store/medicines/items','adminController@storeMedicineItems');
route::get('/admin/store/makeup','adminController@storeMakeup');
route::get('/admin/store/makeup/items','adminController@storeMakeupItems');
route::get('/admin/store/bills','adminController@storeBills');
route::get('/admin/store/bill/new','adminController@newStoreBill');
route::post('/admin/store/bill/new/add','adminController@addStoreBill');
route::get('/admin/store/bills/show','adminController@showStoreBill');
route::get('/admin/store/bills/showAll','adminController@showAllStoreBill');




//medicine
route::get('/admin/medicine','adminController@medicine');
route::get('/admin/medicine/new','adminController@newMedicine');
route::post('/admin/medicine/new/add','adminController@addMedicine');
route::get('/admin/medicine/edit','adminController@editMedicine');
route::post('/admin/medicine/update','adminController@updateMedicine');
route::get('/admin/medicine/delete','adminController@deleteMedicine');
route::get('/admin/medicine/material','adminController@material');
route::get('/admin/medicine/items','adminController@items');
route::get('/admin/medicine/item/new','adminController@newItem');
route::post('/admin/medicine/item/new/add','adminController@addItem');
route::get('/admin/medicine/item/edit','adminController@editItem');
route::post('/admin/medicine/item/update','adminController@updateItem');
route::get('/admin/medicine/item/delete','adminController@deleteItem');


//makeup
route::get('/admin/makeup','adminController@makeup');
route::get('/admin/makeup/new','adminController@newMakeup');
route::post('/admin/makeup/new/add','adminController@addMakeup');
route::get('/admin/makeup/edit','adminController@editMakeup');
route::post('/admin/makeup/update','adminController@updateMakeup');
route::get('/admin/makeup/delete','adminController@deleteMakeup');
route::get('/admin/makeup/items','adminController@makeupItems');
route::get('/admin/makeup/item/new','adminController@newMakeupItem');
route::post('/admin/makeup/item/new/add','adminController@addMakeupItem');
route::get('/admin/makeup/item/edit','adminController@editMakeupItem');
route::post('/admin/makeup/item/update','adminController@updateMakeupItem');
route::get('/admin/makeup/item/delete','adminController@deletesMakeupItem');
route::get('/admin/source/makeup','adminController@sourceMakeup');

//sells
route::get('/admin/sells','adminController@sells');
route::get('/admin/sells/items','adminController@sellItems');

//bills
route::get('/admin/bills','adminController@bills');
route::get('/admin/bills/showAll','adminController@showAllBills');
route::get('/admin/bills/show','adminController@showBills');

//branches
route::get('/admin/branches','adminController@branches');
route::post('/admin/branches/add','adminController@addBranch');






//user
//search
route::get('/','cashierController@home');
route::get('/search','cashierController@search');
route::get('/searchKey','cashierController@searchKey');
//buy
route::get('/buy','cashierController@buy');
route::get('/buy/add','cashierController@addBuy');
route::get('buy/data','cashierController@tableData');
//retrieve
route::get('retrieve','cashierController@retrieve');
route::get('/retrieve/add','cashierController@addRetrieve');
route::get('/retrieve/data','cashierController@dataRetrieve');







































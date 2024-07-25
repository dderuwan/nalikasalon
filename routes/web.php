<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceController;

// Route::get('/', function () {
//     return view('dashboard.index');
// });

Auth::routes();

 Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');

// supplier module

 Route::get('/allsupplier', [App\Http\Controllers\SupplierController::class,'index'])->name('allsupplier');
 Route::get('/createsupplier',[App\Http\Controllers\SupplierController::class,'create'])->name('createsupplier');
 Route::post('/insertsupplier', [App\Http\Controllers\SupplierController::class,'store'])->name('insertsupplier');
 Route::get('/editsupplier/{id}', [App\Http\Controllers\SupplierController::class,'edit'])->name('editsupplier');
 Route::get('/showsupplier/{id}', [App\Http\Controllers\SupplierController::class,'show'])->name('showsupplier');
 Route::put('/updatesupplier', [App\Http\Controllers\SupplierController::class,'update'])->name('updatesupplier');
 Route::delete('/deletesupplier/{id}',[App\Http\Controllers\SupplierController::class,'destroy'])->name('deletesupplier');

 // Item module routes
 Route::get('/allitems', [App\Http\Controllers\ItemController::class, 'index'])->name('allitems');
 Route::get('/createitem', [App\Http\Controllers\ItemController::class, 'create'])->name('createitem');
 Route::post('/insertitem', [App\Http\Controllers\ItemController::class, 'store'])->name('insertitem');
 Route::get('/edititem/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edititem');
 Route::get('/showitem/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('showitem');
 Route::put('/updateitem/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('updateitem');
 Route::delete('/deleteitem/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('deleteitem');
 Route::get('/masterstock', [App\Http\Controllers\ItemController::class, 'showMasterStock'])->name('masterstock');

 //Customer
 Route::get('/allcustomer', [App\Http\Controllers\CustomerController::class, 'index'])->name('allcustomer');
 Route::get('/createcustomer', [App\Http\Controllers\CustomerController::class, 'create'])->name('createcustomer');
 Route::post('/insertcustomer', [App\Http\Controllers\CustomerController::class, 'store'])->name('insertcustomer');
 Route::get('/editcustomer/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('editcustomer');
 Route::get('/showcustomer/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('showcustomer');
 Route::put('/updatecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('updatecustomer');
 Route::delete('/deletecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('deletecustomer');


 //Customer

Route::get('/homepage', [App\Http\Controllers\POSController::class, 'showHomepage'])->name('pos.homepage');


// OrderRequest module
Route::get('/allorderrequests', [App\Http\Controllers\RequestOrderContraller::class, 'index'])->name('allorderrequests');
Route::get('/createorderrequests', [App\Http\Controllers\RequestOrderContraller::class, 'create'])->name('orderrequests.create');
Route::post('/insertorderrequests', [App\Http\Controllers\RequestOrderContraller::class, 'store'])->name('orderrequests.store'); 
Route::get('/showorderrequests/{id}', [App\Http\Controllers\RequestOrderContraller::class, 'show'])->name('orderrequests.show');
Route::get('/editorderrequests/{id}/edit', [App\Http\Controllers\RequestOrderContraller::class, 'edit'])->name('orderrequests.edit');
Route::put('/updateorderrequests/{id}', [App\Http\Controllers\RequestOrderContraller::class, 'update'])->name('orderrequests.update');
Route::delete('/deleteorderrequests/{id}', [App\Http\Controllers\RequestOrderContraller::class, 'destroy'])->name('orderrequests.destroy');

// API Routes for fetching items and stock
Route::get('/api/get-items/{supplierCode}', [App\Http\Controllers\RequestOrderContraller::class, 'getItemsBySupplier']);
Route::get('/api/get-item-stock/{itemCode}', [App\Http\Controllers\RequestOrderContraller::class, 'getItemStock']);


// OrderRequest module
Route::get('/allgins', [App\Http\Controllers\GinController::class, 'index'])->name('allgins');
Route::get('/creategin', [App\Http\Controllers\GinController::class, 'create'])->name('creategin');
Route::post('/insertgin', [App\Http\Controllers\GinController::class, 'store'])->name('insertgin');
Route::get('/showogins/{id}', [App\Http\Controllers\GinController::class, 'show'])->name('showogins');
Route::get('/editgins/{id}/edit', [App\Http\Controllers\GinController::class, 'edit'])->name('editgins');
Route::put('/updategins/{id}', [App\Http\Controllers\GinController::class, 'update'])->name('updategins');
Route::delete('/deletegins/{id}', [App\Http\Controllers\GinController::class, 'destroy'])->name('deletegins');

// routes/web.php
Route::get('/api/get-order-items/{orderRequestCode}', [GinController::class, 'getOrderItems']);


//Settings module
//company details
Route::get('company-settings', [CompanySettingController::class, 'index'])->name('company.index');
Route::post('company-settings', [CompanySettingController::class, 'store'])->name('company.store');

//users
Route::resource('users', UserController::class);
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::post('/users/add-user', [UserController::class, 'store'])->name('user.store');
Route::post('/users/user-list', [UserController::class, 'show'])->name('user.show');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/editUser/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/updateUser/{id}', [UserController::class, 'update'])->name('updateUser');

//roles
Route::view('/add_role', 'setting.roles.add_roles')->name('add_roles');
Route::view('/role_list', 'setting.roles.role_list')->name('role_list');
Route::view('/role_edit', 'setting.roles.role_edit')->name('role_edit');
Route::get('/assign_user_role', [RoleController::class, 'showUsers'])->name('assign_user_role');


//HRmodule
//attendance
Route::resource('attendance', AttendanceController::class);
Route::get('/attendance-list', [AttendanceController::class, 'show'])->name('show.employees');
Route::get('/hrm/attendance_list', [AttendanceController::class, 'show'])->name('attendance_list');
Route::get('/hrm/manage_attendance_list', [AttendanceController::class, 'manageAttendance'])->name('manage_attendance_list');
Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.check-out');
Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
Route::post('/attendance/{id}/update', [AttendanceController::class, 'update'])->name('attendance.update');
Route::view('/hrm/update_attendance', 'humanResources.attendance.update_attendance')->name('update_attendance');
Route::get('/hrm/attendance_reports', [AttendanceController::class, 'attendanceReport'])->name('attendance_reports');

//Leave
Route::resource('leave', LeaveController::class);
Route::post('/leave/update', [LeaveController::class, 'update'])->name('leave.update');
Route::get('/hrm/weekly_holidays', [LeaveController::class, 'show'])->name('weekly_holiday');
Route::get('/hrm/holiday', [LeaveController::class, 'showHolidays'])->name('holiday');
Route::get('/hrm/manage_holiday', [LeaveController::class, 'manageHolidays'])->name('manage_holiday');
Route::post('/holiday/store', [LeaveController::class, 'storeHolidays'])->name('holiday.store');
Route::delete('/holiday/{holiday}', [LeaveController::class, 'destroy'])->name('holiday.destroy');
Route::view('/hrm/weekly_holidays_update', 'humanResources.leave.weekly_holiday_update')->name('weekly_holiday_update');
Route::get('/holiday/{id}/edit', [LeaveController::class, 'edit'])->name('holiday.edit');
Route::post('/holiday/{id}/update', [LeaveController::class, 'updateHoliday'])->name('update_holiday');
Route::get('/hrm/add_leave_type', [LeaveController::class, 'showLeavetypes'])->name('add_leave_type');
Route::post('/hrm/add_leave_type/store', [LeaveController::class, 'storeLeavetypes'])->name('Leave_type.store');
Route::delete('/hrm/add_leave_type/{leave_type}', [LeaveController::class, 'destroyLeave_type'])->name('leave_type.destroy');
Route::post('/hrm/add_leave_type/{id}/update', [LeaveController::class, 'updateLeavetype'])->name('update_leave_type');
Route::get('/hrm/add_leave_type/{id}/edit', [LeaveController::class, 'editLeavetype'])->name('leave_type.edit');

Route::view('/hrm/leave_application', 'humanResources.leave.leave_application')->name('leave_application');



//employee module
Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee');
Route::get('/createemployee', [App\Http\Controllers\EmployeeController::class, 'create'])->name('createemployee');
Route::get('/editemployee/{id}', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('editemployee');
Route::post('/updateemployee',[App\Http\Controllers\EmployeeController::class, 'update'])->name('updateemployee');
Route::post('/storeemployee', [App\Http\Controllers\EmployeeController::class, 'store'])->name('storeemployee');
Route::delete('/deleteemployee/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('deleteemployee');
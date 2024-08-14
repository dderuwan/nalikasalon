<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AttendanceController;


//Route::get('/', function () {
//    return view('dashboard.index');
//});

Auth::routes();

 Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('/');

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
 Route::post('/insertcustomer', [App\Http\Controllers\CustomerController::class, 'insertcustomer'])->name('insertcustomer');
 Route::get('/editcustomer/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('editcustomer');
 Route::get('/showcustomer/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('showcustomer');
 Route::put('/updatecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('updatecustomer');
 Route::delete('/deletecustomer/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('deletecustomer');


 //POS
 Route::get('/pospage', [App\Http\Controllers\POSController::class, 'showHomepage'])->name('pospage');
 Route::post('/POS.store', [App\Http\Controllers\POSController::class, 'store'])->name('POS.store');
 Route::post('/POS.customerstore', [App\Http\Controllers\POSController::class, 'customerstore'])->name('POS.customerstore');
 Route::get('/showpos/{id}', [App\Http\Controllers\POSController::class, 'show'])->name('showopos');
 Route::delete('/deletepos/{id}', [App\Http\Controllers\POSController::class, 'destroy'])->name('deletepos');
 Route::get('/pos/print-and-redirect/{id}', [App\Http\Controllers\POSController::class, 'printRedirect'])->name('printRedirect');


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


// GIN
Route::get('/allgins', [App\Http\Controllers\GinController::class, 'index'])->name('allgins');
Route::get('/creategin', [App\Http\Controllers\GinController::class, 'create'])->name('creategin');
Route::post('/insertgin', [App\Http\Controllers\GinController::class, 'store'])->name('insertgin');
Route::get('/showogins/{id}', [App\Http\Controllers\GinController::class, 'show'])->name('showogins');
Route::get('/editgins/{id}/edit', [App\Http\Controllers\GinController::class, 'edit'])->name('editgins');
Route::put('/updategins/{id}', [App\Http\Controllers\GinController::class, 'update'])->name('updategins');
Route::delete('/deletegins/{id}', [App\Http\Controllers\GinController::class, 'destroy'])->name('deletegins');

// routes/web.php
Route::get('/api/get-order-items/{orderRequestCode}', [GinController::class, 'getOrderItems']);



//reports
Route::get('/orderreport', [App\Http\Controllers\reportController::class, 'orderreport'])->name('orderreport');
Route::get('/productreport', [App\Http\Controllers\reportController::class, 'productreport'])->name('productreport');
Route::get('/customerreport', [App\Http\Controllers\reportController::class, 'customerreport'])->name('customerreport');
Route::get('/supplierreport', [App\Http\Controllers\reportController::class, 'supplierreport'])->name('supplierreport');
Route::get('/ginreport', [App\Http\Controllers\reportController::class, 'ginreport'])->name('ginreport');
Route::get('/ginshow/{id}', [App\Http\Controllers\reportController::class, 'ginshow'])->name('ginshow');
Route::get('/purchaseorderreport', [App\Http\Controllers\reportController::class, 'purchaseorderreport'])->name('purchaseorderreport');
Route::get('/purchaseordershow/{id}', [App\Http\Controllers\reportController::class, 'purchaseordershow'])->name('purchaseordershow');
Route::get('orderreport/print/{id}', [App\Http\Controllers\reportController::class, 'printOrderReport'])->name('orderreport.print');
Route::delete('/deleteorderreport/{id}', [App\Http\Controllers\reportController::class, 'destroy'])->name('orderreport.destroy');
Route::delete('/customerdestroy/{id}', [App\Http\Controllers\reportController::class, 'customerdestroy'])->name('customerdestroy');
Route::delete('/supplierdestroy/{id}',[App\Http\Controllers\reportController::class,'supplierdestroy'])->name('supplierdestroy');
Route::delete('/gindestroy/{id}', [App\Http\Controllers\reportController::class, 'gindestroy'])->name('gindestroy');
Route::delete('/purchaseorderdestroy/{id}', [App\Http\Controllers\reportController::class, 'purchaseorderdestroy'])->name('purchaseorderdestroy');


//services
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services');
Route::get('/addservice', [App\Http\Controllers\ServiceController::class, 'create'])->name('addservice');
Route::post('/services/store', [App\Http\Controllers\ServiceController::class, 'store'])->name('storeservices');
Route::get('/showservices/{id}', [App\Http\Controllers\ServiceController::class, 'show'])->name('showservices');
Route::delete('/deleteservices/{id}', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('deleteservices');
Route::get('/services/{id}', [App\Http\Controllers\ServiceController::class, 'edit'])->name('editservices');
Route::put('/services/{id}', [App\Http\Controllers\ServiceController::class, 'update'])->name('updateservices');

//packages
Route::get('/packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages');
Route::get('/addpackages', [App\Http\Controllers\PackageController::class, 'create'])->name('addpackages');
Route::post('/packages/store', [App\Http\Controllers\PackageController::class, 'storepackages'])->name('storepackages');
Route::delete('/packages/{id}', [App\Http\Controllers\PackageController::class, 'destroy'])->name('deletepackages');
Route::get('/packages/{id}/edit', [App\Http\Controllers\PackageController::class, 'edit'])->name('editpackage');
Route::put('/packages/{id}', [App\Http\Controllers\PackageController::class, 'update'])->name('updatepackage');


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
Route::get('/addRole', [RoleController::class, 'addRole'])->name('addRole');
Route::post('/storeRole', [RoleController::class, 'storeRole'])->name('storeRole');
Route::get('/showRole', [RoleController::class, 'showRole'])->name('showRole');
Route::get('/editRole/{id}', [RoleController::class, 'editRole'])->name('editRole');
Route::put('/updateRole/{id}', [RoleController::class, 'updateRole'])->name('updateRole');
Route::delete('/deleteRole/{id}', [RoleController::class, 'deleteRole'])->name('deleteRole');
Route::get('/assign_user_role', [RoleController::class, 'showUsers'])->name('assign_user_role');
Route::get('/addPermission', [RoleController::class, 'addPermission'])->name('addPermission');
Route::post('/storePermission', [RoleController::class, 'storePermission'])->name('storePermission');
Route::get('/showPermission', [RoleController::class, 'showPermission'])->name('showPermission');
Route::delete('/permissions/{id}', [RoleController::class, 'deletePermission'])->name('deletePermission');
Route::post('/assignRole', [RoleController::class, 'assignRole'])->name('assignRole');

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

Route::post('/hrm/leave_application/store', [LeaveController::class, 'storeleavApp'])->name('leave.store');
Route::get('/hrm/leave_application/apply', [LeaveController::class, 'createLeaveApp'])->name('apply_leave');
Route::get('/hrm/leave_application', [LeaveController::class, 'showLeaveApp'])->name('leave_application');
Route::get('/hrm/leave_application/manage', [LeaveController::class, 'manageLeaveApp'])->name('manage_leave_application');
Route::delete('/hrm/leave_application/{leave_application}', [LeaveController::class, 'destroyLeaveapp'])->name('leave_application.destroy');
Route::get('/hrm/leave-applications/edit/{id}', [LeaveController::class, 'editLeaveApp'])->name('leave_app_edit');
Route::put('/hrm/leave-applications/update/{id}', [LeaveController::class, 'updateLeaveApp'])->name('leave_app_update');

//employee module
Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee');
Route::get('/createemployee', [App\Http\Controllers\EmployeeController::class, 'create'])->name('createemployee');
Route::get('/editemployee/{id}', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('editemployee');
Route::post('/updateemployee',[App\Http\Controllers\EmployeeController::class, 'update'])->name('updateemployee');
Route::post('/storeemployee', [App\Http\Controllers\EmployeeController::class, 'store'])->name('storeemployee');
Route::delete('/deleteemployee/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('deleteemployee');


//appointment module(PreOrders)
Route::get('/appointments', [AppointmentController::class, 'showAppoinmentsss'])->name('appointments');
Route::get('/showPreOrders', [AppointmentController::class, 'showPreOrders'])->name('showPreOrders');
Route::get('/Appointments/New-appointment', [AppointmentController::class, 'showCustomers'])->name('new_appointment');
Route::get('/Appointments/New-appointment/customers/{customer_code}', [AppointmentController::class, 'getCustomerDetails']);
Route::post('/Appointments/New-appointment/store', [AppointmentController::class, 'storeAppointments'])->name('appointment.store');
Route::get('/get-packages-by-service', [AppointmentController::class, 'getPackagesByService'])->name('getPackagesByService');
Route::get('/appointment/print-and-redirect/{id}', [AppointmentController::class, 'printAndRedirect'])->name('printAndRedirect');
Route::get('/appointments/getPreorders', [AppointmentController::class, 'getPreorders'])->name('appointments.getPreorders');
Route::post('/POS.customerstore', [App\Http\Controllers\AppointmentController::class, 'customerstore'])->name('POS.customerstore');
Route::get('/showPreOrderDetails/{id}', [App\Http\Controllers\AppointmentController::class, 'showPreOrderDetails'])->name('showPreOrderDetails');


//RealTimeAppoinments
Route::get('/RealTimepage1', [App\Http\Controllers\ReaTimeAppoinmentConttroller::class, 'RealTimepage1'])->name('RealTimepage1');
Route::get('/get-appointments', [App\Http\Controllers\ReaTimeAppoinmentConttroller::class, 'getAppointmentsByCustomer'])->name('getAppointmentsByCustomer');
Route::get('/Appointments/realtime2page', [App\Http\Controllers\ReaTimeAppoinmentConttroller::class, 'realtime2page'])->name('realtime2page');
Route::post('/Appointments/New-appointment/storerealtime2', [App\Http\Controllers\ReaTimeAppoinmentConttroller::class, 'storerealtime2'])->name('storerealtime2');

// web.php or api.php (depending on your routes file)
Route::get('/get-available-time-slots', [AppointmentController::class, 'getAvailableTimeSlots']);
Route::get('/get-available-main-dressers', [AppointmentController::class, 'getAvailableMainDressers']);
Route::get('/get-available-assistants', [AppointmentController::class, 'getAvailableAssistants']);
Route::get('/get-available-time', [ReaTimeAppoinmentConttroller::class, 'getAvailableTime']);




//revenue
Route::get('/monthly-revenue', [RevenueController::class, 'index'])->name('monthly-revenue');
Route::get('/api/monthly-revenue', [RevenueController::class, 'getMonthlyRevenue']);
Route::get('/api/daily-revenue-column-chart', [RevenueController::class, 'getDailyRevenueForColumnChart']);

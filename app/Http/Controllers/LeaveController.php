<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyHoliday;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Leave_type;
use App\Models\Leave_Apply;

class LeaveController extends Controller
{

    //weekly holiday
    public function show()
    {
        $weeklyHoliday = WeeklyHoliday::all();
        return view('humanResources.leave.weekly_holiday', compact('weeklyHoliday'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'weekly_leave' => 'required|array',
            'weekly_leave.*' => 'in:Friday,Saturday,Sunday',
        ]);

        $selected_days = implode(', ', $request->input('weekly_leave'));
        WeeklyHoliday::updateOrCreate(
            ['id' => 1], 
            ['dayname' => $selected_days]
        );
        return redirect()->route('weekly_holiday')->with('success', 'Weekly leave days updated successfully');
    }



    //holiday
    public function storeHolidays(Request $request)
    {
        $request->validate([
            'holiday_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'number_of_days' => 'required|integer|min:1',
        ]);
        Holiday::create([
            'holiday_name' => $request->holiday_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'no_of_days' => $request->number_of_days,
        ]);
        return redirect()->back()->with('success', 'Holiday added successfully.');
    }


    public function showHolidays()
    {
        $holiday_list = Holiday::all();
        return view('humanResources.leave.holiday', compact('holiday_list'));
    }


    public function manageHolidays()
    {
        $holiday_list = Holiday::all();
         return view('humanResources.leave.manage_holiday', compact('holiday_list'));
    }


    public function destroy($id)
    {
        $holiday = Holiday::find($id);
        if ($holiday) {
            $holiday->delete();
            return redirect()->route('manage_holiday')->with('success', 'Deleted successfully');
        } else {
            return redirect()->route('manage_holiday')->with('error', 'not found.');
        }
    }


    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);
        return view('humanResources.leave.update_holiday', compact('holiday'));
    }

    public function updateHoliday(Request $request, $id)
    {
        $request->validate([
            'holiday_name' => 'required|string|max:255',
            'datefrom' => 'required|date',
            'dateto' => 'required|date',
            'number_of_days' => 'required|integer',
        ]);

        $holiday = Holiday::findOrFail($id);
        $holiday->holiday_name = $request->input('holiday_name');
        $holiday->start_date = $request->input('datefrom');
        $holiday->end_date = $request->input('dateto');
        $holiday->no_of_days = $request->input('number_of_days');
        $holiday->save();

        return redirect()->route('holiday')->with('success', 'Holiday updated successfully.');

    }



    //leave types
    public function showLeavetypes()
    {
        $leave_types = Leave_type::all();
        return view('humanResources.leave.add_leave_type', compact('leave_types'));
    }


    public function storeLeavetypes(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string|max:255',
            'leave_days' => 'required|integer|min:1',
        ]);

        Leave_type::create([
            'leave_type' => $request->leave_type,
            'leave_days' => $request->leave_days,
        ]);

        return redirect()->back()->with('success', 'Leave type added successfully.');
    }


    public function destroyLeave_type($id)
    {
        $leave_type = Leave_type::find($id);
        if ($leave_type) {
            $leave_type->delete();
            return redirect()->route('add_leave_type')->with('success', 'Deleted successfully');
        } else {
            return redirect()->route('add_leave_type')->with('error', 'not found.');
        }
    }


    public function editLeavetype($id)
    {
        $leave_type = Leave_type::findOrFail($id);
        return view('humanResources.leave.update_leaveType', compact('leave_type'));
    }

    
    public function updateLeavetype(Request $request, $id)
    {
        $request->validate([
            'leave_type' => 'required|string|max:255',
            'leave_days' => 'required|integer',
        ]);

        $leave_type = Leave_type::findOrFail($id);
        $leave_type->leave_type = $request->input('leave_type');
        $leave_type->leave_days = $request->input('leave_days');
        $leave_type->save();

        return redirect()->route('add_leave_type')->with('success', 'leave type updated successfully');
    }



    //leave application
    public function createLeaveApp()
    {
        $employees = Employee::all();
        $leaveTypes = Leave_type::all();
        return view('humanResources.leave.apply_leave', compact('employees', 'leaveTypes'));
    }


    public function storeleavApp(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'leave_type_id' => 'required',          
            'apply_strt_date' => 'required|date',
            'apply_end_date' => 'required|date|after_or_equal:apply_strt_date',
            'apply_day' => 'required|integer',
            'apply_hard_copy' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'leave_aprv_strt_date' => 'nullable|date',
            'leave_aprv_end_date' => 'nullable|date|after_or_equal:leave_aprv_strt_date',
            'num_aprv_day' => 'nullable|integer',
            'approved_by' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255',
        ]);
    
        $data = $request->only([
            'employee_id',
            'leave_type_id',
            'apply_strt_date',
            'apply_end_date',
            'apply_day',
            'leave_aprv_strt_date',
            'leave_aprv_end_date',
            'num_aprv_day',
            'approved_by',
            'reason'
        ]);
    
        if ($request->hasFile('apply_hard_copy')) {
            $file = $request->file('apply_hard_copy');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $data['apply_hard_copy'] = '/storage/' . $filePath;
        }
    
        $data['apply_date'] = $request->input('date', now()->toDateString());
    
        Leave_Apply::create($data);
    
        return redirect()->route('leave_application')->with('success', 'Leave applied successfully');
    
    }


    public function showLeaveApp()
    {
        $leave_applications = Leave_Apply::with('employee', 'leaveType')->get();
        $employees = Employee::all();
        $leaveTypes = Leave_type::all();
        return view('humanResources.leave.leave_application', compact('employees', 'leaveTypes', 'leave_applications'));
    }

    public function manageLeaveApp()
    {
        $leave_applications = Leave_Apply::with('employee', 'leaveType')->get();
        $employees = Employee::all();
        $leaveTypes = Leave_type::all();
        return view('humanResources.leave.manage_leave_application', compact('employees', 'leaveTypes', 'leave_applications'));
    }

    public function destroyLeaveapp($id)
    {
        $leave_applications = Leave_Apply::find($id);
        if ($leave_applications) {
            $leave_applications->delete();
            return redirect()->route('manage_leave_application')->with('success', 'Deleted successfully');
        } else {
            return redirect()->route('manage_leave_application')->with('error', 'not found.');
        }
    }
    

   public function editLeaveApp($id)
{
    $leave_applications = Leave_Apply::findOrFail($id);
    $employees = Employee::all();
    $leaveTypes = Leave_Type::all();

    return view('humanResources.leave.leave_app_update', compact('leave_applications', 'employees', 'leaveTypes'));
}

public function updateLeaveApp(Request $request, $id)
{
    $request->validate([
        'employee_id' => 'required|exists:employee,id',
        'leave_type_id' => 'required|exists:leave_type,id',
        'apply_strt_date' => 'required|date',
        'apply_end_date' => 'required|date',
        'apply_hard_copy' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:2048',
        'leave_aprv_strt_date' => 'nullable|date',
        'leave_aprv_end_date' => 'nullable|date',
        'approved_by' => 'nullable|string|max:255',
        'reason' => 'nullable|string|max:255',
    ]);

    $leave_applications = Leave_Apply::findOrFail($id);
    $leave_applications->employee_id = $request->input('employee_id');
    $leave_applications->leave_type_id = $request->input('leave_type_id');
    $leave_applications->apply_strt_date = $request->input('apply_strt_date');
    $leave_applications->apply_end_date = $request->input('apply_end_date');
    $leave_applications->leave_aprv_strt_date = $request->input('leave_aprv_strt_date');
    $leave_applications->leave_aprv_end_date = $request->input('leave_aprv_end_date');
    $leave_applications->approved_by = $request->input('approved_by');
    $leave_applications->reason = $request->input('reason');

    if ($request->hasFile('apply_hard_copy')) {
        $path = $request->file('apply_hard_copy')->store('leave_applications', 'public');
        $leave_applications->apply_hard_copy = $path;
    }

    $leave_applications->save();

    return redirect()->route('manage_leave_application')->with('success', 'Leave application updated successfully');
}
}



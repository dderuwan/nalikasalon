<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyHoliday;
use App\Models\Holiday;
use App\Models\Leave_type;

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
}



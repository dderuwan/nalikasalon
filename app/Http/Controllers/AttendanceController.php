<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function show()
    {
        $attendance_list = Attendance::with('employee')->get();
        $employees = Employee::all();
        return view('humanResources.attendance.attendance_list', compact('attendance_list', 'employees'));
    }


    public function manageAttendance()
    {
        $attendance_list = Attendance::with('employee')->get();
        $employees = Employee::all();
        return view('humanResources.attendance.manage_attendance_list', compact('attendance_list', 'employees'));
    }

    public function attendanceReport()
    {
        $attendance_list = Attendance::with('employee')->get();
        $employees = Employee::all();
        return view('humanResources.attendance.attendance_reports', compact('attendance_list', 'employees'));
    }


    public function edit($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        $employees = Employee::all();
        return view('humanResources.attendance.update_attendance', compact('attendance', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'emp_id' => 'required',
            'date' => 'required|date',
            'checkin' => 'nullable',
            'checkout' => 'nullable',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->emp_id = $request->input('emp_id');
        $attendance->date = $request->input('date');
        $attendance->sign_in = $request->input('checkin');
        $attendance->sign_out = $request->input('checkout');

        // Calculate stayed time
        if ($request->input('checkin') && $request->input('checkout')) {
            $checkin = Carbon::createFromFormat('h:i:s A', $request->input('checkin'));
            $checkout = Carbon::createFromFormat('h:i:s A', $request->input('checkout'));
            $stayedTime = $checkout->diff($checkin)->format('%H:%I:%S');
            $attendance->stayed_time = $stayedTime;
        } else {
            $attendance->stayed_time = null;
        }

        $attendance->save();

        return redirect()->route('attendance_list')->with('success', 'Attendance updated successfully');
        return redirect()->route('attendance_list');
    }

        
    

    public function checkIn(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|exists:employee,id',
        ]);
    
        $attendance = new Attendance();
        $attendance->emp_id = $request->input('emp_id');
        $attendance->date = $request->input('date', now()->toDateString());       
        $attendance->sign_in = $request->input('sign_in', now()->format('h:i:s A'));      
        $attendance->save();
    
        return redirect()->back()->with('success', 'Check-in recorded successfully');
    }

    
    

    public function checkOut(Request $request)
    {
        try {
            $request->validate([
                'attendance_id' => 'required|exists:emp_attendance,id',
                'sign_out' => 'required',
            ]);

            $attendance = Attendance::find($request->input('attendance_id'));
            $attendance->sign_out = $request->input('sign_out');
            
            if ($attendance->sign_in && $attendance->sign_out) {
                $signIn = \Carbon\Carbon::parse($attendance->sign_in);
                $signOut = \Carbon\Carbon::parse($attendance->sign_out);
                $attendance->stayed_time = $signIn->diff($signOut)->format('%H:%I:%S');
            }
            
            $attendance->save();
            return response()->json([
                'message' => 'Check-out recorded successfully.',
                'attendance' => $attendance
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error recording check-out.'], 500);
        }
    }

    
    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        if ($attendance) {
            $attendance->delete();
            return redirect()->route('manage_attendance_list')->with('success', 'deleted successfully');
        } else {
            return redirect()->route('manage_attendance_list')->with('error', 'not found.');
        }
    }


    


}

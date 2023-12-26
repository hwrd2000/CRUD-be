<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();

        if($employees->count() > 0){
            return response()->json([
                'status' => 200,
                'employees' => $employees
            ], 200);
        }else{
        return response()->json([
            'status' => 404,
            'message' => 'No employee record found'
        ], 404);
    }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11',
            'address' => 'required|string|max:191',
            'department_id' => 'required|exists:departments,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $employees = $request->all();

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('employee_photos', 'public');
                $employees['photo'] = $photoPath;
            }

            $employees = Employee::create($employees);

            if($employees){
                return response()->json([
                    'status' => 200,
                    'message' => "Employee created successfully"
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong"
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $employees = Employee::with('departments')->find($id);

        if($employees){

            $department = $employees->department;

            return response()->json([
                'status' => 200,
                'message' => $employees,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such employee found"
            ], 404);
        }
    }

    public function edit($id)
    {
        $employees = Employee::find($id);
        if($employees){
            return response()->json([
                'status' => 200,
                'employees' => $employees
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such employee found"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:191',
        'email' => 'required|email|max:191',
        'phone' => 'required|digits:11',
        'address' => 'required|string|max:191',
        'department_id' => 'required|exists:departments,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    }

    $employees = Employee::find($id);

    if (!$employees) {
        return response()->json([
            'status' => 404,
            'message' => "No such employee found"
        ], 404);
    }

    if ($request->hasFile('photo')) {
        // Handle file upload
        $photoPath = $request->file('photo')->store('employee_photos', 'public');
        $employees->photo = $photoPath;
    }
    
    $employees->name = $request->name;
    $employees->email = $request->email;
    $employees->phone = $request->phone;
    $employees->address = $request->address;
    $employees->department_id = $request->department_id;
    
    if ($employees->save()) {
        return response()->json([
            'status' => 200,
            'message' => "Employee updated successfully"
        ], 200);
    } else {
        return response()->json([
            'status' => 500,
            'message' => "Failed to update employee"
        ], 500);
    }
}

    public function destroy($id)
    {
        $employees = Employee::find($id);
        if($employees){

            $employees->delete();

            DB::statement('ALTER TABLE employees AUTO_INCREMENT = 0');

            return response()->json([
                'status' => 200,
                'message' => "Employee deleted successfully"
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such employee found"
            ], 404);
        }
    }
}

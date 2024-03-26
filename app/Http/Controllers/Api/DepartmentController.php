<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        if($departments->count() > 0){
            return response()->json([
                'status' => 200,
                'departments' => $departments
            ], 200);
        }else{
        return response()->json([
            'status' => 404,
            'message' => 'No department record found'
        ], 404);
    }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department' => 'required|string|max:190',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $department = Department::create([
                'department' => $request->department,
            ]);

            if($department){
                return response()->json([
                    'status' => 200,
                    'message' => "Department created successfully"
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
        $departments = Department::with('employees')->find($id);

        if($departments){
            return response()->json([
                'status' => 200,
                'message' => $departments,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such department found"
            ], 404);
        }
    }

    public function edit($id)
    {
        $departments = Department::find($id);
        if($departments){
            return response()->json([
                'status' => 200,
                'departments' => $departments
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such department found"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'department' => 'required|string|max:191',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $department = Department::find($id);

            if($department){

                $department->update([
                    'department' => $request->department,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Department updated successfully"
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => "No such department found"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $departments = Department::find($id);
        if($departments){

            $departments->delete();

            DB::statement('ALTER TABLE departments AUTO_INCREMENT = 0');

            return response()->json([
                'status' => 200,
                'message' => "Department deleted successfully"
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such department found"
            ], 404);
        }
    }
}

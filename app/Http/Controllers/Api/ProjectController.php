<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        if ($projects->count() > 0) {
            return response()->json([
                'status' => 200,
                'projects' => $projects
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No project record founddddd'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required|string|max:191',
            'project_description' => 'required|string|max:191',
            'project_status' => 'required|string|max:191',
            'employee_ids' => 'required|array|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            // $project = Project::create([
            //     'project_title' => $request->project_title,
            //     'project_description' => $request->project_description,
            //     'project_status' => $request->project_status,
            // ]);

            $projects = Project::create($request->all());
    
            $projects->employees()->attach($request->employee_ids); 
    
            if ($projects) {
                return response()->json([
                    'status' => 200,
                    'message' => "Project created successfully"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong"
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $projects = Project::with('employees')->find($id);
    
        if ($projects) {
            return response()->json([
                'status' => 200,
                'projects' => $projects,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No such project found",
            ], 404);
        }
    }

    public function edit($id)
    {
        $projects = Project::find($id);
        if($projects){
            return response()->json([
                'status' => 200,
                'message' => $projects
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such project found"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'employee_ids' => 'required|array|exists:employees,id',
            'project_title' => 'required|string|max:191',
            'project_description' => 'required|string|max:191',
            'project_status' => 'required|string|max:191',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $projects = Project::find($id);

            if($projects){

                $projects->update([
                    'project_title' => $request->project_title,
                    'project_description' => $request->project_description,
                    'project_status' => $request->project_status,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Project updated successfully"
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => "No such project found"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $projects = Project::find($id);
        if($projects){

            $projects->delete();

            DB::statement('ALTER TABLE projects AUTO_INCREMENT = 0');

            return response()->json([
                'status' => 200,
                'message' => "Project deleted successfully"
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No such project found"
            ], 404);
        }
    }
}

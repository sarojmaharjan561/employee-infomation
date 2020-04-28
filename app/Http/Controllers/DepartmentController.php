<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department_list = DB::SELECT("SELECT id,name FROM departments ORDER BY id DESC");
        
        $department_list = collect($department_list); 
        
        return Datatables::of($department_list)
        ->addColumn('action',function ($department_list)
      { 
        $buttons= '<a class="btn btn-primary btn-sm" href="/department/create/'.$department_list->id.'">Edit</a>&nbsp;<button type="button" class="deleteDepartment btn btn-danger btn-sm" title="Delete Department" data-id="'.$department_list->id.'">Delete</button>';
         return $buttons;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_name' => 'required'
        ]);

        $data = [
            'name' => $request->department_name
        ];

        Department::create($data);

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Added Department.",
            'error' => 0,
        ],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($department)
    {
        $department_info = Department::find($department);

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Fetch Department.",
            'department_info' => $department_info,
            'error' => 0,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $department)
    {
        $validatedData = $request->validate([
            'department_name' => 'required'
        ]);

        Department::where('id', $department)
          ->update(['name' => $request->department_name]);

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Updated Department.",
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($department)
    {
        Department::where('id', $department)->delete();

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Deleted Department.",
            'error' => 0,
        ]);
    }

    public function departmentList()
    {
        $department_list = DB::SELECT("SELECT id,name FROM departments");

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Fetch Department.",
            'department_list' => $department_list,
            'error' => 0,
        ]);
    }
}

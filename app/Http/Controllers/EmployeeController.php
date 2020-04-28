<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee_list = DB::SELECT("SELECT
                                        e.id,
                                        e.name ,
                                        e.email ,
                                        e.joined_date ,
                                        d.name as department
                                    FROM
                                        employees e
                                    INNER JOIN 
                                        departments d ON e.department_id = d.id 
                                    ORDER BY 
                                        e.id DESC
                                    ");
        
        $employee_list = collect($employee_list); 
        
        return Datatables::of($employee_list)
            ->addColumn('action',function ($employee_list)
        { 
            $buttons= '<a class="btn btn-primary btn-sm" href="/employee/create/'.$employee_list->id.'">Edit</a>&nbsp;<button type="button" class="deleteEmployee btn btn-danger btn-sm" title="Delete Employee" data-id="'.$employee_list->id.'">Delete</button>';
            return $buttons;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'employee_name' => 'required',
            'employee_email' => 'required',
            'employee_department' => 'required',
            'employee_joined_date' => 'required',
        ]);

        $data = [
            'name' => $request->employee_name,
            'email' => $request->employee_email,
            'department_id' => $request->employee_department,
            'joined_date' => $request->employee_joined_date
        ];

        Employee::create($data);

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Added Employee.",
            'error' => 0,
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($employee)
    {
        $employee_info = Employee::find($employee);

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Fetch Employee.",
            'employee_info' => $employee_info,
            'error' => 0,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required',
            'employee_email' => 'required',
            'employee_department' => 'required',
            'employee_joined_date' => 'required',
        ]);

        $data = [
            'name' => $request->employee_name,
            'email' => $request->employee_email,
            'department_id' => $request->employee_department,
            'joined_date' => $request->employee_joined_date
        ];

        Employee::where('id', $employee)
          ->update([
                    'name' => $request->employee_name,
                    'email' => $request->employee_email,
                    'joined_date' => $request->employee_joined_date,
                    'department_id' => $request->employee_department
                    ]);

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Updated Employee.",
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee)
    {
        Employee::where('id', $employee)->delete();

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Deleted Employee.",
            'error' => 0,
        ]);
    }

    public function checkEmail(Request $request)
    {
        $check_email = Employee::where('email', $request->employee_email)
                                ->where('id','<>', $request->id)
                                ->get()
                                ->toArray();

        if(count($check_email) > 0){
            $email_exist = 1;
        }else{
            $email_exist = 0;            
        }

        return response()->json([
            'status' => 'ok',
            'message' => "Successfully Checked.",
            'email_exist' => $email_exist,
            'error' => 0,
        ]);
    }
}

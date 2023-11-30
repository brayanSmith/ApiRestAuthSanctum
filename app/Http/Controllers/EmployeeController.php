<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Departament;
use DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //me va a traer los registros en una paginacion de 10
        $employees = Employee::select('employees.*'
        ,'departaments.name as departament')
        ->join('departaments','departaments.id','=','employees.departament_id')
        ->paginate(10);
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules =[
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
            'departament_id' => 'required|numeric'
        ];

        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $employee = new Employee($request->input());
        $employee->save();
        return response()->json([
            'status' => true,
            'message' => 'Employe created succefully'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
        return response()->json(['status' => true, 'data' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
        $rules =[
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
            'departament_id' =>'required|numeric'
        ];

        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $employee->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Employee updated succefully'
        ],200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
        $employee->delete();
        return response()->json([
            'status' => true,
            'message' => 'Employee deleted succefully'
        ],200);
    }
    //crearemos la funcion de empleados por departamento va a mostrar cuantos empleados hay
    public function EmployeesByDepartament(){
        $employees = Employee::select(DB::raw('count(employees.id) as count',
        'departaments.name'))
        ->join('departaments', 'departaments.id','=','employees.departament_id')
        ->groupBy('departaments.name')->get();
        return response()->json($employees);
    }
    public function all(){
        $employees = Employee::select('employees.*'
        ,'departaments.name as departament')
        ->join('departaments','departaments.id','=','employees.departament_id')
        ->get();
        return response()->json($employees);
    }
}

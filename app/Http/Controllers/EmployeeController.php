<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    
    public function index()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'department_id', 'departments.name as department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->paginate(10);

        $departments = Department::all();
        return Inertia::render('Employees/Index', [
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }

    
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric',
        ]);

        $employee = new Employee($request->input());
        $employee->save();
        return redirect('employees');
    }

   
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
            'department_id' => 'required|numeric',
        ]);
        $employee->update($request->input());
        return redirect('employees');

    }

   
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }


    public function EmployeeByDepartments(){
        $data = Employee::select(DB::raw('count(employees.id) as count', 'departments.name'))
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->groupBy('departments.name')->get();

        return Inertia::render('Employee/Graphic', ['data' => $data]);
    }

    public function reprots(){
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'department_id', 'departments.name as department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->get();

        $departments = Department::all();

        return Inertia::render('Employee/Reports', ['employees' => $employees, $departments => $departments]);
    }

}

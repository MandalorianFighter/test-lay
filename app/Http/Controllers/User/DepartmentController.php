<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\DepartmentsDataTable;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(DepartmentsDataTable $dataTable)
    {
        return $dataTable->render('users.departments');
    }

    public function dataDepartment(Request $request)
    {
        $model = Department::query();
 
        return app('datatables')->eloquent($model)
        ->editColumn('department_name', function ($model) {
            return '<a title="Follow The Link To Edit Department" href="/users/departments/edit/'.$model->id.'">'.$model->department_name.'</a>';
        })
        ->orderColumn('department_name', function ($query, $order) {
            $query->orderBy('department_name', $order);
        })
        ->editColumn('created_at', function ($model) {
            return [
               'display' => $model->created_at->diffForHumans(),
               'timestamp' => $model->created_at->timestamp
            ];
         })
        ->addIndexColumn()
        ->addColumn('action', function ($model) {
            return view('users.departments.delete', ['department' => $model]);
        })
        ->rawColumns(['department_name', 'action'])
        ->toJson();
    }

    public function add()
    {    
        return view('users.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|min:2|max:256',
            'department_details' => 'nullable|max:700'
        ]);

        Department::create([
            'department_name' => $request->department_name,
            'department_details' => $request->department_details
        ]);

        $notification = array(
            'message' => 'Department Is Created Successfully!',
            'alert-type' => 'success',
        );

        return Redirect()->route('user.departments')->with($notification);
    }

    public function edit(Department $department)
    {        
        return view('users.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => 'required|min:2|max:256',
            'department_details' => 'nullable|max:700'
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'department_details' => $request->department_details
        ]);

        $notification = array(
            'message' => 'Department Is Updated Successfully!',
            'alert-type' => 'success',
        );

        return Redirect()->route('user.departments')->with($notification);
    }

    public function delete(Department $department)
    {
        $department->delete();

        $notification = array(
            'message' => 'Department Is Deleted!',
            'alert-type' => 'warning',
        );

        return Redirect()->route('user.departments')->with($notification);
    }
}

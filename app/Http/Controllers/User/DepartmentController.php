<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{

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

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        
        return view('users.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|min:2|max:256',
            'department_details' => 'nullable|max:700'
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'department_name' => $request->department_name,
            'department_details' => $request->department_details
        ]);

        $notification = array(
            'message' => 'Department Is Updated Successfully!',
            'alert-type' => 'info',
        );

        return Redirect()->route('user.departments')->with($notification);
    }

    public function delete($id)
    {
        $department = Department::find($id);
        $department->delete();

        $notification = array(
            'message' => 'Department Is Deleted Successfully!',
            'alert-type' => 'warning',
        );

        return Redirect()->route('user.departments')->with($notification);
    }
}

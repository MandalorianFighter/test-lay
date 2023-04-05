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

        return Redirect()->route('user.departments');
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

        return Redirect()->route('user.departments');
    }

    public function delete(Department $department)
    {
        $department->delete();
        return Redirect()->back();
    }
}

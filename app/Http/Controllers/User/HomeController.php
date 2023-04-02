<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Tag;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employees = Employee::orderBy('id', 'asc')->paginate(100);

        return view('users.employees', compact('employees'));
    }

    /**
     * Show the application departments.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function departments()
    {
        $departments = Department::orderBy('id', 'asc')->paginate();

        return view('users.departments', compact('departments'));
    }

    /**
     * Show the application tagss.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tags()
    {
        $tags = Tag::orderBy('id', 'asc')->paginate();

        return view('users.tags', compact('tags'));
    }
}

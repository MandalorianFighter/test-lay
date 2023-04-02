<?php

namespace App\Http\Controllers\User;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use App\Models\Department;
use Image;

class EmployeeController extends Controller
{

    public function add()
    {   
        $departments = Department::select('id','department_name')->cursor();
        $tags = Tag::select('id','tag_name')->cursor();
        return view('users.employees.create', compact('departments', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|min:2|max:256',
            'age' => 'required',
            'department_id' => 'required',
            'position' => 'required',
            'employee_details' => 'required|max:700',
            'photo' => 'image|max:5120|mimes:jpg,png|dimensions:min_width=300,min_height=300',
            'tags.*' => 'nullable',
        ]);

        $employee = Employee::create($request->except(['photo']));
        $employee->photo = $this->storePhoto($request);
        $employee->save();

        $this->syncTag($employee, $request->tags);

        return Redirect()->route('user.employees');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::select('id','department_name')->cursor();
        
        return view('users.employees.edit', compact('employee','departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_name' => 'required|min:2|max:256',
            'age' => 'required',
            'department_id' => 'required',
            'position' => 'required',
            'employee_details' => 'required|max:700',
            'photo' => 'image|max:5120|mimes:jpg,png|dimensions:min_width=300,min_height=300',
            'tags.*' => 'nullable',
        ]);

        $employee = Employee::findOrFail($id);
        $old_image = basename($request->old_image);

        $employee->update($request->all());

        if($request->hasFile('photo')) {
            $employee->photo = $this->storePhoto($request);
            $employee->save();
        
            // if(file_exists($old_image)) unlink($old_image);
            if(Storage::disk('s3')->exists('images/'.$old_image)) Storage::disk('s3')->delete('images/'.$old_image);
        }

        $this->syncTag($employee, $request->tags);
        
        return Redirect()->route('user.employees');
    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        $old_image = basename($employee->photo);
        if(Storage::disk('s3')->exists('images/'.$old_image)) Storage::disk('s3')->delete('images/'.$old_image);
    
        $employee->delete();

        return Redirect()->route('user.employees');
    }

    public function searchD(Request $request)
    {
        $search = $request->q;
        $data = Department::select("id","department_name")->where('department_name', 'LIKE', "%$search%")->cursor();

        return response()->json($data);
    }

    public function getOption(Request $request)
    {   
        $newTag = Tag::firstOrCreate(['tag_name' => $request->option]);
        return response()->json($newTag);
    }

    public function searchT(Request $request)
    {
        $search = $request->q;
        $data = Tag::select("id","tag_name")->where('tag_name', 'LIKE', "%$search%")->cursor();

        return response()->json($data);
    }

    private function storePhoto(Request $request)
    {
        // $path = $request->file('photo')->store('images', 's3');
        // Storage::disk('s3')->setVisibility($path, 'public');
        // $url = Storage::disk('s3')->url($path);
            
        if(!$request->hasFile('photo')) {
            return;
        }
    
        $name = $request->file('photo')->hashname();
        $image = Image::make($request->file('photo'))->fit(300, 300)->stream('jpg', 90);
        $path = 'images/'.$name;
        Storage::disk('s3')->put($path, $image,'public');
        $url = Storage::disk('s3')->url($path);

        return $url;
    }

    private function syncTag(Employee $employee, array $tags)
    {
        if(!$tags) {
            return;
        }
        $tagIds = Tag::whereIn('tag_name', $tags)->get()->pluck('id');
        $employee->tags()->sync($tagIds);
    }

    
}

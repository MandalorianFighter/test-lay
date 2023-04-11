<?php

namespace App\Http\Controllers\User;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\DataTables\EmployeesDataTable;
use App\Models\Employee;
use App\Models\Department;
use Image;

class EmployeeController extends Controller
{

    public function index(EmployeesDataTable $dataTable)
    {
        return $dataTable->render('users.employees');
    }

    public function dataEmployee(Request $request)
    {
        $model = Employee::with(['department', 'tags']);
 
        return app('datatables')->eloquent($model)
        ->editColumn('employee_name', function ($model) {
            return '<a title="Follow The Link To Edit Employee" href="'.route('user.employees.edit', $model).'">'.$model->employee_name.'</a>';
        })
        ->orderColumn('employee_name', function ($query, $order) {
            $query->orderBy('employee_name', $order);
        })
        ->addColumn('photo', function ($model) {
            return '<img src="'. $model->thumbnail .'" height="60px" />';
        })
        ->orderColumn('details', function ($query, $order) {
            $query->orderBy('employee_details', $order);
        })
        ->orderColumn('department', function ($model) {
            return $model->department->department_name;
        })
        ->editColumn('tags', function ($model) {
            return collect($model->tags)->map(function ($tag) {
                return '<span class="badge badge-info">'.$tag->tag_name.'</span>';
            })->implode(' ');
        })
        ->addIndexColumn()
        ->addColumn('action', function ($model) {
            return view('users.employees.delete', ['employee' => $model]);
        })
        ->rawColumns(['employee_name', 'photo', 'tags', 'action'])
        ->toJson();
    }

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
            'photo' => 'image|max:2048|mimes:jpg,png|dimensions:min_width=300,min_height=300',
            'tags.*' => 'nullable',
        ],
        [
            'photo.dimensions' => 'An image should be at least :min_width x :min_height pixels!',
        ]
    );

        $employee = Employee::create($request->except(['photo']));
        $employee->photo = $this->storePhoto($request);
        $employee->thumbnail = $this->generateThumbnail($request);
        $employee->save();

        $this->syncTag($employee, $request->tags);

        $notification = array(
            'message' => 'Employee Is Created Successfully!',
            'alert-type' => 'success',
        );

        return Redirect()->route('user.employees')->with($notification);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        $departments = Department::select('id','department_name')->cursor();
        $tags = Tag::select('id','tag_name')->cursor();
        
        return view('users.employees.edit', compact('employee','departments','tags'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_name' => 'required|min:2|max:256',
            'age' => 'required',
            'department_id' => 'required',
            'position' => 'required',
            'employee_details' => 'required|max:700',
            'photo' => 'image|max:2048|mimes:jpg,png|dimensions:min_width=300,min_height=300',
            'tags.*' => 'nullable',
        ],
        [
            'photo.dimensions' => 'An image should be at least :min_width x :min_height pixels!',
        ]
    );

        $old_image = basename($request->old_image);

        $employee->update($request->all());

        if($request->hasFile('photo')) {
            $employee->photo = $this->storePhoto($request);
            $employee->thumbnail = $this->generateThumbnail($request);
            $employee->save();
        
            // if(file_exists($old_image)) unlink($old_image);
            if(Storage::disk('s3')->exists('images/'.$old_image)) Storage::disk('s3')->delete('images/'.$old_image);
            if(Storage::disk('s3')->exists('images/thumbnails/small_'.$old_image)) Storage::disk('s3')->delete('images/thumbnails/small_'.$old_image);
        }

        $this->syncTag($employee, $request->tags);
        
        $notification = array(
            'message' => 'Employee Is Updated Successfully!',
            'alert-type' => 'success',
        );

        return Redirect()->route('user.employees')->with($notification);
    }

    public function delete(Employee $employee)
    {
        if($employee->tags->count()) {
            $employee->tags->each(function ($tag) use ($employee) { 
                $employee->tags()->detach($tag);
            });
        }
        $old_image = basename($employee->photo);
        if(Storage::disk('s3')->exists('images/'.$old_image)) Storage::disk('s3')->delete('images/'.$old_image);
        if(Storage::disk('s3')->exists('images/thumbnails/small_'.$old_image)) Storage::disk('s3')->delete('images/thumbnails/small_'.$old_image);
        $employee->delete();

        $notification = array(
            'message' => 'Employee Is Deleted!',
            'alert-type' => 'warning',
        );

        return Redirect()->route('user.employees')->with($notification);
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
        $image = Image::make($request->file('photo'))->resize(400, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->stream('jpg', 90);
        $imgPath = 'images/'.$name;
        Storage::disk('s3')->put($imgPath, $image,'public');
        $url = Storage::disk('s3')->url($imgPath);

        return $url;
    }

    private function generateThumbnail(Request $request)
    {
        if(!$request->hasFile('photo')) {
            return;
        }

        $name = 'small_'.$request->file('photo')->hashname();
        $thumbImage = Image::make($request->file('photo'))->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->stream('jpg', 90);
        $thumbPath = 'images/thumbnails/'.$name;
        Storage::disk('s3')->put($thumbPath, $thumbImage,'public');
        $thumbUrl = Storage::disk('s3')->url($thumbPath);
        return $thumbUrl;
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

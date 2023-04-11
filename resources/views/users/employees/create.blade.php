@extends('users.layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Employee - Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.employees') }}">Home</a></li>
              <li class="breadcrumb-item active">Create Employee - Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add New Employee</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('user.employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label for="inputName">Full Name</label>
                        <input type="text" name="employee_name" class="form-control" id="inputName" placeholder="Enter Employee Full Name" value="{{old('employee_name')}}">
                    </div>
                    @error('employee_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                    <div class="custom-file">
                    <input type="file" name="photo" class="custom-file-input" id="customFile" value="{{old('photo')}}">
                    <label class="custom-file-label" for="customFile">Choose Photo</label>
                    </div>
                    </div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <label for="inputAge">Age</label>
                        <input type="text" name="age" class="form-control" id="inputAge" inputmode="numeric" placeholder="Enter Employee Age" value="{{old('age')}}">
                    </div>
                    @error('age')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <label for="inputPosition">Position</label>
                        <input type="text" name="position" class="form-control" id="inputPosition" placeholder="Enter Employee Position"  value="{{old('position')}}">
                    </div>
                    @error('position')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <label for="inputDetails">Details</label>
                        <textarea type="email" name="employee_details" class="form-control" id="inputDetails" placeholder="Enter Employee Details">{{old('employee_details')}}</textarea>
                    </div>
                    @error('employee_details')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
          
                    <div class="form-group">
                        <label for="inputDepartment">Departments</label>
                        <select class="form-control select2" name="department_id" id="inputDepartment" style="width: 100%;">
                        @foreach($departments as $department)
                        <option value="{{$department->id}}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{$department->department_name}}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('department_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <label for="inputTag">Employee Tags</label>
                        <select class="form-control select2 tags-input" multiple="multiple" name="tags[]" id="inputTag" style="width: 100%;">
                        @foreach($tags as $tag)
                        <option value="{{$tag->tag_name}}" {{ (is_array(old('tags')) and in_array($tag->tag_name, old('tags'))) ? ' selected' : '' }}>{{$tag->tag_name}}</option>
                        @endforeach
                        </select>
                    </div>
                    @error('tags')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    
                    
                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

@endsection
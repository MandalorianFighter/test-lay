@extends('users.layouts.app')

@section('title','User - Department Create')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Department - Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.employees') }}">Home</a></li>
              <li class="breadcrumb-item active">Create Department - Page</li>
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
                <h3 class="card-title">Add New Department</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('user.departments.store') }}" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="inputName">Department Name</label>
                        <input type="text" name="department_name" class="form-control" id="inputName" placeholder="Enter Department Name"  value="{{old('department_name')}}">
                    </div>
                    @error('department_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <label for="inputDetails">Department Details</label>
                        <textarea name="department_details" class="form-control" id="inputDetails" placeholder="Enter Department Details">{{old('department_details')}}</textarea>
                    </div>
                    @error('department_details')
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
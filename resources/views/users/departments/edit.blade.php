@extends('users.layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Department - Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.employees') }}">Home</a></li>
              <li class="breadcrumb-item active">Edit Department - Page</li>
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
                <h3 class="card-title">Edit Department</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('user.departments.update', $department->id) }}" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="inputName">Department Name</label>
                        <input type="text" name="department_name" class="form-control" id="inputName" placeholder="Enter Department Name" value="{{ $department->department_name }}">
                    </div>
                    @error('department_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <label for="inputDetails">Department Details</label>
                        <textarea name="department_details" class="form-control" id="inputDetails" placeholder="Enter Department Details">{{ $department->department_details }}</textarea>
                    </div>
                    @error('department_details')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="card-footer">
                    <div class="container-fluid"><button type="submit" class="btn btn-primary">Update</button> </div>
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
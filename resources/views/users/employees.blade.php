@extends('users.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employees Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.employees') }}">Home</a></li>
              <li class="breadcrumb-item active">Employees Page</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">DataTable with Employees</h3> 
                <div class="col-3 row float-sm-right">
                <a href="{{ route('user.employees.add') }}"><button type="button" class="btn btn-block btn-info">Add New Employee</button></a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Photo</th>
                  <th>Age</th>
                  <th>Position</th>
                  <th>Details</th>
                  <th>Department</th>
                  <th>Tags</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($employees as $employee)
                  <tr>
                    <td>{{$employee->id}}</td>
                    <td><a title='Follow The Link To Edit Or Delete Employee' href="{{ route('user.employees.edit', $employee->id) }}">{{$employee->employee_name}}</a></td>
                    <td><img src="{{asset($employee->photo)}}" alt="employee" style="height:60px;"></td>
                    <td>{{$employee->age}}</td>
                    <td>{{$employee->position}}</td>
                    <td>{{$employee->limitDetails()}}</td>
                    <td>{{$employee->department->department_name}}</td>
                    <td>
                    @foreach($employee->tags as $tag)
                    <span class="badge badge-info">{{$tag->tag_name}}</span>
                    @endforeach
                  </td>
                  </tr>
                  @endforeach
                </tbody>
              
                </table>
                
                {{ $employees->links() }}
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
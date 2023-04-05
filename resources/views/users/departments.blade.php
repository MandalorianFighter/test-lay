@extends('users.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Departments Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.employees') }}">Home</a></li>
              <li class="breadcrumb-item active">Departments Page</li>
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
              <div class="card-header ">
              <h3 class="card-title">Departments DataTable</h3>
                <div class="col-3 row float-sm-right">
                <a href="{{ route('user.departments.add') }}"><button type="button" class="btn btn-block btn-info">Add New Department</button></a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Department Name</th>
                  <th>Department Details</th>
                  <th>Created At</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($departments as $department)
                  <tr>
                    <td>{{$department->id}}</td>
                    <td><a title='Follow The Link To Edit Department' href="{{ route('user.departments.edit', $department) }}">{{$department->department_name}}</a></td>
                    <td>{{$department->department_details}}</td>
                    <td>{{$department->created_at}}</td>
                    <td>
                    <form action="{{ route('user.departments.delete', $department) }}" method="post" style="display:inline-block;">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure, you want to delete this Department?')">Delete</button>
                    </form>
                    </td>
                    
                  </tr>
                  @endforeach
                </tbody>
                </table>
                {{ $departments->links() }}
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
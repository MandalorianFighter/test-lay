@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">DataTables Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Home</a></li>
              <li class="breadcrumb-item active">Users DataTable Page</li>
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
              <h3 class="card-title">DataTable with Users</h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="data-table table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>IsAdmin</th>
                  <th>Approved</th>
                  <th>Registered At</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->is_admin ? 'Admin' : 'User'}}</td>
                    <td class="d-flex justify-content-center">
                    @livewire('toggle-switch', ['model' => $user, 'field' => 'approved'], key($user->id))
                    </td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="post" style="display:inline-block;">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure, you want to delete this User?')">Delete</button>
                    </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              
                </table>
                
                {{ $users->links() }}
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
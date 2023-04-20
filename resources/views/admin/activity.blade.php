@extends('admin.layouts.app')

@section('title','Admin - Users Logs')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users Logs Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Home</a></li>
              <li class="breadcrumb-item active">Users Logs Page</li>
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
              <h3 class="card-title">Users Logs DataTable</h3>
              </div>
                <div class="card-body">
                    <div class="form-group">
                        <label><strong>User :</strong></label>
                        <select id='userFind' class="form-control select2 col-3" data-column="2"></select>
                    </div>
                </div>
              <!-- /.card-header -->
              <div class="card-body">
              {{ $dataTable->table() }}
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

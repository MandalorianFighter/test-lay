@extends('users.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tags Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('user.employees') }}">Home</a></li>
              <li class="breadcrumb-item active">Tags Page</li>
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
              <h3 class="card-title">DataTable with Tags</h3> 
                <div class="col-3 row float-sm-right">
                <a href="{{ route('user.tags.add') }}"><button type="button" class="btn btn-block btn-info">Add New Tag</button></a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tags Name</th>
                  <th>Created At</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($tags as $tag)
                  <tr>
                    <td>{{$tag->id}}</td>
                    <td><a title='Follow The Link To Edit Or Delete Tag' href="{{ route('user.tags.edit', $tag->id) }}">{{$tag->tag_name}}</a></td>
                    <td>{{$tag->created_at}}</td>
                  </tr>
                  @endforeach
                </tbody>
              
                </table>
                
                {{ $tags->links() }}
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
@extends('server.layouts.master')
@section('title')
{{__('views.task')}}
@endsection


@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          @if (session('msg'))
          <div class="alert alert-success">
            {{session('msg')}}
          </div>
          @endif
          @if (session('fail'))
          <div class="alert alert-danger">
            {{session('fail')}}
          </div>
         @endif  
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{__('views.task')}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- /.card-body -->
              
              <!-- form start -->
              <form id="UpdateTask" method="post" action="{{route('server.subject.task.update',[$subjectId,$task->id])}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('views.name')}}</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name"
                    value="{{old('name')?old('name'):$task->name}}">
                  </div>
                  @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  
                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">{{__('views.detail')}}</label>
                    <textarea name="detail" class="form-control" rows="5" placeholder="Enter ...">{{old('detail')?old('detail'):$task->detail}}</textarea>
                  </div>
                   @error('detail')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('views.update')}}</button>
                </div>
              </form>
            </div>
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 
@endsection



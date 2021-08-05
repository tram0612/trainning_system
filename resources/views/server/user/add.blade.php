@extends('server.layouts.master')
@section('title')
{{__('views.user')}}
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
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{__('views.profile')}}</h3>
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
              <form method="post" action="{{route('server.user.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-group">
                <small class="text-danger">* : {{__('views.required')}}</small>
                </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('views.name')}}<span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name"
                    value="{{old('name')}}">
                  </div>
                  @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('views.email')}}<span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="{{ old('email')}}">
                  </div>
                  @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputPassword1">{{__('views.password')}}<span class="text-danger">*</span><small class="">  {{__('views.least')}}</small></label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="{{ old('password')}}">
                  </div>
                   @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputFile">{{__('views.avatar')}}<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="avatar" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">{{__('views.choose_file')}}</label>
                      </div>
                      
                    </div>
                  </div>
                  @error('avatar')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label>Role<span class="text-danger">*</span></label>
                    <select name="role" class="form-control">
                      
                      <option value="{{UserRole::Supervisor}}">{{__('enums.role.supervisor')}}</option>
                      <option value="{{UserRole::Trainee}}">{{__('enums.role.trainee')}}</option>
                      
                    </select>
                  </div>
                  @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('views.add')}}</button>
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


@section('js')
<!-- bs-custom-file-input -->
<script src="{{ asset('templates/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection
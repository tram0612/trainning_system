@extends('server.layouts.master')
@section('title')
{{__('views.course')}}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('server.course.content-header')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{__('views.course')}}</h3>
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
              <form method="post" action="{{ route('server.course.update', [$course->id]) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="card-body">
                <div class="form-group">
                <small class="text-danger">* : {{__('views.required')}}</small>
                </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('views.name')}}<span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name"
                    value="{{$course->name}}">
                  </div>
                  @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('views.instruction')}}<span class="text-danger">*</span></label>
                    <textarea name="instruction" class="form-control" rows="5" placeholder="Enter ...">{!!$course->instruction!!}</textarea>
                  </div>
                  @error('instruction')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputPassword1">{{__('views.detail')}}<span class="text-danger">*</span></label>
                    <textarea name="detail" class="form-control" rows="5" placeholder="Enter ...">{!!$course->detail!!}</textarea>
                  </div>
                   @error('detail')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputFile">{{__('views.image')}}</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="img" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">{{__('views.choose_file')}}</label>
                      </div>
                      
                    </div>
                  </div>
                  @error('img')
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


@section('js')
<!-- bs-custom-file-input -->
<script src="{{ asset('templates/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

@endsection
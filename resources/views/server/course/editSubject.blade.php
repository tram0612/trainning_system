@extends('server.layouts.master')
@section('title')
{{__('views.subject')}}
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
              <li class="breadcrumb-item"><a href="#">{{__('views.home')}}</a></li>
              <li class="breadcrumb-item active"></li>
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
                <h3 class="card-title">{{$courseSubject->subject->name}}</h3>
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
              <form method="post" action="{{route('server.course.subject.update',[$courseSubject->course_id,$courseSubject->subject_id])}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                
                  <div class="form-group">
                    <label>Date:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        
                          <input type="text" name="started_at" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('d-m-Y', strtotime($courseSubject->started_at))}}" />
                       
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                  </div>
                  @error('started_at')
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
@include('server.layouts.datePicker')

@endsection
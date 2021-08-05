@extends('client.layouts.master')
@section('title')
{{__('views.home')}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
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
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <h3 class="mb-2">{{__('views.unfinishedCourse')}}</h3>
        <div class="card card-success">
          <div class="card-body">
            <div class="row">
              @foreach($unfinishedCourses as $course)
             
              <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="card ">
                  <img class="card-img-top" src="/upload/{{$course->course->img}}" alt="{{$course->course->img}}">
                  <div class="card-img-overlay">
                    <h5 class="card-title text-primary"></h5>
                    <p class="card-text pb-1 pt-1 text-white">
                    </p>
                    <a class="btn btn-primary btn-sm" href="{{route('course.show',[$course->course->id])}}">
                              {{$course->course->name}}
                    </a>
                  </div>
                </div>
              </div>
              
              @endforeach

            </div>
          </div>
        </div>
        <h3 class="mb-2">{{__('views.doneCourse')}}</h3>
        <div class="card card-success">
          <div class="card-body">
            <div class="row">
              @foreach($doneCourses as $course)
             
              <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="card ">
                  <img class="card-img-top" src="/upload/{{$course->course->img}}" alt="{{$course->course->img}}">
                  <div class="card-img-overlay">
                    <h5 class="card-title text-primary"></h5>
                    <p class="card-text pb-1 pt-1 text-white">
                    </p>
                    <a class="btn btn-primary btn-sm" href="{{route('course.show',[$course->course->id])}}">
                              {{$course->course->name}}
                    </a>
                  </div>
                </div>
              </div>
              
              @endforeach

            </div>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
@endsection


@section('js')
<!-- Tempusdominus Bootstrap 4 -->
<script src="templates/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="templates/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
@endsection
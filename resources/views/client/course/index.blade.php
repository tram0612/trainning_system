@extends('client.layouts.master')
@section('title')
{{__('views.my_course')}}
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
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li> -->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h3 class="mb-2">{{__('views.course')}}</h3>
        <div class="card card-success">
          <div class="card-body">
            <div class="row">
              @foreach($courses as $course)
             
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
        <div class="row">
          <ul class="pagination pagination-sm">
          </ul>
        </div>
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection



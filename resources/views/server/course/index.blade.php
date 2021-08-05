@extends('server.layouts.master')
@section('title')
{{__('views.course')}}
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
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex justify-content-center">
              <div id="alertSearch">
              
              </div>
            </div>
         
            <div class="row">
              <div class="col"></div>
              <div class="col">
                <select id="selectStatus" name="status" class="form-control">
                  <option value="">-----{{__('views.select')}} {{__('views.status')}}-----</option>
                  <option value="{{Finish::No}}">{{__('views.unfinished')}}</option>
                  <option value="{{Finish::Yes}}">{{__('views.done')}}</option>
                </select>
              </div>
              <div class="col"><input id="search" type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Type here to search"></div>
            </div>
            <div class="card" id="courseTable">
              <div class="card-header">
                <h3>{{__('views.course')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>{{__('views.name')}}</th>
                      <th>{{__('views.image')}}</th>
                      <th>{{__('views.status')}}</th>
                      <th>{{__('views.subject')}}</th>
                      <th>{{__('views.trainee')}}</th>
                      <th>{{__('views.supervisor')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($courses as $course)
                    <tr>
                      <td><a href="{{route('server.course.detail',[$course->id])}}"> {{$course->name}}</a></td>
                      <td><a href=""><img width="70px" height="70px" src="/upload/{{$course->img}}"></a></td>
                      <td id="status_{{$course->id}}">
                        @if($course->finish == Finish::No)
                        <span class="text-danger">
                        {{__('views.unfinished')}}
                        </span>
                        @else
                        <span class="text-success">
                        {{__('views.done')}}
                        </span>
                        @endif
                        </td>
                      <td><a href="{{route('server.course.subject.index',[$course->id])}}"> {{__('views.view_subject')}}</a></td>
                      <td><a href="{{route('server.course.trainee',[$course->id])}}"> {{__('views.view_trainee')}}</a></td>
                      <td><a href="{{route('server.course.supervisor',[$course->id])}}"> {{__('views.view_supervisor')}}</a></td>
                        <td>
                        @if($course->finish == Finish::No)
                        <button type="button" route="{{route('server.course.finish',[$course->id])}}" id="bt_{{$course->id}}" data_c="{{$course->id}}"  class="btn btn-block btn-outline-success btn-sm finish">{{__('views.finish')}}</button>
                        @endif  
                        <button type="button" class="btn btn-block bg-gradient-primary btn-xs"><a style="color: black;" href="{{route('server.course.show',[$course->id])}}">{{__('views.edit')}}</a></button>
                        @if($course->deleted_at == null)
                        <form method="post" action="{{route('server.course.softDelete',[$course->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.softDeleteConfirm'))" class="btn btn-block bg-gradient-warning btn-xs">
                            <i data-feather="delete">{{__('views.softDelete')}}</i>
                          </button>
                        </form>
                        @else
                        <form method="post" action="{{route('server.course.restore',[$course->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.restoreConfirm'))" class="btn btn-block bg-gradient-success btn-xs">
                            <i data-feather="delete">{{__('views.restore')}}</i>
                          </button>
                        </form>
                        @endif
                        <form method="post" action="{{route('server.course.destroy',[$course->id])}}">
                          @csrf
                          <input type="hidden" name="_method" value="DELETE">
                          
                          <button type="submit" onclick="return confirm(trans('views.hardDeleteConfirm'))" class="btn btn-block bg-gradient-danger btn-xs">
                            <i data-feather="delete">{{__('views.hardDelete')}}</i>
                          </button>
                        </form>
                        
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  {{ $courses->links('pagination::bootstrap-4') }}
                </ul>
              </div>
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
         
          <!-- /.col -->
        </div>
       
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


@section('js')
@include('i18n')
<script src="{{asset('templates/dist/js/finishCourse.js')}}"></script>
<script src="{{asset('templates/dist/js/searchCourse.js')}}"></script>
@endsection
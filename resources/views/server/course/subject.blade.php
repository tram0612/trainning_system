@extends('server.layouts.master')
@section('title')
{{__('views.subject')}}
@endsection
@section('ui')
@include('server.layouts.ui')
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
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{__('views.subject')}}</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                <table  class="table table-bordered">
                  <thead>
                    <tr>
                      <th>{{__('views.subject')}}</th>
                      <th>{{__('views.started_at')}}</th>
                      <th>{{__('views.status')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody id="subjectTable" courseId="{{$course->id}}">
                    
                    @foreach($subjectOfCourse as $subject)
                    @if($subject->pivot->deleted_at == null)
                    <tr id="{{$subject->id}}">
                      
                      <td><a href=""> {{$subject->name}}</a></td>
                      
                      <td>{{date('d-m-Y', strtotime($subject->pivot->started_at))}}</td>
                      <td id="status_{{$subject->id}}">@if($subject->pivot->status == Status::Start)
                        <span class="text-danger">
                        {{__('views.unfinished')}}
                        </span>
                        @else
                        <span class="text-success">
                        {{__('views.done')}}
                        </span>
                        @endif
                      </td>
                      <td>
                        @if($subject->pivot->status == Status::Start)
                        <button type="button" onclick="return confirm(trans('views.changeStatus'))" id="bt_{{$subject->id}}" data_c="{{$course->id}}" data_s="{{$subject->id}}" class="btn btn-block btn-outline-success btn-sm status">{{__('views.finish')}}</button>
                        @endif  
                        <button type="button" class="btn btn-block bg-gradient-primary btn-xs"><a style="color: black;" href="{{route('server.course.subject.show',[$course->id,$subject->id])}}">{{__('views.edit')}}</a></button>
                        
                        <form method="post" action="{{route('server.course.subject.softDelete',[$course->id,$subject->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.softDeleteConfirm'))" class="btn btn-block bg-gradient-warning btn-xs">
                            <i data-feather="delete">{{__('views.softDelete')}}</i>
                          </button>
                        </form>
                        
                        <form method="post" action="{{route('server.course.subject.destroy',[$course->id,$subject->id])}}">
                          @csrf
                          <input type="hidden" name="_method" value="DELETE">
                          
                          <button type="submit" onclick="return confirm(trans('views.hardDeleteConfirm'))" class="btn btn-block bg-gradient-danger btn-xs">
                            <i data-feather="delete">{{__('views.hardDelete')}}</i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
             
              <!-- /.card-body -->
              
              <!-- form start -->
              <form id="AddSubject" courseId="{{$course->id}}" method="post" action="{{route('server.course.subject.store',[$course->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>{{__('views.select')}}</label>
                    <select name="subject" class="form-control">
                      @foreach ($subjects as $subject)
                      <option value="{{$subject['id']}}">{{$subject['name']}}</option>
                      @endforeach
                    </select>
                 </div>
                  @error('subject')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <!-- Date -->
                  <div class="form-group">
                    <label>{{__('views.date')}}</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" name="started_at" class="form-control datetimepicker-input" data-target="#reservationdate"/>
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
                  <button type="submit" class="btn btn-primary">{{__('views.add')}}</button>
                </div>
              </form>

            
            </div>
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
              <h3 class="card-header">{{__('views.subjectInTrash')}}</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                <table  class="table table-bordered">
                  <thead>
                    <tr>
                      <th>{{__('views.subject')}}</th>
                      <th>{{__('views.started_at')}}</th>
                      <th>{{__('views.status')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subjectOfCourse as $subject)
                    @if($subject->pivot->deleted_at !== null)
                    <tr id="{{$subject->id}}">
                      
                      <td><a href=""> {{$subject->name}}</a></td>
                      
                      <td>{{date('d-m-Y', strtotime($subject->pivot->started_at))}}</td>
                      <td id="status_{{$subject->id}}">@if($subject->pivot->status == Status::Start)
                        <span class="text-danger">
                        {{__('views.unfinished')}}
                        </span>
                        @else
                        <span class="text-success">
                        {{__('views.done')}}
                        </span>
                        @endif
                      </td>
                      <td>
                        <form method="post" action="{{route('server.course.subject.restore',[$course->id,$subject->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.restoreConfirm'))" class="btn btn-block bg-gradient-success btn-xs">
                            <i data-feather="delete">{{__('views.restore')}}</i>
                          </button>
                        </form>
                      
                        <form method="post" action="{{route('server.course.subject.destroy',[$course->id,$subject->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.hardDeleteConfirm'))" class="btn btn-block bg-gradient-danger btn-xs">
                            <i data-feather="delete">{{__('views.hardDelete')}}</i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!--/.col (right) -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 
@endsection


@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@include('i18n')
@include('server.layouts.datePicker')
<script src="{{ asset('templates/dist/js/subject.js') }}"></script>
@endsection
@extends('server.layouts.master')
@section('title')
{{__('views.task')}}
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
                <h3 class="card-title">{{__('views.progressOf')}} {{$user->name}} {{__('views.in')}} {{$subject->name}}</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
              <div class="card">
                @foreach($tasks as $task)
                <div class="row">
                  <div class="col-12 col-sm-12">
                    <div class="card">
                      <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                          <i class="ion ion-clipboard mr-1"></i>
                          {{$task->name}}
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <ul class="todo-list ui-sortable" id="{{$task->id}}" data-widget="todo-list">
                          @foreach($task->userTask as $userTask )
                          <li class="{{($userTask->status == Status::Finish)?'done':''}}">
                          <div class="d-flex justify-content-around">
                            <div class="p-2 bd-highlight"><span>{{$userTask->comment}}</span></div>
                            <div class="p-2 bd-highlight"><span>{{$userTask->duration}}</span></div>
                            <div class="p-2 bd-highlight">@if($userTask->status == Status::Finish)
                                  <span class="text-success">
                                    {{__('views.done')}}
                                  </span>
                                  @else
                                  <span class="text-danger">{{__('views.unfinished')}}</span>
                                  @endif</div>
                          </div>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer clearfix">
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              </div>
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



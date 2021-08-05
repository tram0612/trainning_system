@extends('client.layouts.master')
@section('title')
{{__('views.subject')}}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        @if (session('msg'))
            <div class="alert alert-warning">
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

            <h1>
              {{$subject->name}}
            </h1>

          </div> 
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
            
          </div>
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">{{__('views.home')}}</a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('views.detail')}}</a>
                  </li>
                  
                 
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-history-tab" data-toggle="pill" href="#custom-tabs-one-history" role="tab" aria-controls="custom-tabs-one-history" aria-selected="false">{{__('views.history')}}</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
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
                                
                                <li>
                                  <div class="input-group">
                                    <input route="{{route('task.update',[$userTask->id])}}" type="text" class="col-sm-8 form-control comment" name="comment" value="{{$userTask->comment}}">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <input route="{{route('task.updateDuration',[$userTask->id])}}" type="text" name="duration" class="col-sm-3 form-control reservation duration" value="{{$userTask->duration}}">
                                    <input route="{{route('task.edit',[$userTask->id])}}" class="col-sm-2 form-control checkStatus" type="checkbox" {{($userTask->status == Status::Finish)?'checked':''}} value="" >
                                    <div class="tools">
                                      <i class="fas fa-trash delete" route="{{route('task.destroy',[$userTask->id])}}"></i>
                                    </div>
                                  </div>
                                </li>
                                @endforeach
                              </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                            <div class="d-flex justify-content-center">
                                <div id="alert_{{$task->id}}">
                                  
                                </div>
                              </div>

                              <div class="input-group">
                                <input type="text" name="task" placeholder="Type Task ..." class="form-control">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" name="duration" class="col-sm-3 form-control float-right reservation" >
                                <button task_id="{{$task->id}}" route="{{route('task.store')}}" type="button" class="btn btn-primary addUserTask">{{__('views.addTask')}}</button>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                 
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     {!!$subject->detail!!}
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-history" role="tabpanel" aria-labelledby="custom-tabs-one-history-tab">
                     <div class="card-body">
                      @foreach($tasks as $task)
                      <ul class="todo-list ui-sortable history" id="{{$task->id}}" data-widget="todo-list">
                        @foreach($task->userTask as $userTask )
                        @if($userTask->status == Status::Finish)
                        <li >
                          <div class="row">
                            <div class="col">
                              {{$userTask->comment}}
                            </div>
                            <div class="col">
                              {{$userTask->duration}}
                            </div>
                          </div>
                        </li>
                        @endif
                        @endforeach
                      </ul>
                      @endforeach 
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>


@endsection
@section('js')
@include('client.layouts.jsUserTask')
<script src="{{ asset('templates/dist/js/addUserTask.js')  }}"></script>
@endsection


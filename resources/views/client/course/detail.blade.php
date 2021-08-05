@extends('client.layouts.master')
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
            <div class="alert alert-warning">
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
              <!-- -->
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
            <h4>{{$course->name}}</h4>
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
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">{{__('views.member')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('views.detail')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">{{__('views.instruction')}}</a>
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
                      <div class="card-header">
                        <h3 class="card-title">{{__('views.subject')}}</h3>

                        <div class="card-tools">
                          Done
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                          @foreach($subjects['user_subject'] as $subject)
                          <li class="item">
                          <div class="d-flex justify-content-between">
                            <div class="mr-auto p-2">
                              <div class="product-img">
                                    <img src="/upload/{{$subject['course_subject']['subject']['img']}}" alt="Subject Image" class="img-size-50">
                                  </div>
                                  <div class="product-info">
                                  <a href="{{route('course.subject.show',[$course->id,$subject['course_subject']['subject']['id']])}}" class="product-title">{{$subject['course_subject']['subject']['name']}}
                                  </div>
                              </div>
                            <div class="ml-auto p-2">
                              @if($subject['status']==Status::Finish)
                              <input class="form-check-input statusSubject" checked route="{{route('course.subject.edit',[$course->id,$subject['course_subject']['subject']['id']])}}" subject_id="{{$subject['id']}}"  type="checkbox">
                              @else
                              <input class="form-check-input statusSubject" route="{{route('course.subject.edit',[$course->id,$subject['course_subject']['subject']['id']])}}" subject_id="{{$subject['id']}}" type="checkbox">
                              @endif
                            </div>
                          </div>
                              <!-- <div class="col-sm-10">
                                <div class="product-img">
                                  <img src="/upload/{{$subject['course_subject']['subject']['img']}}" alt="Subject Image" class="img-size-50">
                                </div>
                                <div class="product-info">
                                <a href="{{route('course.subject.show',[$course->id,$subject['course_subject']['subject']['id']])}}" class="product-title">{{$subject['course_subject']['subject']['name']}}
                                </div>
                              </div>
                              <div class="input">
                             
                                  @if($subject['status']==Status::Finish)
                                  <input checked route="{{route('course.subject.edit',[$course->id,$subject['course_subject']['subject']['id']])}}" subject_id="{{$subject['id']}}" class="form-control statusSubject" type="checkbox">
                                  @else
                                  <input route="{{route('course.subject.edit',[$course->id,$subject['course_subject']['subject']['id']])}}" subject_id="{{$subject['id']}}" class="form-control statusSubject" type="checkbox">
                                  @endif
                               
                              </div> -->
                              
                           

                            
                          </li>
                          @endforeach
                          <!-- /.item -->
                          
                        </ul>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer text-center">
                        <!-- <a href="javascript:void(0)" class="uppercase">View All Products</a> -->
                      </div>
              <!-- /.card-footer -->
                   </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                     <div class="col-md-12">
                    <!-- USERS LIST -->
                    <div class="card">
                      
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <ul class="users-list clearfix">
                          @foreach($members as $member)
                          <li>
                            <img src="/upload/{{$member->avatar}}" alt="User Image">
                            <a class="users-list-name" href="{{route('profile.show',[$member->id])}}">{{$member->name}}</a>
                          </li>
                          @endforeach
                          
                        </ul>
                        <!-- /.users-list -->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer text-center">
                        
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                  </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     {!!$course->detail!!}
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                     {!!$course->instruction!!}
                  </div>
                  
                  <div class="tab-pane fade" id="custom-tabs-one-history" role="tabpanel" aria-labelledby="custom-tabs-one-history-tab">
                     <div class="card-body">
                      @foreach($tasks as $task)
                      <ul class="todo-list ui-sortable" id="{{$task->id}}" data-widget="todo-list">
                        
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
<script src="{{ asset('templates/dist/js/statusUserSubject.js') }}"></script>
@endsection
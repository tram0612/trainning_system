@extends('server.layouts.master')
@section('title')
{{__('views.user')}}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('server.course.content-header')

    <!-- Main content -->
<section class="content">
      @php
      $role = UserRole::Trainee;
      if(Route::currentRouteName()=='server.course.supervisor'){
        $role = UserRole::Supervisor;
      }
      @endphp
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{$role==UserRole::Trainee?__('views.trainee'):__('views.supervisor')}}</h3>
        </div>
        <div class="card-body p-0">
          
          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th style="width: 20%">
                          {{$role==UserRole::Trainee?__('views.trainee'):__('views.supervisor')}}
                      </th>
                      <th style="width: 30%">
                          Avarta
                      </th>
                      @if($role==UserRole::Trainee)
                      <th>
                          {{__('views.progress')}}
                      </th>
                      @endif
                      <th style="width: 20%">
                       {{__('views.action')}}
                      </th>
                  </tr>
              </thead>
              <tbody id="userTable">
                @foreach($userOfCourse as $user)
                @if($user->pivot->deleted_at == null)
                  <tr>
                      <td>
                          <a>
                              {{$user->name}}
                          </a>
                      </td>
                      <td>
                        <img alt="Avatar" class="direct-chat-img" src="/upload/{{$user->avatar}}">
                      </td>
                      @if($user->role==UserRole::Trainee)
                      <td>
                          <a class="btn btn-primary btn-sm" href="{{route('server.course.progressUser',[$course->id,$user->id])}}">
                              <i class="fas fa-folder">
                              </i>
                              {{__('views.progress')}}
                          </a>
                      </td>
                      @endif
                      <td class="project-actions text-right">
                      <form method="post" action="{{route('server.course.user.softDelete',[$course->id,$user->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.softDeleteConfirm'))" class="btn btn-block bg-gradient-warning btn-xs">
                            <i data-feather="delete">{{__('views.softDelete')}}</i>
                          </button>
                        </form>
                      
                        <form method="post" action="{{route('server.course.user.destroy',[$course->id,$user->id])}}">
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
      </div>
      <!-- /.card -->
      @if(!blank($users))
      <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
            
              <h3 class="card-title">{{$role==UserRole::Trainee?__('views.seclectTraniee'):__('views.seclectSupervisor')}} {{$course->name}}</h3>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <form method="post" action="{{route('server.course.user.store',[$course->id])}}" enctype="multipart/form-data">
            @csrf
            @error('userIds')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="card-body">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
               
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td>
                      <div class="icheck-primary">
                        <input type="checkbox" name="userIds[]" value="{{$user['id']}}" id="{{$user['id']}}">
                        <label for="{{$user['id']}}"></label>
                      </div>
                    </td>
                    <td class="mailbox-star"><img class="direct-chat-img" src="/upload/{{$user['avatar']}}" alt="message user image"></td>
                    <td class="mailbox-name">{{$user['name']}}</td>
                    <td class="mailbox-subject"><b>{{$user['email']}}</b>
                    </td>
                  </tr>
                 @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer ">
              <button type="submit" class="btn btn-primary">{{__('views.add')}}</button>
            </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
 
      @endif
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{$role==UserRole::Trainee?__('views.trainee'):__('views.supervisor')}}  {{__('views.in')}} {{__('views.trash')}}</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-bordered">
              <thead>
                  <tr>
                      
                      <th style="width: 20%">
                          {{$role==UserRole::Trainee?__('views.trainee'):__('views.supervisor')}}
                      </th>
                      <th style="width: 30%">
                          Avarta
                      </th>
                      @if($role==UserRole::Trainee)
                      <th>
                          {{__('views.progress')}}
                      </th>
                      @endif
                      <th style="width: 20%">
                       {{__('views.action')}}
                      </th>
                  </tr>
              </thead>
              <tbody >
                @foreach($userOfCourse as $user)
                @if($user->pivot->deleted_at != null)
                  <tr>
                      <td>
                          <a>
                              {{$user->name}}
                          </a>
                      </td>
                      <td>
                        <img alt="Avatar" class="direct-chat-img" src="/upload/{{$user->avatar}}">
                      </td>
                      @if($user->role==UserRole::Trainee)
                      <td>
                          <a class="btn btn-primary btn-sm" href="{{route('server.course.progressUser',[$course->id,$user->id])}}">
                              <i class="fas fa-folder">
                              </i>
                              {{__('views.progress')}}
                          </a>
                      </td>
                      @endif
                      <td class="project-actions text-right">
                        <form method="post" action="{{route('server.course.user.restore',[$course->id,$user->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.restoreConfirm'))" class="btn btn-block bg-gradient-success btn-xs">
                            <i data-feather="delete">{{__('views.restore')}}</i>
                          </button>
                        </form>
                      
                        <form method="post" action="{{route('server.course.user.destroy',[$course->id,$user->id])}}">
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
        <!-- /.card-body -->
      </div>
     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('js')
@include('i18n')
<script src="{{ asset('templates/dist/js/checkbox.js') }}"></script>
@endsection

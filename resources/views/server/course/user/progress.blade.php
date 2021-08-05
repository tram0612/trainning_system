@extends('server.layouts.master')
@section('title')
{{__('views.progress')}}
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              <h3>{{__('views.progressOf')}} {{$user->name}} in {{$subjects['name']}}</h3>
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
               
                  <thead>
                    <tr>
                      <th>{{__('views.subject')}}</th>
                      <th>{{__('views.image')}}</th>
                      <th>{{__('views.task')}}</th>
                      <th>{{__('views.status')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subjects['user_subject'] as $userSubject)
                    <tr>
                      <td><a href="">{{$userSubject['course_subject']['subject']['name']}}</a></td>
                      <td><a href=""><img width="70px" height="70px" src="/upload/{{$userSubject['course_subject']['subject']['img']}}"></a></td>
                      <td><a href="{{route('server.course.user.task',[$course['id'],$userSubject['course_subject']['subject']['id'],$userSubject['user_id']])}}">{{__('views.view_task')}}</a></td>
                      <td>
                      @if($userSubject['status'] == Status::Start)
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
                        <form method="post" action="{{route('server.userSubject.destroy',[$userSubject['id']])}}">
                          @csrf
                          <input type="hidden" name="_method" value="DELETE">
                          
                          <button type="submit" onclick="return confirm(trans('views.hardDeleteConfirm'))" class="btn btn-block bg-gradient-danger btn-xs">
                            <i data-feather="delete">{{__('views.delete')}}</i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('js')
@include('i18n')
@endsection



@extends('server.layouts.master')
@section('title')
{{__('views.user')}}
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
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{Route::currentRouteName()=='server.user.trainee'?__('views.trainee'):__('views.supervisor')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>{{__('views.name')}}</th>
                      <th>{{__('views.image')}}</th>
                      <th>{{__('views.email')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    @php
                    $url = route('server.user.show',[$user->id]);
                    @endphp
                    <tr>
                      <td>{{$user->id}}</td>
                      <td><a href="{{$url}}"> {{$user->name}}</a></td>
                      <td><a href="{{$url}}"><img width="70px" height="70px" src="/upload/{{$user->avatar}}"></a></td>
                      <td>{{$user->email}}</td>
                      <td>
                        <button type="button" class="btn btn-block bg-gradient-info btn-xs"><a style="color: black;" href="{{$url}}">{{__('views.edit')}}</a></button>
                        @if($user->deleted_at == null)
                        <form method="post" action="{{route('server.user.softDelete',[$user->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.softDeleteConfirm'))" class="btn btn-block bg-gradient-warning btn-xs">
                            <i data-feather="delete">{{__('views.softDelete')}}</i>
                          </button>
                        </form>
                        @else
                        <form method="post" action="{{route('server.user.restore',[$user->id])}}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.restoreConfirm'))" class="btn btn-block bg-gradient-success btn-xs">
                            <i data-feather="delete">{{__('views.restore')}}</i>
                          </button>
                        </form>
                        @endif
                        <form method="post" action="{{route('server.user.destroy',[$user->id])}}">
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
                  {{ $users->links('pagination::bootstrap-4') }}
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


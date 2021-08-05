@extends('server.layouts.master')
@section('title')
{{__('views.task')}}
@endsection
@section('ui')
@include('server.layouts.ui')

@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('server.subject.content-header')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$subject->name}}</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                <table  class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>{{__('views.task')}}</th>
                      <th>{{__('views.detail')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody id="taskTable" subjectId="{{$subject->id}}">
                    
                    @foreach($subject->task as $task)
                    
                    <tr id='{{$task->id}}'>
                      <td>{{$task->id}}</td>
                      <td><a href=""> {{$task->name}}</a></td>
                      <td> {{$task->detail}}</td>
                      <td>
                        <button type="button" class="btn btn-block bg-gradient-info btn-xs"><a style="color: black;" href="{{route('server.subject.task.show',[$subject->id,$task->id])}}">{{__('views.edit')}}</a></button>
                        <form method="post" action="{{route('server.subject.task.destroy',[$subject->id,$task->id])}}">
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
             
              <!-- /.card-body -->
              
              <!-- form start -->
              <form subjectId="{{$subject->id}}" method="post" action="{{route('server.subject.task.store',[$subject->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{__('views.task')}}</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name"
                    value="{{old('name')}}">
                  </div>
                  @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  
                  @error('task')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputPassword1">{{__('views.detail')}}</label>
                    <textarea name="detail" class="form-control" rows="5" placeholder="Enter ..."></textarea>
                  </div>
                   @error('detail')
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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 
@endsection


@section('js')
@include('i18n')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('templates/dist/js/task.js') }}"></script>
@endsection
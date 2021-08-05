@extends('server.layouts.master')
@section('title')
{{__('views.subject')}}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row mb-2">
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
                  <option value="{{Search::NoTrash}}">{{__('views.notTrash')}}</option>
                  <option value="{{Search::Trash}}">{{__('views.trash')}}</option>
                </select>
              </div>
              <div class="col"><input id="search" type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Type here to search"></div>
            </div>
             
            <div class="card" id="subjectTable">
              <div class="card-header">
              <h3 class="card-title">{{__('views.subject')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>{{__('views.name')}}</th>
                      <th>{{__('views.image')}}</th>
                      <th>{{__('views.task')}}</th>
                      <th>{{__('views.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                      <td><a href="{{route('server.subject.detail',[$subject->id])}}"> {{$subject->name}}</a></td>
                      <td><a href=""><img width="70px" height="70px" src="/upload/{{$subject->img}}"></a></td>
                      <td><a href="{{route('server.subject.task.index',[$subject->id])}}">{{__('views.view_task')}}</a></td>
                      <td>
                        <button type="button" class="btn btn-block bg-gradient-info btn-xs"><a style="color: black;" href="{{ route('server.subject.show', [$subject->id]) }}">{{__('views.edit')}}</a></button>
                        @if($subject->deleted_at == null)
                        <form method="POST" action="{{ route('server.subject.softDelete', [$subject->id]) }}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.softDeleteConfirm'))" class="btn btn-block bg-gradient-warning btn-xs">
                            <i data-feather="delete">{{__('views.softDelete')}}</i>
                          </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('server.subject.restore', [$subject->id]) }}">
                          @csrf
                          <button type="submit" onclick="return confirm(trans('views.restoreConfirm'))" class="btn btn-block bg-gradient-success btn-xs">
                            <i data-feather="delete">{{__('views.restore')}}</i>
                          </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('server.subject.destroy', [$subject->id]) }}">
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
              
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  {{ $subjects->links('pagination::bootstrap-4') }}
                </ul>
              </div>
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
<script src="{{ asset('templates/dist/js/searchSubject.js') }}"></script>
@endsection


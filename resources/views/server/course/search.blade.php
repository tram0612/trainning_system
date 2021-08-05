<div class="card-header">
<h3 class="card-title">{{__('views.course')}}</h3>
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
    @if(blank($courses))
    <tr><td colspan="4">{{__('views.noResult')}}</td><tr>
    @else
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
    @endif
    </tbody>
</table>
</div>
<!-- /.card-body -->

<div class="card-footer clearfix">
<ul class="pagination pagination-sm m-0 float-right">
</ul>
</div>
<script src="{{asset('templates/dist/js/finishCourse.js')}}"></script>
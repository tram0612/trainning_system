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
    @if(blank($subjects))
    <tr><td colspan="4">{{__('views.noResult')}}</td><tr>
    @else
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
</ul>
</div>
@endif
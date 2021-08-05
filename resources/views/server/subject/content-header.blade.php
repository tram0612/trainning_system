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
    <div class="row mb-2">
        <div class="col-sm-12">
            <div class="btn-group w-50 mb-2">
                <a class="btn btn-info" href="{{route('server.subject.detail',[$subject->id])}}" >{{$subject->name}} </a>
                <a class="btn btn-info" href="{{route('server.subject.task.index',[$subject->id])}}" > {{__('views.task')}} </a>
            </div>
        </div>
    </div>
</section>
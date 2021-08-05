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
            <div class="btn-group w-100 mb-2">
                <a class="btn btn-info" href="{{route('server.course.detail',[$course->id])}}" >{{$course->name}} </a>
                <a class="btn btn-info" href="{{route('server.course.subject.index',[$course->id])}}" > {{__('views.subject')}} </a>
                <a class="btn btn-info" href="{{route('server.course.trainee',[$course->id])}}" > {{__('views.trainee')}} </a>
                <a class="btn btn-info" href="{{route('server.course.supervisor',[$course->id])}}" > {{__('views.supervisor')}} </a>
            </div>
        </div>
    </div>
</section>
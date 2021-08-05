@if($subject->status == Status::Start)
    <button type="button" data_c="{{$subject->course_id}}" data_s="{{$subject->subject_id}}" class="btn btn-block btn-outline-success btn-sm status">{{__('views.start')}}</button>
    @else
    <button type="button" data_c="{{$subject->course_id}}" data_s="{{$subject->subject_id}}" class="btn btn-block btn-outline-danger btn-sm status">{{__('views.finish')}}</button>
    @endif
 <script src="{{ asset('templates/dist/js/subject.js') }}"></script>
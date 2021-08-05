<li>
  <div class="input-group">
    <input route="{{route('task.update',[$userTask->id])}}" type="text" class="col-sm-8 form-control comment" name="comment" value="{{$userTask->comment}}">
    <div class="input-group-prepend">
      <span class="input-group-text">
        <i class="far fa-calendar-alt"></i>
      </span>
    </div>
    <input route="{{route('task.updateDuration',[$userTask->id])}}" type="text" name="duration" class="col-sm-3 form-control reservation duration" value="{{$userTask->duration}}">
    <input route="{{route('task.edit',[$userTask->id])}}" class="col-sm-2 form-control checkStatus" type="checkbox" {{($userTask->status == Status::Finish)?'checked':''}} value="" >
    <div class="tools">
      <i class="fas fa-trash delete" route="{{route('task.destroy',[$userTask->id])}}"></i>
    </div>
  </div>
</li>
@include('client.layouts.jsUserTask')


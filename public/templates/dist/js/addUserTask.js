$(document).ready(function(){
	$.ajaxSetup({
	    headers:
	    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});
    $(".addUserTask").click(function(e) {
        
        let route = $(this).attr('route')
        let comment = $(this).closest('div').find('input[name="task"]').val()
        let duration = $(this).closest('div').find('input[name="duration"]').val()
        let task_id = $(this).attr('task_id')
        console.log(comment);
        
        if(comment==='' || duration===''){
            let alert = trans('views.oop!');
            let html = '<div class="alert alert-danger alert-dismissible">'+
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+alert+'</div>';
            $('#alert_'+task_id).html(html);
        }
        else{
            $('#alert_'+task_id).html('');
            $.ajax({
                type:'POST',
                url:route,
                data:{
                  'comment':comment,
                  'duration':duration,
                  'task_id':task_id,
                },
                success:function (data) {
                  $('#'+task_id).append(data.html)
                  $('input[name="task"]').val('')
                },
                error: function (xhr) {
                        console.log(xhr.responseText);
                    }
            }, "json");
        }

    });
});

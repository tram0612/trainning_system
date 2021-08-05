$(document).ready(function(){
	$.ajaxSetup({
	    headers:
	    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});


	$(".checkStatus").change(function() {
        var route = $(this).attr('route')
        $.ajax({
            type:'GET',
            url:route,
            data:{
            },
            success:function (data) {
            },
            error: function (e) {
                console.log((e.responseJSON.errors));
            }
    	}, "json");
    });
    $(".delete").click(function(e) {
        if(confirm(trans('views.deleteConfirm'))) {
            var route = $(this).attr('route');
            $(this).closest('li').remove();
            $.ajax({
                type:'DELETE',
                url:route,
                data:{
                },
                success:function (data) {
                $('#'+task_id).append(data.html);
                },
                error: function (xhr) {
                        console.log(xhr.responseText);
                    }
            }, "json");
        }
    });
    $( ".comment" ).on("keydown", function(event) {
        if(event.which == 13) {
            var comment = $(this).val();
            var route = $(this).attr('route')
            if(comment==''){
                alert(trans('views.oop!'));
            }
            else{
                $.ajax({
                type:'PATCH',
                url:route,
                data:{
                  'comment':comment,
                },
                success:function (data) {
                },
                error: function (xhr) {
                        console.log(xhr.responseText);
                    }
            }, "json");
            }
        }
    });
    $('.duration').on('apply.daterangepicker', function() {
        let route = $(this).attr('route')
        let duration = $(this).val()
        $.ajax({
            type:'POST',
            url:route,
            data:{
                'duration':duration
            },
            success:function (data) {
            },
            error: function (e) {
                    console.log((e.responseJSON.errors));
                }
    	}, "json");
    });
});
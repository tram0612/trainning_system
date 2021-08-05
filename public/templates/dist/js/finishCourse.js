$(document).ready(function(){
	$.ajaxSetup({
	    headers:
	    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});
	$(".finish").click(function(e) {
		if(confirm(trans('views.changeStatus'))) {
			let courseId = $(this).attr('data_c')
			let route = $(this).attr('route')
			$.ajax({
	            type:'POST',
	            url:route,
	            data:{
	            },
	            success:function (data) {
					if(data.success){
						$('#status_'+courseId).html('<span class="text-success">'+trans('views.done')+'</span>');
						$('#bt_'+courseId).remove();
					}
	            },
	            error: function (xhr) {
	                    console.log(xhr.responseText);
	                }
	        }, "json");
		}
	});
});
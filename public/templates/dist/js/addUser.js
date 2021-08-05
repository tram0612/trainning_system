$(document).ready(function(){
	$.ajaxSetup({
	    headers:
	    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});


	$("#AddUser").submit(function(e) {
		e.preventDefault()
		var route = $(this).attr('action')
		var userId = $(this).find('select[name="user"]').find('option:selected').val()
		var courseId = $(this).attr('courseId')
		console.log(userId);
		console.log(courseId);
		console.log(route);
		if(userId==''){
			alert(trans('views.oop!'));
		}
		else{
			$(this).find('select[name="user"]').find('option:selected').remove();
			$.ajax({
	            type:'POST',
	            url:route,
	            data:{
	              'userId':userId,
	              'courseId':courseId,
	            },
	            success:function (data) {
	            	//console.log(data.html)
	              $('#userTable').append(data.html)
	            },
	            error: function (xhr) {
	                    console.log(xhr.responseText);
	                }
	        }, "json");
		}

	});
});
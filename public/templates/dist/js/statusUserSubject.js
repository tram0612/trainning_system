$(document).ready(function(){
	$.ajaxSetup({
	    headers:
	    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});


	$(".statusSubject").change(function() {
		var	id = $(this).attr('subject_id')
		var route = $(this).attr('route')
		console.log(id)
        $.ajax({
            type:'GET',
            url:route,
            data:{
              'id':id,
            },
            success:function (data) {
            
            },
            error: function (e) {
                    console.log((e.responseJSON.errors));
                }
    	}, "json");
        
    });
});
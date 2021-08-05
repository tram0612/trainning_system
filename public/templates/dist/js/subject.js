 $(document).ready(function(){
	$.ajaxSetup({
	    headers:
	    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});
	$(".status").click(function(e) {
		if(confirm(trans('views.changeStatus'))) {
			let courseId = $(this).attr('data_c')
			let subjectId = $(this).attr('data_s')
			$.ajax({
	            type:'POST',
	            url:'/server/course/status',
	            data:{
	              'subjectId':subjectId,
	              'courseId':courseId,
	            },
	            success:function (data) {
                if(data.success){
                  $('#status_'+subjectId).html('<span class="text-success">'+trans('views.done')+'</span>');
				          $('#bt_'+subjectId).remove();
                }
	              
	            },
	            error: function (xhr) {
	                    console.log(xhr.responseText);
	                }
	        }, "json");
		}
	});
	
	$('#subjectTable').sortable({
      stop: function(){
        var ids = '';
        var courseId =$(this).attr('courseId');
		
        $('#subjectTable tr').each(function(){
          var id = $(this).attr('id');
          if(ids==''){
            ids=id;
          }
          else{
            ids +=','+id;
          }
        })
        
        $.ajax({
              type:'POST',
              url:'/server/course/sortSubject',
              data:{
                'ids':ids,
                'courseId':courseId,
              },
              success:function (data) {
                
              },
              error: function (e) {
                      console.log((e.responseJSON.errors));
                  }
          }, "json");
      }
    });

    


});
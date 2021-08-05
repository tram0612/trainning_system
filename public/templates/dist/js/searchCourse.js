$(document).ready(function(){
    $("#selectStatus").change(function(){
        let status = $(this).children("option:selected").val();
        let search = $('#search').val();
        $.ajax({
            type:'GET',
            url:'/server/course/search',
            data:{
                'status': status,
                'search': search
            },
            success:function (data) {
                if(data.success){
                    $('#courseTable').html(data.html);
                    $('#alertSearch').html('');
                }else{
                    $('#alertSearch').html(data.html);
                }
              
            },
            error: function (xhr) {
                    console.log(xhr.responseText);
                }
        }, "json");
    });
    $("#search").keyup(function(){
        let status = $('#selectStatus').children("option:selected").val();
        let search = $(this).val();
        $.ajax({
            type:'GET',
            url:'/server/course/search',
            data:{
                'status': status,
                'search': search
            },
            success:function (data) {
               
                if(data.success==true){
                    $('#courseTable').html(data.html);
                    $('#alertSearch').html('');
                }else{
                    $('#alertSearch').html(data.html);
                }
              
            },
            error: function (xhr) {
                    console.log(xhr.responseText);
                }
        }, "json");
    });
});

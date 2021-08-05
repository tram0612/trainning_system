$(function () {
    $('.reservation').each(function(){
      $(this).daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        }
      });
    })
    
  })
  
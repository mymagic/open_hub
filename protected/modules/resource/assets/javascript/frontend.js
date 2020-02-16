$(function() {
  
  // auto expand parents when child is selected
  $('.box-filter').each(function() {
    $('.box-filter .list-group .item input[type=checkbox]:checked').each(function() {
      $(this).parents('.panel-collapse').collapse('show');
    });
  });
  // when clear filter tag
  $('#list-filters #btn-clearAll').on('click', function(e){
    $('.box-filter').each(function() {
      $(this).find('input:checkbox').removeAttr('checked');
      $(this).find('input:text').val('');
    });
    $('#form-searchResource').submit();
  });

  $('.toggle-updown').click(function() {
    $(this).parent('.box-filter').find('.panel-group').toggle();
  });
});

function goBack()
{
	window.history.back();
}

/*(function() {
  var cx = '003080515321755030470:ls0frruy5mm';
  var gcse = document.createElement('script');
  gcse.type = 'text/javascript';
  gcse.async = true;
  gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(gcse, s);
})();*/

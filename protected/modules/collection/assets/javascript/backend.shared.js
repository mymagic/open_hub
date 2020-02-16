$(function() {
  $(".collectible").prepend('<a class="btn btn-xs btn-white btn-addCollectible" data-load-url="'+baseUrl+'/collection/me/addItem2Collection"><i class="fa fa-bookmark"></i></a>');

  $('body').on( "click", '.btn-addCollectible', function() {
    var url2Load = $(this).data('loadUrl')+'?tableName='+$(this).parent('.collectible').data('collectionTable_name')+'&refId='+$(this).parent('.collectible').data('collectionRef_id');
    $('#modal-common').html('<div class="text-center text-white margin-top-3x">'+$('#block-spinner').html()+'</div>').load(url2Load, function(response, status, xhr){onAddItem2CollectionLoaded()}).modal('show');
  });
  
});

function onAddItem2CollectionLoaded(response, status, xhr){}
function onAddItem2CollectionValidated(form, data, hasError)
{
	if(!hasError)
	{
		$.ajax({
			"type":"POST",
			'dataType':'json',
			"url":$('#collection-form').prop('action'),
			"data":form.serialize(),
			"beforeSend":function(xhr){
        $('#collection-form input[type="submit"]').prop('disabled', true);
      },	
			"always":function(){
        $('#collection-form input[type="submit"]').prop('disabled', false);
      },	
			"success":function(json){
        //var json = jQuery.parseJSON(result);
        if(json.status == 'success')
        {
          $('#modal-common').html('').modal('hide');
          toastr.success(json.msg + '<br /><br /><a class="btn btn-sm btn-primary" href="'+baseUrl+'/collection/me/list/'+json.data.collectionId+'">View Collection</a>', '', {
            "closeButton": true,
            "newestOnTop": true,
            "preventDuplicates": true,
            "showDuration": "1000",
          });
        }
        else
        {
          toastr.error(json.msg);
        }
      },	
		});
	}
}

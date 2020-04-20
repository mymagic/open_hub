$(function() {

	// console.log("called");
	
	//
	var tagsOrganization = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 
		{
			url: baseUrl + '/organization/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		},
		remote: 
		{
			url: baseUrl + '/organization/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		}
	});
	// kicks off the loading/processing of `local` and `prefetch`
	tagsOrganization.initialize();

	$('#Organization-tag_backend').tagsinput({
	  typeaheadjs: {
	    name: 'tags',
	    displayKey: 'name',
    	valueKey: 'name',
	    source: tagsOrganization.ttAdapter()
	  }
	});

	//
	var tagsEvent = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 
		{
			url: baseUrl + '/event/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		},
		remote: 
		{
			url: baseUrl + '/event/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		}
	});
	// kicks off the loading/processing of `local` and `prefetch`
	tagsEvent.initialize();

	$('#Event-tag_backend').tagsinput({
	  typeaheadjs: {
	    name: 'tags',
	    displayKey: 'name',
    	valueKey: 'name',
	    source: tagsEvent.ttAdapter()
	  }
	});

	//
	var tagsIndividual = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 
		{
			url: baseUrl + '/individual/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		},
		remote: 
		{
			url: baseUrl + '/individual/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		}
	});
	// kicks off the loading/processing of `local` and `prefetch`
	tagsIndividual.initialize();

	$('#Individual-tag_backend').tagsinput({
	  typeaheadjs: {
	    name: 'tags',
	    displayKey: 'name',
    	valueKey: 'name',
	    source: tagsIndividual.ttAdapter()
	  }
	});

	$('a[class^=cls-select-]').on('click', function(){
		var chkAll = false;
		if($(this).text() == 'Select All')
			chkAll = true
		$(this).text(chkAll ? 'Deselect All' : 'Select All');
		var mod = $(this).attr('class').replace('cls-select-', '');
		$('.access-'+ (mod=='' ? '0' : mod)).prop('checked', chkAll);
		// alert(mod);
		return false;
	});
});

function updateQuickInfo()
{
	return false;
}


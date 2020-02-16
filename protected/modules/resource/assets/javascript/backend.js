$(function() {
	//
	var tagsResource = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 
		{
			url: baseUrl + '/resource/resource/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		},
		remote: 
		{
			url: baseUrl + '/resource/resource/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		}
	});
	// kicks off the loading/processing of `local` and `prefetch`
	tagsResource.initialize();

	$('#Resource-tag_backend').tagsinput({
	  typeaheadjs: {
	    name: 'tags',
	    displayKey: 'name',
    	valueKey: 'name',
	    source: tagsResource.ttAdapter()
	  }
    });
});
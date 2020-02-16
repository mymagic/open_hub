$(function() {
    
    //
	var tagsChallenge = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 
		{
			url: baseUrl + '/challenge/challenge/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		},
		remote: 
		{
			url: baseUrl + '/challenge/challenge/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		}
	});
	// kicks off the loading/processing of `local` and `prefetch`
	tagsChallenge.initialize();

    $('#Challenge-tag_backend').tagsinput({
        typeaheadjs: {
            name: 'tags',
            displayKey: 'name',
            valueKey: 'name',
            source: tagsChallenge.ttAdapter()
        }
    });
});
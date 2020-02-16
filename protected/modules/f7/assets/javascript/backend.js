$(function() {
    //
	var tagsIntake = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 
		{
			url: baseUrl + '/f7/intake/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		},
		remote: 
		{
			url: baseUrl + '/f7/intake/getTagsBackend',
			filter: function(list) {
			  return $.map(list, function(tag) { return { name: tag }; });
			}
		}
	});
	// kicks off the loading/processing of `local` and `prefetch`
	tagsIntake.initialize();

    $('#Intake-tag_backend').tagsinput({
        typeaheadjs: {
            name: 'tags',
            displayKey: 'name',
            valueKey: 'name',
            source: tagsIntake.ttAdapter()
        }
    });
});
<?php $this->layoutParams['form'] = $form; ?>

<?php $submissionPartial = trim($this->renderPartial('_submissionPartial', array('model' => $form), true)); echo $submissionPartial; ?>
<?php if (empty($submissionPartial)):?><hr /><?php endif; ?>

<?php if (isset($submission->jsonArray_extra) && !empty($submission->jsonArray_extra->text_note)): ?><?php echo Notice::inline($submission->jsonArray_extra->text_note, Notice_INFO) ?><?php endif; ?>
<?php echo $htmlForm?>

<script>

$( document ).ready(function() {

	function checkIfOrganizationIsAvailable(title, callback)
        {
            $.post("/api/getOrganizationByTitle", { title: title })
                .done(function( data ) {
						callback(title, data);
				});
		}

	///////// Check Organization Availability //////
	if( $('#startup').is('input:text') ) {
		$('#startup').focusout(function() {
			var title = $('#startup').val();
			checkIfOrganizationIsAvailable(title, toggleErrorOnOrganizationAvailability)	
		});
	}

	function toggleErrorOnOrganizationAvailability(title, data)
	{
		if (data.data!=null) 
			$('#startup-alert').show();
		else
			$('#startup-alert').hide();
	}
	/////////////// End Checking ///////////////////

    /////////////// Modal ////////////////////////

        $('a[data-target="#Organization-Modal"]').click(function() {
            $('#org-alert-modal').hide();
            if ($('#startup').val() !='' && $('#startup').is('input:text'))
                $('#org-name-modal').val($('#startup').val());
        });

        $(document).on('click', 'button', function(data){

            var e = document.getElementById(data.target.id);
            if(e == null) return;
            if(e.id == 'org-button-modal')
            {
				event.preventDefault();

                $( "#org-name-modal" ).on("keyup keydown", function () {
                    $('#org-alert-modal').hide(); 
                });
                
                var title = $('#org-name-modal').val();
				checkIfOrganizationIsAvailable(title, checkAndCreateOrgCallback);
            }
		});
		
		function checkAndCreateOrgCallback(title, data)
		{
			if(data.data != null)
				$('#org-alert-modal').show();
			else
			{
				var website = $('#org-url-modal').val();
				var oneliner = $('#org-oneliner-modal').val();
				//var title = $('#org-name-modal').val();
				createOrganization(title, website, oneliner);
			}
		}
        
        function createOrganization(title, website, oneliner)
        {
            $.post("/api/setOrganization", 
                { 
                    title: title,
                    website: website,
                    oneliner: oneliner
                }
            )
            .done(function( data ) {
                if(data.status=='success')
                {
                    $('#Organization-Modal').modal('toggle');
                    location.reload(true);
                }
            });
        }
	/////////////// Modal End ///////////////////
	
	////////////// Form autosave //////////////////
	$('#auto-save-span').css('display','none');
	setInterval(function(){
		var form = $('#f7-form');
		var action = form.attr('action');
		a = window.location.href.split('/');
		if(a[a.length-1].trim() !="" && !isNaN(a[a.length-1]) && a.length == 8)
		{	
			var serializedForm = form.serialize();

			$.post(action, serializedForm, function(data){

				}).done(function() {showAutoSave();});
		}
	},30000);

	function showAutoSave()
	{
		$('#auto-save-span').css('display','block');
		if($("#auto-save-span").css('opacity')==1)
			$("#auto-save-span").delay(4000).fadeTo('slow',0);
		else
		{
			$("#auto-save-span").fadeTo('fast',1);
			$("#auto-save-span").delay(4000).fadeTo('slow',0);
		}
	}
	
    ////////////// Form autosave End///////////////    
    if (!$('select[data-class="industry"]').find(":selected").text().toLowerCase().startsWith('other'))
     $('#industry-other, label[for=industry-other]').hide();
	
	$(document).on('change', 'select', function(data){

		model = $(this).data("class");
        if(data.target == null) return;
		var e = document.getElementById(data.target.id);
		var selectedItem = e.options[e.selectedIndex].text;
	

		if (model == 'organization')
		{
			$.post("/api/getOrganizationByTitle", { title: selectedItem  })
  			.done(function( data ) {
    			$('#website').val(data.data.urlWebsite);
				$('#idea').val(data.data.textOneliner);
  			});
			  
			$.post("/api/getUsersByOrganization", { title: selectedItem  })
  			.done(function( data ) {
				console.log(data);
				$('#fname1').val(data.data.fullName);
				$('#fic1').val(data.data.icNumber);
				$('#femail1').val(data.data.email);
				$('#fcontact1').val(data.data.email);
  			});
        }
        else if (model == 'industry')
        {
            if (selectedItem.toLowerCase().startsWith('other'))
                $('#industry-other, label[for=industry-other]').show();
			else
			{
                $('#industry-other, label[for=industry-other]').hide();
				$('#industry-other').val('');
			}
        }
	});	
} ); 

//////// Google Place Script Starts:////////
var autocomplete;

function initAutocomplete() {

	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */(document.getElementById('google_place_autocomplete')),
		{types: ['geocode']
	});

	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {

	var place = autocomplete.getPlace();

	var address = place.formatted_address;
	var lat_lng = place.geometry.location.lat() + "," + place.geometry.location.lng();
	var place_id = place.place_id;

	if (document.getElementById('google_place_autocomplete'))
	document.getElementById('google_place_autocomplete').value = address;

	if (document.getElementById('google_lat_lng'))
	document.getElementById('google_lat_lng').value = lat_lng;

	if (document.getElementById('google_address'))
	document.getElementById('google_address').value = address;

	if (document.getElementById('google_place_id'))
	document.getElementById('google_place_id').value = place_id;
}

function geolocate() {
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};

			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
			});

				autocomplete.setBounds(circle.getBounds());
			});
	}
}

//Reverse
function geocodePlaceId(placeId) {
    geocoder.geocode({'placeId': placeId}, function(results, status) {
    	if (status === 'OK') {
			if (results[0]) {
				console.log(results[0]);
			}
    	}
	});
}
</script>

<?php 
	$url = sprintf('https://maps.googleapis.com/maps/api/js?key=%s&libraries=places&callback=initAutocomplete', Yii::app()->params['googleMapApiKey']);
?>

<script src="<?php echo $url ?>" async defer></script>
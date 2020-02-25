<h4>Resource <small>resource2organization</small></h4>
<ol>
<?php foreach ($model->resources as $resource) {
	echo sprintf('<li>#%s %s</li>', $resource->id, $resource->title);
}?>
</ol>
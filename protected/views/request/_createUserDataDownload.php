<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        dl {
        width: 100%;
        overflow: hidden;
        padding: 0;
        margin: 0
        }
        dt {
        float: left;
        width: 30%;
        padding: 0;
        margin: 0
        }
        dd {
        float: left;
        width: 70%;
        padding: 0;
        margin: 0;
        }
    </style>
</head>
<body>

<div class="container">

<h2>User Profile</h2>
<dl>
<?php foreach ($json['userProfile'] as $key => $item): ?>
    <dt><?php echo $item['label'] ?></dt>
    <dd><?php echo Html::encodeDisplay($item['value']) ?></dd>
<?php endforeach; ?>
</dl>


<?php if (!empty($json['roles'])): ?>
<hr />
<h2>User Roles</h2>
<?php foreach ($json['roles'] as $role): ?>
<dl>
    <?php foreach ($role as $key => $item): ?>
        <dt><?php echo $item['label'] ?></dt>
        <dd><?php echo Html::encodeDisplay($item['value']) ?></dd>
    <?php endforeach; ?>
</dl>
<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($json['organizations'])): ?>
<hr />
<h2>Companies</h2>
<?php foreach ($json['organizations'] as $organization): ?>
<h3><?php echo $organization['title']['value'] ?></h3>
<dl>
<?php foreach ($organization as $key => $item): ?>
    <?php if ($key == 'title') {
	continue;
} ?>
    <dt><?php echo $item['label'] ?></dt>
    <dd><?php echo Html::encodeDisplay($item['value']) ?></dd>
<?php endforeach; ?>
</dl>
<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($json['eventRegistrations'])): ?>
<hr />
<h2>Registered Event</h2>

<?php foreach ($json['eventRegistrations'] as $year => $events): ?>
<h3><?php echo $year ?></h3>
<dl>
<?php foreach ($events as $event): ?>
<h4><?php echo $event['title']['value'] ?></h4>
<?php foreach ($event as $key => $item): ?>
    <?php if ($key == 'title') {
	continue;
} ?>
    <dt><?php echo $item['label'] ?></dt>
    <dd><?php echo Html::encodeDisplay($item['value']) ?></dd>
<?php endforeach; ?>
<?php endforeach; ?>
</dl>
<?php endforeach; ?>
<?php endif; ?>


<?php if (!empty($json['formSubmissions'])): ?>
<hr />
<h2>Form Submissions</h2>
<?php foreach ($json['formSubmissions'] as $formSubmission): ?>
<dl>
<?php foreach ($formSubmission as $key => $item): ?>
<?php if ($key == 'jsonData' || $key == 'htmlData') {
	continue;
} ?>
    <dt><?php echo $item['label'] ?></dt>
    <dd><?php echo Html::encodeDisplay($item['value']) ?></dd>
<?php endforeach; ?>
<h3>Data</h3>
<?php echo $formSubmission['htmlData']['value'] ?>
</dl>
<?php endforeach; ?>
<?php endif; ?>


<?php if (!empty($json['actFeeds'])):?>
<hr />
<h2>Activity Feeds</h2>
<?php foreach ($json['actFeeds'] as $year => $actFeeds): ?>
    <?php if (empty($actFeeds)) {
	continue;
} ?>
    <h3><?php echo $year ?></h3>
    <?php foreach ($actFeeds as $date => $actFeeds2): ?>
        <h4><?php echo $date ?></h4>
        <?php foreach ($actFeeds2 as $time => $actFeeds3): ?>
            <h5><?php echo $time ?></h5>
            <ol>
            <?php foreach ($actFeeds3 as $actFeed): ?>
            <li><dl>
            <?php foreach ($actFeed as $key => $item): ?>
                <dt><?php echo ucwords($key) ?></dt>
                <dd><?php echo Html::encodeDisplay($item) ?></dd>
            <?php endforeach; ?>
            </dl></li>
            <?php endforeach; ?>
            </ol>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>

</div>
</body>
</html>

<?php //print_r($json)?>
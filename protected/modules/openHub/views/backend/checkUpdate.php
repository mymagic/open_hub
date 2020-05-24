<p>
    Running Version: <?php echo $versionRunning?>
    <?php if ($canUpdate): ?>
        <span class="label label-primary">Update Available</span>
    <?php else: ?>
        <span class="label lable-default">No Update Available</span>
    <?php endif; ?>
</p>

<hr />

<h3>Latest Released</h3>
<p>Version: <?php echo $versionReleased ?></p>
<p><?php echo(nl2br($latestRelease['body'])) ?></p>
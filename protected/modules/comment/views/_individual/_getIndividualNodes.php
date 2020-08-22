<?php $countComments = $model->countAllComments(); $comments = $model->getActiveComments(10); $countCommentBalance = $countComments - 10; ?>
<h4>Comments</h4>
<ol>
<?php foreach ($comments as $comment) {
	echo sprintf('<li>@%s: %s</li>', $comment->creator_fullname, $comment->html_content);
}?>
<?php if ($countCommentBalance > 0):?><li><?php echo $countCommentBalance; ?> more...</li><?php endif; ?>
</ol>
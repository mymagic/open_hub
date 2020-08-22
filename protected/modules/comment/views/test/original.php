<?php

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/viima-comment/css/jquery-comments.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/viima-comment/data/comments-data.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/viima-comment/js/jquery-comments.js');
Yii::app()->clientScript->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.0/jquery.textcomplete.js');

?>

<script type="text/javascript">
$(function() {
    var commentContainerId = '#comments-container';
    var saveComment = function(data) {
        // Convert pings to human readable format
        $(data.pings).each(function(index, id) {
            
            var user = usersArray.filter(function(user){return user.id == id})[0];
            data.content = data.content.replace('@' + id, '@' + user.fullname);
        });

        return data;
    }
    $(commentContainerId).comments({
        profilePictureURL: '<?php echo $user->profile->image_avatar ?>',
        currentUserId: <?php echo $user->id ?>,
        roundProfilePictures: true,
        textareaRows: 1,
        enableUpvoting: true,
        enableAttachments: false,
        enableHashtags: true,
        enablePinging: true,
        enableReplying: false,
        enableNavigation: false,
        getUsers: function(success, error) {
            setTimeout(function() {
                success(usersArray);
            }, 500);
        },
        getComments: function(success, error) {
            setTimeout(function() {
                success(commentsArray);
            }, 500);
        },
        postComment: function(data, success, error) {
            setTimeout(function() {
                success(saveComment(data));
            }, 500);
        },
        putComment: function(data, success, error) {
            setTimeout(function() {
                success(saveComment(data));
            }, 500);
        },
        deleteComment: function(data, success, error) {
            setTimeout(function() {
                success();
            }, 500);
        },
        upvoteComment: function(data, success, error) {
            setTimeout(function() {
                success(data);
            }, 500);
            
        },
        uploadAttachments: function(dataArray, success, error) {
            setTimeout(function() {
                success(dataArray);
            }, 500);
        },
    });
});
</script>
<div id="comments-container" data-object-key="test"></div>
<?php

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/viima-comment/css/jquery-comments.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/viima-comment/js/jquery-comments.js');
Yii::app()->clientScript->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.0/jquery.textcomplete.js');

?>

<div id="comments-container" data-object-key="event-<?php echo $event->id ?>"></div>

<script type="text/javascript">
$(function() {
    var usersArray = [];
    var commentsArray = [];
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
        timeFormatter: function(time) {
            return moment(time).fromNow();
        },
        getUsers: function(success, error) {
            $.ajax({
                type: 'get',
                url: '/comment/api/getUsers/',
                success: function(result) {
                    usersArray = result.data;
                    success(result.data);
                },
                error: error
            });
        },
        getComments: function(success, error) {
            $.ajax({
                type: 'get',
                url: '/comment/api/getComments/?key='+$(commentContainerId).data('objectKey'),
                success: function(result) {
                    $('.spinner').hide();
                    if(result.status='success' && result.data && result.data.length>0)
                        success(result.data);
                },
                error: error
            });
        },
        postComment: function(data, success, error) {
            $.ajax({
                type: 'post',
                url: '/comment/api/postComment/?key='+$(commentContainerId).data('objectKey'),
                data: saveComment(data),
                success: function(result) {
                    success(saveComment(data));
                },
                error: error
            });
        },
        putComment: function(data, success, error) {
            $.ajax({
                type: 'post',
                url: '/comment/api/updateComment/' + data.id,
                data: saveComment(data),
                success: function(result) {
                    success(saveComment(data));
                },
                error: error
            });
        },
        deleteComment: function(data, success, error) {
            $.ajax({
                type: 'delete',
                url: '/comment/api/deleteComment/' + data.id,
                success: function(result) {
                    success();
                },
                error: error
            });
        },
        upvoteComment: function(data, success, error) {
            $.ajax({
                type: 'post',
                url: '/comment/api/upvoteComment/',
                data: {
                    commentId: data.id
                },
                success: function(result) {
                    success(data);
                },
                error: error
            });
            
        },
        uploadAttachments: function(dataArray, success, error) {
            setTimeout(function() {
                success(dataArray);
            }, 500);
        },
    });
});
</script>
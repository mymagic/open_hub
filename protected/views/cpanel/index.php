<?php
$this->breadcrumbs=array(
    'Dashboard'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

?>

<div id="sampleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="skip-btn">skip this step</span>

                </button>
                 <h4 class="modal-title" id="myTitle">MaGIC Dashboard Walkthrough</h4>

            </div>
            <div class="modal-body">
                <div id="step1"> 
                    <div id="container-welcome">
                        <div class="col-md-4 col-xs-12 col-centered"><img src="https://cdn.dribbble.com/users/722835/screenshots/4082720/bot_icon.gif"></div>
                        <div class="col-md-8 col-xs-12"><h2 class="modal-subtitle">Welcome!</h2> 
                    <p>Hello! I’m Alif, Product Manager for Central at MaGIC. If you’re new here, allow me to introduce MaGIC Dashboard, a digital platform for curated entrepreneurial services and resources provided by MaGIC and other providers in one place.  Let’s get you settled in</p></div>
                        <div style="clear:both"></div>
                    </div>
                    
                    <button class="btn-forward btn-sd-green" id="btnEndStep1">Next</button>
                </div>
                <div id="step2" class="hideMe"> 
                    <h2 class="modal-subtitle">Services Available on MaGIC</h2>
                    <br>
                    <p style="margin-bottom: 20px;">Here are the available services provided by MaGIC. As we go further onward with our journeys and adventures together, MaGIC will add more services here and will inform you as they are added. For now, you can select the listed services that interest you the most.</p>
<!--                             <?php echo $username ?>
-->                        <div class="section group-services">

                    <?php foreach ($listServices as $list): ?>

                      <a class="col-services span_1_of_3 button-desc" href="javascript:void(0);" data-slug="<?php echo $list['slug']?>">
                        <span class="away"><?php echo $list['title']?></span>
                        <span class="over"><?php echo $list['textOneliner']?></span>
                      </a>
  
                  <?php endforeach; ?>
                  </div>
                
                    <button class="btn-forward btn-sd-green" id="btnEndStep2">Next</button>
                </div>
                <div id="step3" class="hideMe"> 
                    <h2 class="modal-subtitle">That's awesome!</h2>
                    <br>
                    <p>And you’re done!</p><p>Feel free to explore your MaGIC Dashboard and if you need more information, please refer to the <a href="/cpanel/guidelines">Guidelines</a> available under the Support section. Drop us a comment or reach out to us on the <a href="/cpanel/guidelines">Q&amp;A Forum</a> section.</p>
                    <button class="btn-forward btn-sd-green" id="btnEndStep3">Okay, done!</button>
                </div>
            </div>
              <ul id="progressbar">
                <li class="active">1</li>
                <li>2</li>
                <li>3</li>
            </ul>
        </div>
    </div>
</div>
    <script type="text/javascript">

    $(window).on('load',function(){
            <?php if(!$is_popup_process_completed) { ?>
              $("#sampleModal").fadeIn('fast', function() {
                     $(this).modal('show');
              });
            <?php } ?>
           

        
    });

    $("#btnEndStep1").click(function () {
        $('ul').children().removeClass('active');
        $("#progressbar li").eq(1).addClass('active');
        $("#progressbar li").eq(0).addClass('done');
        $("#step1").addClass('hideMe');
        $("#step2").removeClass('hideMe');
    });
    $("#btnEndStep2").click(function () {
        
        var selected_service = [];
        $("#sampleModal").find("#step2 .group-services a").each(function(k,v){
            if($(this).hasClass("active"))
            {
                selected_service.push($(this).data("slug"));
            }
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('cpanel/setUserService'); ?>',
            data:{'<?php echo Yii::app()->request->csrfTokenName; ?>':'<?php echo Yii::app()->request->csrfToken; ?>', selected_service:selected_service},
            success:function(data)
            {
                var result = JSON.parse(data);
                if(result.status == 1)
                {
                    $("#progressbar li").eq(1).removeClass('active');
                    $("#progressbar li").eq(1).addClass('done');
                    $("#progressbar li").eq(2).addClass('active');
                    $("#step2").addClass('hideMe');
                    $("#step3").removeClass('hideMe');
                }
                else
                {
                    alert(result.message);
                }
            }
        });
    });
    $("#btnEndStep3").click(function () {
        // Whatever your final validation and form submission requires
        $("#sampleModal").modal("hide");
           $(".content-content").fadeIn('slow', function() {
             window.location.href = '/cpanel/services';
          });
    });
    
    </script>


    <script type="text/javascript">
        $(function () {

            $(".col-services.span_1_of_3").click(function () {
                $(this).toggleClass("active");
                e.preventDefault(); /*ignores actual link*/
            });

        });

    </script>

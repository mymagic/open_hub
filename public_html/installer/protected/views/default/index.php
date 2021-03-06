<?php echo CHtml::beginForm(); ?>
<div class="row">
<div class="col-8">
    <h4>Basic Setting</h4>
    <div class="row">
    <div class="col-8">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'appName'); ?>
            <?php echo CHtml::activeTextField($model, 'appName', array('class' => 'form-control', 'placeholder' => 'My Hub', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'environment'); ?>
            <?php echo CHtml::activeDropDownList($model, 'environment', array(
				'production' => Yii::t('installer', 'Production'),
				'staging' => Yii::t('installer', 'Staging'),
				'testing' => Yii::t('installer', 'Testing'),
				'development' => Yii::t('installer', 'Development'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'domainName'); ?>
            <?php echo CHtml::activeTextField($model, 'domainName', array('class' => 'form-control', 'placeholder' => 'myhub.io', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'publicEmail'); ?>
            <?php echo CHtml::activeTextField($model, 'publicEmail', array('class' => 'form-control', 'placeholder' => 'hello@myhub.io', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Greetings</p>
        <p><b>Thanks for choosing Open Hub</b> to manage your startup ecosystem. Open Hub is an open source project by MaGIC.</p>

        <p>Let's start by naming your application.</p>

        <p>We do not recommend using installer to setup development &amp; testing environment.</p>

        <p>Base on your need, you may install directly to the domain (e.g. www.mymagic.my) or under a sub domain (recommended, e.g. central.mymagic.my). Directory base installation is not supported (e.g. mymagic.my/central).</p>
    </small>
</div>
</div>

<hr />



<div class="row">
<div class="col-8">
    <h4>Authentication</h4>
    <div class="row">
        <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'authAdapter'); ?>
            <?php echo CHtml::activeDropDownList($model, 'authAdapter', array(
				'local' => Yii::t('installer', 'Local'),
				'connect' => Yii::t('installer', 'MaGIC Connect'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
        </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>You can choose either want to use MaGIC Connect or Local for Authentication</p>
    </small>
</div>
</div>



<hr />

<div class="row authAdapter-connect">
<div class="col-8">
    <h4>MaGIC Connect</h4>
    <div class="row">
    <div class="col-10">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'connectUrl'); ?>
            <?php echo CHtml::activeTextField($model, 'connectUrl', array('class' => 'form-control', 'placeholder' => '//account.mymagic.my', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'connectClientId'); ?>
            <?php echo CHtml::activeTextField($model, 'connectClientId', array('class' => 'form-control', 'placeholder' => '99', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'connectSecretKey'); ?>
            <?php echo CHtml::activeTextField($model, 'connectSecretKey', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) ?>
        </div>
        </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Used MaGIC Connect for Single Sign On.</p>
        <p>Email tech@mymagic.my (please include your installation's domain name) to acquire a client ID and secret key.</p>
    </small>
</div>
</div>

<hr class="authAdapter-connect" />

<div class="row">
<div class="col-8">
    <h4>Super Admin</h4>
    <div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'adminUsername'); ?>
            <?php echo CHtml::activeTextField($model, 'adminUsername', array('class' => 'form-control', 'placeholder' => 'admin@myhub.io', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Create a super admin account for this installation. You will be using this to login the backend.</p>
        <p>Password will be generated by system and send to this email.</p>
    </small>
</div>
</div>

<hr />

<div class="row">
<div class="col-8">
    <h4>Database</h4>
    <div class="row">
    <div class="col-10">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'dbHost'); ?>
            <?php echo CHtml::activeTextField($model, 'dbHost', array('class' => 'form-control', 'placeholder' => 'localhost', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'dbPort'); ?>
            <?php echo CHtml::activeTextField($model, 'dbPort', array('class' => 'form-control', 'placeholder' => '3306', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'dbName'); ?>
            <?php echo CHtml::activeTextField($model, 'dbName', array('class' => 'form-control', 'placeholder' => 'myhub', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'dbUsername'); ?>
            <?php echo CHtml::activeTextField($model, 'dbUsername', array('class' => 'form-control', 'placeholder' => 'root', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'dbPassword'); ?>
            <?php echo CHtml::activeTextField($model, 'dbPassword', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Open Hub supported MySQL or MariaDB database.</p>
        <p>Please make sure the database exists and it will be install fresh.</p>
    </small>
</div>
</div>

<hr />


<div class="row">
<div class="col-8">
    <h4>File Storage</h4>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'storageMode'); ?>
            <?php echo CHtml::activeDropDownList($model, 'storageMode', array(
				'local' => Yii::t('installer', 'Local'),
				's3' => Yii::t('installer', 'S3'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>We strongly recommend using AWS S3 for File Storage.</p>
    </small>
</div>
</div>

<div class="row" id="s3StorageDetails">
<div class="col-8">
    <h4>S3 File Storage</h4>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3AccessKey'); ?>
            <?php echo CHtml::activeTextField($model, 's3AccessKey', array('class' => 'form-control', 'placeholder' => '', 'required' => false)) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3SecretKey'); ?>
            <?php echo CHtml::activeTextField($model, 's3SecretKey', array('class' => 'form-control', 'placeholder' => '', 'required' => false)) ?>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3Region'); ?> (<a href="https://docs.aws.amazon.com/general/latest/gr/rande.html" target="_blank">Refer list in new window</a>)
            <?php echo CHtml::activeTextField($model, 's3Region', array('class' => 'form-control', 'placeholder' => 'ap-southeast-1', 'required' => false)) ?>
        </div>
        </div>
    </div>
    <div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3PublicBucketName'); ?>
            <?php echo CHtml::activeTextField($model, 's3PublicBucketName', array('class' => 'form-control', 'placeholder' => 'myhub-hub', 'required' => false)) ?>
        </div>
    </div>
    <div class="col-8">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3PublicBucketUrl'); ?>
            <?php echo CHtml::activeTextField($model, 's3PublicBucketUrl', array('class' => 'form-control', 'placeholder' => 'https://myhub-hub.s3.amazonaws.com', 'required' => false)) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3SecureBucketName'); ?>
            <?php echo CHtml::activeTextField($model, 's3SecureBucketName', array('class' => 'form-control', 'placeholder' => 'myhub-hub-secure', 'required' => false)) ?>
        </div>
    </div>
    <div class="col-8">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 's3SecureBucketUrl'); ?>
            <?php echo CHtml::activeTextField($model, 's3SecureBucketUrl', array('class' => 'form-control', 'placeholder' => 'https://myhub-hub-secure.s3.amazonaws.com', 'required' => false)) ?>
        </div>
    </div>
    </div>
    
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Base on module requirement, some user uploaded file will be store securely.</p>
    </small>
</div>
</div>

<hr />



<div class="row">
<div class="col-8">
    <h4>SMTP Server</h4>
    <div class="row">
    <div class="col-10">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'smtpHost'); ?>
            <?php echo CHtml::activeTextField($model, 'smtpHost', array('class' => 'form-control', 'placeholder' => 'smtp.mandrillapp.com', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'smtpPort'); ?>
            <?php echo CHtml::activeTextField($model, 'smtpPort', array('class' => 'form-control', 'placeholder' => '587', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'smtpUsername'); ?>
            <?php echo CHtml::activeTextField($model, 'smtpUsername', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'smtpPassword'); ?>
            <?php echo CHtml::activeTextField($model, 'smtpPassword', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'smtpOutgoingEmail'); ?>
            <?php echo CHtml::activeTextField($model, 'smtpOutgoingEmail', array('class' => 'form-control', 'placeholder' => 'noreply@myhub.io', 'required' => 'required')) ?>
        </div>
        </div>
    </div>
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Open Hub require SMTP server to send out emails.</p>
        <p>We recommend using Mandrill (Mailchimp transactional email delivery service).</p>
    </small>
</div>
</div>

<hr />

<div class="row">
<div class="col-8">
    <h4>Cache</h4>
    <div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'cacheEnabled'); ?>
            <?php echo CHtml::activeDropDownList($model, 'cacheEnabled', array(
				'false' => Yii::t('installer', 'No'),
				'true' => Yii::t('installer', 'Yes'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'cacheDriver'); ?>
            <?php echo CHtml::activeDropDownList($model, 'cacheDriver', array(
				'CFileCache' => Yii::t('installer', 'Local File Storage'),
				'CRedisCache' => Yii::t('installer', 'Redis Cache Server'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-10">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'cacheHostname'); ?>
            <?php echo CHtml::activeTextField($model, 'cacheHostname', array('class' => 'form-control', 'placeholder' => 'localhost')) ?>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'cachePort'); ?>
            <?php echo CHtml::activeTextField($model, 'cachePort', array('class' => 'form-control', 'placeholder' => '6379')) ?>
        </div>
    </div>
    </div>
    
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Open Hub use cache to speed up system performance.</p>
        <p>We strongly recommend enable caching and use Redis cache server.</p>
    </small>
</div>
</div>

<hr />

<div class="row">
<div class="col-8">
    <h4>Elasticsearch</h4>
    <div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'esEnabled'); ?>
            <?php echo CHtml::activeDropDownList($model, 'esEnabled', array(
				'false' => Yii::t('installer', 'No'),
				'true' => Yii::t('installer', 'Yes'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col-6">
        
    </div>
    </div>
    <div class="row">
    <div class="col-8">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'esEndpoint'); ?>
            <?php echo CHtml::activeTextField($model, 'esEndpoint', array('class' => 'form-control', 'placeholder' => '')) ?>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'esRegion'); ?>
            <?php echo CHtml::activeTextField($model, 'esRegion', array('class' => 'form-control', 'placeholder' => '')) ?>
        </div>
    </div>
    </div>

    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'esKey'); ?>
            <?php echo CHtml::activeTextField($model, 'esKey', array('class' => 'form-control', 'placeholder' => '')) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'esSecret'); ?>
            <?php echo CHtml::activeTextField($model, 'esSecret', array('class' => 'form-control', 'placeholder' => '')) ?>
        </div>
    </div>
    </div>
    
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Open Hub use Elasticsearch to optimize search performance and store users' acitivity log use for auditing.</p>

        <p>We strongly recommend enable Elasticsearch and use AWS Elasticsearch Service.</p>
    </small>
</div>
</div>

<hr />

<div class="row">
<div class="col-8">
    <h4>Neo4J</h4>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'neo4jEnabled'); ?>
            <?php echo CHtml::activeDropDownList($model, 'neo4jEnabled', array(
				'false' => Yii::t('installer', 'No'),
				'true' => Yii::t('installer', 'Yes'),
			), array('class' => 'form-control', 'required' => 'required')) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'neo4jProtocol'); ?>
            <?php echo CHtml::activeTextField($model, 'neo4jProtocol', array('class' => 'form-control', 'placeholder' => 'bolt')) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-10">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'neo4jHost'); ?>
            <?php echo CHtml::activeTextField($model, 'neo4jHost', array('class' => 'form-control', 'placeholder' => 'localhost')) ?>
        </div>
    </div>
    <div class="col-2">
    <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'neo4jPort'); ?>
            <?php echo CHtml::activeTextField($model, 'neo4jPort', array('class' => 'form-control', 'placeholder' => '7687')) ?>
        </div>
    </div>
    </div>

    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'neo4jUsername'); ?>
            <?php echo CHtml::activeTextField($model, 'neo4jUsername', array('class' => 'form-control', 'placeholder' => '')) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'neo4jPassword'); ?>
            <?php echo CHtml::activeTextField($model, 'neo4jPassword', array('class' => 'form-control', 'placeholder' => '')) ?>
        </div>
    </div>
    </div>
    
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Open Hub use Neo4J for its Graph Database function.</p>
        <p>We strongly recommend you to enable Neo4J.</p>
        <p>Default modules such as 'Recommendation' required this to recommend related resources to users base on their interest.</p>
    </small>
</div>
</div>

<hr />

<div class="row">
<div class="col-8">
    <h4>3rd Party Services</h4>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'googleMapApiKey'); ?>
            <?php echo CHtml::activeTextField($model, 'googleMapApiKey', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo CHtml::activeLabel($model, 'openExchangeRatesAppId'); ?>
            <?php echo CHtml::activeTextField($model, 'openExchangeRatesAppId', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) ?>
        </div>
    </div>
    </div>
    
</div>
<div class="col-4">
    <small class="form-text text-muted">
        <p>Open Hub required these 3rd party services to fully function.</p>
    </small>
</div>
</div>

<hr />

<button type="submit" class="btn btn-primary">Install</button>
<?php echo CHtml::endForm(); ?>

<?php
Yii::app()->clientScript->registerScript('check-form', "
$(document).ready(function(){
    $('[id$=_authAdapter]').on('change', function(){
        $('.authAdapter-connect, .authAdapter-local').hide();
        $('.authAdapter-' + $(this).val()).show();
        if($(this).val()=='connect')
        {
            $('[id$=_connectUrl], [id$=_connectClientId], [id$=_connectSecretKey]').attr('required',true);
        }
        else
        {
            $('[id$=_connectUrl], [id$=_connectClientId], [id$=_connectSecretKey]').attr('required',false).val('');
        }
    }).trigger('change');

    $('[id$=_storageMode]').on('change', function(){
        if($(this).val()=='local')
        {
            $('#s3StorageDetails').addClass('d-none');
            $('#s3StorageDetails').find('[id^=SetupForm_]').attr('required',false).val('');
        }
        else if($(this).val()=='s3')
        {
            $('#s3StorageDetails').removeClass('d-none');
            $('#s3StorageDetails').find('[id^=SetupForm_]').attr('required',true);
        }
    }).trigger('change');

    $('[id$=_cacheDriver]').on('change', function(){
        $('[id$=_cacheHostname],[id$=_cachePort]').attr('required', ($(this).val()=='CRedisCache' ? true : false));
        if($(this).val()!='CRedisCache')
        {
            $('[id$=_cacheHostname],[id$=_cachePort]').val('');
        }
    }).trigger('change');

    $('[id$=_esEnabled]').on('change', function(){
        $('[id$=_esEndpoint], [id$=_esRegion], [id$=_esKey], [id$=_esSecret]').attr('required', ($(this).val()=='false' ? false : true));
        if($(this).val()=='false')
        {
            $('[id$=_esEndpoint], [id$=_esRegion], [id$=_esKey], [id$=_esSecret]').val('');
        }
    }).trigger('change');

    $('[id$=_neo4jEnabled]').on('change', function(){
        $('[id$=_neo4jProtocol], [id$=_neo4jHost], [id$=_neo4jPort], [id$=_neo4jUsername], [id$=_neo4jPassword]').attr('required', ($(this).val()=='false' ? false : true));
        if($(this).val()=='false')
        {
            $('[id$=_neo4jProtocol], [id$=_neo4jHost], [id$=_neo4jPort], [id$=_neo4jUsername], [id$=_neo4jPassword]').val('');
        }
    }).trigger('change');
});
", CClientScript::POS_END);
?>

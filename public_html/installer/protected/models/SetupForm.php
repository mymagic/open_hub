<?php
class SetupForm extends CFormModel
{
    public $envs;

    public $appName;
	public $environment;
	public $domainName;
	public $publicEmail;
    
    public $connectUrl;
    public $connectClientId;
    public $connectSecretKey;

    public $adminUsername;

    public $dbName;
    public $dbHost;
    public $dbPort;
    public $dbUsername;
    public $dbPassword;

    public $s3AccessKey;
    public $s3SecretKey;
    public $s3Region;
    public $s3PublicBucketName;
    public $s3PublicBucketUrl;
    public $s3SecureBucketName;
    public $s3SecureBucketUrl;

    public $smtpHost;
    public $smtpPort;
    public $smtpUsername;
    public $smtpPassword;
    public $smtpOutgoingEmail;

    public $cacheEnabled;
    public $cacheDriver;
    public $cacheHostname;
    public $cachePort;

    public $esEnabled;
    public $esEndpoint;
    public $esRegion;
    public $esKey;
    public $esSecret;

    public $neo4jEnabled;
    public $neo4jProtocol;
    public $neo4jHost;
    public $neo4jPort;
    public $neo4jUsername;
    public $neo4jPassword;

    public $googleMapApiKey;
    public $openExchangeRatesAppId;


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
            array('appName, environment, domainName, publicEmail, connectUrl, connectClientId, connectSecretKey, adminUsername, dbName, dbHost, dbPort, dbUsername, dbPassword, s3AccessKey, s3SecretKey, s3Region, s3PublicBucketName, s3PublicBucketUrl, s3SecureBucketName, s3SecureBucketUrl, smtpHost, smtpPort, smtpUsername, smtpPassword, smtpOutgoingEmail, cacheEnabled, esEnabled, neo4jEnabled, googleMapApiKey, openExchangeRatesAppId', 'required'),
            array('connectClientId, dbPort, smtpPort', 'numerical', 'integerOnly'=>true),
			// email has to be a valid email address
			array('publicEmail, adminUsername, smtpOutgoingEmail', 'email'),
			array('neo4jProtocol, neo4jHost, neo4jPort, neo4jUsername, neo4jPassword, esEndpoint, esRegion, esKey, esSecret, cacheDriver, cacheHostname, cachePort', 'safe'),
		);
    }
    
    public function attributeLabels()
	{
		return array(
            'appName'=>Yii::t('installer', 'Name your application'), 
            'environment'=>Yii::t('installer', 'For Environment'), 
            'domainName'=>Yii::t('installer', 'What\'s the domain name pointing to this installation?'),  
            'publicEmail'=>Yii::t('installer', 'What\'s your organisation\'s public email'), 
            
            'connectUrl'=>Yii::t('installer', 'Server URL'), 
            'connectClientId'=>Yii::t('installer', 'Client ID'), 
            'connectSecretKey'=>Yii::t('installer', 'Secret Key'), 

            'adminUsername'=>Yii::t('installer', 'Username'), 
            'dbName'=>Yii::t('installer', 'Database Name'), 
            'dbHost'=>Yii::t('installer', 'Hostname'), 
            'dbPort'=>Yii::t('installer', 'Port'), 
            'dbUsername'=>Yii::t('installer', 'Username'), 
            'dbPassword'=>Yii::t('installer', 'Password'), 
            's3AccessKey'=>Yii::t('installer', 'Access Key'), 
            's3SecretKey'=>Yii::t('installer', 'Secret Key'), 
            's3Region'=>Yii::t('installer', 'S3 Region'), 
            's3PublicBucketName'=>Yii::t('installer', 'Public Bucket Name'), 
            's3PublicBucketUrl'=>Yii::t('installer', 'Public Bucket URL'), 
            's3SecureBucketName'=>Yii::t('installer', 'Secure Bucket Name'), 
            's3SecureBucketUrl'=>Yii::t('installer', 'Secure Bucket URL'), 
            'smtpHost'=>Yii::t('installer', 'Hostname'), 
            'smtpPort'=>Yii::t('installer', 'Port'), 
            'smtpUsername'=>Yii::t('installer', 'Username'), 
            'smtpPassword'=>Yii::t('installer', 'Password'), 
            'smtpOutgoingEmail'=>Yii::t('installer', 'Send From'), 

            'cacheEnabled'=>Yii::t('installer', 'Enable?'), 
            'cacheDriver'=>Yii::t('installer', 'Cache Driver'), 
            'cacheHostname'=>Yii::t('installer', 'Redis Hostname'), 
            'cachePort'=>Yii::t('installer', 'Port'), 
            
            'esEnabled'=>Yii::t('installer', 'Enable?'), 
            'esEndpoint'=>Yii::t('installer', 'Endpoint'), 
            'esRegion'=>Yii::t('installer', 'Region'), 
            'esKey'=>Yii::t('installer', 'Key'), 
            'esSecret'=>Yii::t('installer', 'Secret'), 
            
            'neo4jEnabled'=>Yii::t('installer', 'Enable?'), 
            'neo4jProtocol'=>Yii::t('installer', 'Protocol'), 
            'neo4jHost'=>Yii::t('installer', 'Host'), 
            'neo4jPort'=>Yii::t('installer', 'Port'), 
            'neo4jUsername'=>Yii::t('installer', 'Username'), 
            'neo4jPassword'=>Yii::t('installer', 'Password'), 
            
            'googleMapApiKey'=>Yii::t('installer', 'Google Map API Key'), 
            'openExchangeRatesAppId'=>Yii::t('installer', 'Open Exchange Rates App ID'), 
             
		);
	}
}
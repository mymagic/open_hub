<?php

return array(
	'maintenance' => filter_var(getenv('MAINTENANCE', false), FILTER_VALIDATE_BOOLEAN),
	'dev' => filter_var(getenv('DEV', false), FILTER_VALIDATE_BOOLEAN),
	'cache' => filter_var(getenv('CACHE', true), FILTER_VALIDATE_BOOLEAN),
	'environment' => getenv('ENVIRONMENT', 'development'), // development|staging|production
	'sourceCurrency' => getenv('SOURCE_CURRENCY', 'MYR'),
	'currency' => getenv('CURRENCY', 'MYR'),
	'languages' => envKeySplit(getenv('LANGUAGES', 'en:English;ms:Bahasa Melayu;zh:中文')),
	'frontendLanguages' => envKeySplit(getenv('FRONTEND_LANGUAGES', 'en:English;ms:Bahasa Melayu')),
	'backendLanguages' => envKeySplit(getenv('BACKEND_LANGUAGES', 'en:English;ms:Bahasa Melayu')),
	'autoLanguageLink' => filter_var(getenv('LANGUAGE_AUTO_LINK', false), FILTER_VALIDATE_BOOLEAN),

	// 'rolesCanAccessBackend' => require(dirname(__FILE__) . '/role.php'),

	// cross-origin resource sharing
	'allowedDomains' => require(dirname(__FILE__) . '/cors.php'),

	// this is used in contact page
	'adminEmail' => getenv('ADMIN_EMAIL', 'admin@openhubd.mymagic.my'),
	'webmasterEmail' => getenv('WEBMASTER_EMAIL', 'webmaster@openhubd.mymagic.my'),
	'contactName' => getenv('CONTACT_NAME', 'Enquiries'),
	'contactEmail' => getenv('CONTACT_EMAIL', 'hello@openhubd.mymagic.my'),
	'routineEmails' => explode(';', getenv('ROUTINE_EMAILS', 'admin@openhubd.mymagic.my;cron@openhubd.mymagic.my')),

	'masterDomain' => getenv('MASTER_DOMAIN', 'openhubd.mymagic.my'),
	'masterUrl' => getenv('MASTER_URL', '//openhubd.mymagic.my'),
	'baseDomain' => getenv('BASE_DOMAIN', 'openhubd.mymagic.my'),
	'baseUrl' => getenv('BASE_URL', '//openhubd.mymagic.my'),
	'srcServerUrl' => getenv('SRC_SERVER_URL', '//openhubd.mymagic.my'),

	'baseApiUrl' => getenv('BASE_API_URL', '//api-openhubd.mymagic.my'),
	'enforceApiSSL' => filter_var(getenv('ENFORCE_API_SSL', true), FILTER_VALIDATE_BOOLEAN),
	'enableApiAuth' => filter_var(getenv('ENABLE_API_AUTH', false), FILTER_VALIDATE_BOOLEAN),
	'apiUsername' => getenv('API_USERNAME', 'default'),
	'apiPassword' => getenv('API_PASSWORD', 'secret'),
	'jwtSecret' => getenv('JWT_SECRET', 'thisismysecretkey'),

	// do not change this once setup or user password in db will not match during login
	'saltSecret' => getenv('SALT_SECRET', '0000'),

	'connectUrl' => getenv('CONNECT_URL', '//accountd.mymagic.my'),
	'connectSecretKey' => getenv('CONNECT_SECRET_KEY', '0000'),
	'connectClientId' => getenv('CONNECT_CLIENT_ID', '1'),
	'connectSecretKeyApi' => getenv('CONNECT_SECRET_KEY_API', '0000'),

	's3Region' => getenv('S3_REGION', 'ap-southeast-3'),
	's3Version' => getenv('S3_VERSION', '1990-01-01'),
	's3Url' => getenv('S3_URL', 'https://demo.s3.amazonaws.com'),
	's3Bucket' => getenv('S3_BUCKET', 'my-bucket'),
	's3UrlSecure' => getenv('S3_URL_SECURE', 'https://demo-secure.s3.amazonaws.com'),
	's3BucketSecure' => getenv('S3_BUCKET_SECURE', 'my-secure-bucket'),
	's3UrlSecureExpiryTime' => getenv('S3_URL_SECURE_EXPIRY_TIME', '+1 minutes'),

	'storageMode' => getenv('STORAGE_MODE', 'local'), // local or s3
	'thumbMode' => getenv('THUMB_MODE', 'pre'), // live or pre

	'enableEsLog' => filter_var(getenv('ESLOG_ENABLE', false), FILTER_VALIDATE_BOOLEAN),
	'esLogIndexCode' => getenv('ESLOG_INDEX_CODE', 'log-default'),
	'esLogEndpoint' => getenv('ESLOG_ENDPOINT', '//domain.tld:443'),
	'esLogKey' => getenv('ESLOG_KEY', '0000'),
	'esLogSecret' => getenv('ESLOG_SECRET', '0000'),
	'esLogRegion' => getenv('ESLOG_REGION', 'ap-southeast-3'),

	'enableMixPanel' => filter_var(getenv('MIXPANEL_ENABLE', false), FILTER_VALIDATE_BOOLEAN),
	'mixpanelToken' => getenv('MIXPANEL_TOKEN', '0000'),

	'metaTitle' => getenv('META_TITLE', 'Open Hub'),
	'metaDescription' => getenv('META_DESCRIPTION', ''),
	'metaKeywords' => getenv('META_KEYWORDS', ''),

	'logSentMail' => filter_var(getenv('LOG_SENT_MAIL', true), FILTER_VALIDATE_BOOLEAN),
	'smtpAuth' => filter_var(getenv('SMTP_AUTH', true), FILTER_VALIDATE_BOOLEAN),
	'blockSendMail' => filter_var(getenv('BLOCK_SEND_MAIL', false), FILTER_VALIDATE_BOOLEAN),

	'smtpHost' => getenv('SMTP_HOST', 'smtp.mandrillapp.com'),
	'smtpPort' => getenv('SMTP_PORT', '587'),
	'smtpUsername' => getenv('SMTP_USERNAME', 'noname@domain.tld'),
	'smtpPassword' => getenv('SMTP_PASSWORD', 'secret'),
	'smtpSenderEmail' => getenv('SMTP_SENDER_EMAIL', 'sender@openhubd.mymagic.my'),
	'smtpSenderName' => getenv('SMTP_SENDER_NAME', 'OpenHub'),
	'smtpTestReceiverEmail' => getenv('SMTP_TEST_RECEIVER_EMAIL', 'receiver@gmail.com'),
	'smtpTestReceiverName' => getenv('SMTP_TEST_RECEIVER_NAME', 'Foo Bar'),
	'emailPrefix' => getenv('EMAIL_PREFIX', 'OpenHub'),

	'fbAppId' => getenv('FB_APP_ID', '0000'),

	'paypalSsl' => getenv('PAYPAL_SSL', 'https://www.sandbox.paypal.com/cgi-bin/webscr'),
	'paypalSslHost' => getenv('PAYPAL_SSL_HOST', 'www.sandbox.paypal.com'),
	'paypalSslPort' => getenv('PAYPAL_SSL_PORT', '443'),
	'paypalUrl' => getenv('PAYPAL_URL', 'https://www.sandbox.paypal.com'),
	'paypalBusiness' => getenv('PAYPAL_BUSINESS', 'name-seller@domain.tld'),
	'paypalIsSandbox' => filter_var(getenv('PAYPAL_IS_SANDBOX', true), FILTER_VALIDATE_BOOLEAN),

	'nexmoKey' => getenv('NEXMO_KEY', '0000'),
	'nexmoSecret' => getenv('NEXMO_SECRET', '0000'),
	'nexmoKey2' => getenv('NEXMO_TWO_KEY', '0000'),
	'nexmoSecret2' => getenv('NEXMO_TWO_SECRET', '0000'),
	'mobileFrom' => getenv('MOBILE_FROM', '+60191234567'),
	'mobileVerificationResendLimit' => getenv('MOBILE_VERIFICATION_RESEND_LIMIT', '3'),

	'googleApiKey' => getenv('GOOGLE_API_KEY', '0000'),
	'googleMapApiKey' => getenv('GOOGLE_MAP_API_KEY', '0000'),

	'openExchangeRatesAppId' => getenv('OPEN_EXCHANGE_RATES_APP_ID', '0000'),

	'mailchimpApiKey' => getenv('MAILCHIMP_API_KEY', '0000'),
	'mailchimpLists' => envKeySplit(getenv('MAILCHIMP_LISTS', '')),

	'piwikTrackerUrl' => getenv('PIWIK_TRACKER_URL', '//domain.tld/piwik/'),
	'piwikTokenAuth' => getenv('PIWIK_TOKEN_AUTH', '0000'),

	'thumbnails' => require(dirname(__FILE__) . '/thumbnail.php'),
	'layoutParams' => require(dirname(__FILE__) . '/layoutParams.php'),

	'secureFiles' => require(dirname(__FILE__) . '/secureFiles.php'),

	'moduleDisableNoneCore' => filter_var(getenv('MODULE_DISABLE_NONE_CORE', false), FILTER_VALIDATE_BOOLEAN),
);

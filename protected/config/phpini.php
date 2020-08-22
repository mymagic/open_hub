<?php

@date_default_timezone_set('Asia/Kuala_Lumpur');

// turn off all reporting
error_reporting(E_ERROR);

//php_flag display_errors off
@ini_set('display_errors', '1');

//php_value post_max_size 48M
@ini_set('post_max_size', '48M');

//php_value output_buffering 20480
@ini_set('output_buffering', '20480');

//func_overload setting affects the dokuwiki
//php_value mbstring.func_overload 7

//php_value mbstring.language UTF-8
@ini_set('mbstring.language', 'UTF-8');

//php_value mbstring.internal_encoding UTF-8
@ini_set('mbstring.internal_encoding', 'UTF-8');

//php_value mbstring.http_output UTF-8
@ini_set('mbstring.http_output', 'UTF-8');

//php_flag mbstring.encoding_translation on
@ini_set('mbstring.encoding_translation', '1');

@ini_set('max_execution_time', '120');
@ini_set('max_input_time', '60');
@ini_set('memory_limit', '1024M');
@ini_set('max_input_vars', '10000');

// enabled gzip output comrpession
//@ini_set('output_handler', 'ob_gzhandler');
//@ini_set('zlib.output_compression', '1');
//@ini_set('zlib.output_compression_level', '-1');

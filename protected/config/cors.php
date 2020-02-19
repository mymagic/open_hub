<?php

/**
 *                                                                          
 * CORS is like a more modern version of JSONP-- it allows your application 
 * to circumvent browsers' same-origin policy, so that the responses from   
 * your Sails app hosted on one domain (e.g. example.com) can be received   
 * in the client-side JavaScript code from a page you trust hosted on _some 
 * other_ domain (e.g. mymagic.my).                                         
 *                                                                          
 * @author Rosaan Ramasamy <rosaan@blazesolutions.com.my>                   
 *                                                                          
 */

$cors = array(
    // 'https://domain.tld'
);

$cors = CMap::mergeArray($cors, explode(";", getenv('CORS')));

return $cors;

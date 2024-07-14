<?php
// if accessed directly
if (!defined("ABSPATH")) {
    exit;
}

// requires
require_once dirname(__DIR__) . "/lib/get.php";

/**
 * get json from api-void. 
 * This is a kind of exmaple function how you can implement api request in this plugin
 * @param $request
 * @return WP_HTTP_Response
 */
function get_api_void_data($request)
{
    $apivoid_key = "YOUR_API_KEY";
    $endpoint = "https://endpoint.apivoid.com/sitetrust/v1/pay-as-you-go/?key=" . $apivoid_key . "&host=" . $request->get_param('url');
    $data = make_get_request($endpoint);
    return new WP_REST_Response($data, 200);
}
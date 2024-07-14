<?php

add_action("rest_api_init", "raw_register_rest_api");
/**
 * Register Rest api
 * @return void
 */
function raw_register_rest_api()
{
    register_rest_route("raw/v1", "/api-void", [
        "methods" => "GET",
        "callback" => "get_api_void_data"
    ]);
}
<?php
function setupSession() {
    session_set_cookie_params([
        "lifetime" => 2592000,
        "path" => "/schedule/",
        "domain" => "chanrycz.com",
        "secure" => true,
        "httponly" => false,
        "samesite" => "Lax"
    ]);
    session_name("chanrycz-schedule");
    session_start();
}

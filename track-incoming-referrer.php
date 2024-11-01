<?php
/*
Plugin Name: track-incoming-referrer
Description: Track incoming referrer and write it to any hidden form field with the identifier "referrer".
Version:     1.0.0
Author:      averageradical
License:     GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

function tir_head() {
  $script = <<<HEREDOC
<script>
  // http://stackoverflow.com/a/15724300
  function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
  }

  function writeCookie(name, value) {
    document.cookie = name + "=" + encodeURIComponent(value) + "; path=/";
  }

  // http://stackoverflow.com/a/901144
  function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  if (!getCookie("tir_referrer")) {
    var referrer = document.referrer;
    if (!referrer || referrer.length == 0) {
      // Safari workin weird
      //referrer = getParameterByName("referrer");
      referrer = window.location.href;
    }
    console.log("Writing referrer cookie with " + referrer);
    writeCookie("tir_referrer", referrer);
  } else {
    console.log("Cookie exists with referrer " + getCookie("tir_referrer"));
  }

  function setReferrerOnSubmit() {
    var referrerField = document.getElementById("referrer");
    if (referrerField) {
      referrerField.value = decodeURIComponent(getCookie("tir_referrer"));
      console.log("setReferrerOnSubmit: " + referrerField.value);
    }
  }
</script>
HEREDOC;
  echo $script;
}

function tir_footer() {
  $script = <<<HEREDOC
<script>
  setReferrerOnSubmit();
</script>
HEREDOC;
  echo $script;
}

function tir_http_redirect_filter($location, $status) {
  if (!is_ssl()) {
    $referrer = $_SERVER['HTTP_REFERER'];
    if (isset($referrer) && !empty($referrer)) {
      $new_location = $location;
      if (strpos($new_location, "?") === false) {
        $new_location .= "?";
      } else {
        $new_location .= "&";
      }
      $new_location .= "referrer=" . urlencode($referrer);
      error_log("tir_http_redirect_filter: " . $new_location);
      return $new_location;
    }
  }
  return $location;
}

add_action( 'wp_head', 'tir_head' );
add_action( 'wp_footer', 'tir_footer' );
add_filter( 'wp_redirect', 'tir_http_redirect_filter', 0, 2 );
?>

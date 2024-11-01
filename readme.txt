=== track-incoming-referrer ===
Contributors: averageradical
Tags: referrer
Tested up to: 4.7
Requires at least: 2.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Track incoming referrer and write it to any hidden form field with the identifier "referrer".

== Description ==

Non-technical summary: Track incoming referrer and write it to any hidden form field with the identifier "referrer" (this can be created in Contact Form 7, for example; see below). Also if the WordPress site redirects from HTTP to HTTPS, this plugin also overrides the redirect to add the referrer to the https URL.

Technical details: This plugin runs client-side JavaScript in every page in HEAD and if there isn't a session cookie with the name "referrer", then it writes a session cookie with the name "referrer" and the value of either document.referrer, or if that's empty, the URL-encoded value of window.location.href. There is another client-side JavaScript in every page before </body> which writes the value of the "referrer" cookie to any INPUT with the ID "referrer", if it exists.

When integrating with Contact Form 7, add a hidden input field such as the following:

    [hidden referrer id:referrer]

And then add to the Mail's Message Body:

    Referrer: [referrer]

If you're just integrating this with HTML, just add this to any form:

    <input type="hidden" id="referrer" name="referrer" />

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Add INPUT field to a FORM with id "referrer"

== Frequently Asked Questions ==

No FAQ

== Screenshots ==

No screenshots

== Changelog ==

= 1.0.0 =
* First version

== Upgrade Notice ==

No upgrades

=== Magcloud Widget ===
Contributors: galalaly2
Donate link: 
Tags: magcloud
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: trunk 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A widget to insert the Magcloud cover to your blog with a custom template instead of their HTML.

== Description ==

HP MagCloud is a web service that empowers users to self-publish and distribute content—for business or personal use—as a professional-quality print publication or digitally for mobile and online viewing on today's most popular devices.
http://www.magcloud.com/learn

After uploading your PDF, one way of advertising your published magazine is to copy and paste some HTML code to your website. However, the HTML is not always matching the design of the blog. This widget will allow people to paste MagCloud HTML code, write their own template, and with the help of some short codes they get the output that match their themes.

Please note that Magcloud gives us some HTML code that includes an image for the cover of the magazine that is hosted on their servers. This plugin will not copy it to our servers and will use the one Magcloud provides.

== Installation ==

1. Upload the plugin's folder to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to `Appearance -> Widget` and add the Magcloud widget to your sidebar.

4. Insert the title, HTML code from Magcloud, the HTML code you want to appear on your site.

5. You can use the following shortcodes:
* [widget_title]: The title entered by the user in the dashboard
* [magcloud_title]: Title of magazine returned by Magcloud
* [magcloud_description]: Description returned by Magcloud
* [magcloud_category]: Category in Magcloud
* [magcloud_url]: URL for the magazine in Magcloud
* [magcloud_image]: URL for the image

6. Sometimes the description is large that it messes with the layout. You can choose to trim the description by X characters through the widget trim field. If the trim is set to 0, no trimming will take place.

== Frequently asked questions ==

= How to get the HTML code from Magcloud? =

Make sure your magazine is Listed. Go to the sharing and promote section at Magcloud and you will find the HTML code there.

= Why is there a HTML file? =

The plugin uses a parser library to parse the code from MagCloud. This would load the server if it happens several times. Therefore, instead of parsing every single visit, we parse it only once and generate the HTML file that is included later.

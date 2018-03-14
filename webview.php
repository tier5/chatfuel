<?php
	// echo "<pre>";
	// print_r($_SERVER);
	// exit();
	$displayUrl = "https://webviews.tier5-development.us/team_core/show_webview.php";
	echo '{"messages":[{"attachment":{"type":"template","payload":{"template_type":"generic","image_aspect_ratio":"square","elements":[{"title":"Hello World","subtitle":"Choose your preferences","buttons":[{"type":"web_url","url":"https://webviews.tier5-development.us/team_core/show_webview.php","title":"Webview (compact)","messenger_extensions":true,"webview_height_ratio":"compact"},{"type":"web_url","url":"https://webviews.tier5-development.us/team_core/show_webview.php","title":"Webview (tall)","messenger_extensions":true,"webview_height_ratio":"tall"},{"type":"web_url","url":"https://webviews.tier5-development.us/team_core/show_webview.php","title":"Webview (full)","messenger_extensions":true,"webview_height_ratio":"full"}]}]}}}]}';
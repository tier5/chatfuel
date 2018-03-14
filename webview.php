<?php
	// echo "<pre>";
	// print_r($_SERVER);
	// exit();
	$displayUrl = "https://webviews.tier5-development.us/team_core/show_webview.php";
	echo '{"messages":[{"attachment":{"type":"template","payload":{"template_type":"generic","image_aspect_ratio":"square","elements":[{"title":"Schedule a call","subtitle":"Book an appointment with Tier5","buttons":[{"type":"web_url","url":"https://webviews.tier5-development.us/team_core/show_webview.php","title":"Schedule","messenger_extensions":true,"webview_height_ratio":"compact"}]}]}}}]}';
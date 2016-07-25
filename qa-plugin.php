<?php

/*
        Plugin Name: AdChat
        Plugin URI: https://github.com/arjunsuresh/chat
        Plugin Update Check URI: https://raw.github.com/arjunsuresh/chat/master/metadata.json
        Plugin Description: Adds chat to sidepanel
        Plugin Version: 1.0
        Plugin Date: 2015-11-08
        Plugin Author: Arjun
        Plugin Author URI: https://github.com/arjunsuresh/chat
        Plugin License: GPLv2
        Plugin Minimum Question2Answer Version: 1.6
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}
	
	qa_register_plugin_layer('qa-adchat-layer.php', 'Adchat Layer');	
	
	qa_register_plugin_module('module', 'qa-adchat-admin.php', 'qa_adchat_admin', 'AdChat Admin');
	qa_register_plugin_module('page', 'qa-adchat-page.php', 'qa_adchat_page', 'Chat');
	qa_register_plugin_module('page', 'qa-adchat-log-page.php', 'qa_adchat_log_page', 'Chat Logs');
	qa_register_plugin_module('widget', 'qa-adchat-widget.php', 'qa_adchat_widget', 'AdChat Widget');

/*
	Omit PHP closing tag to help avoid accidental output
*/

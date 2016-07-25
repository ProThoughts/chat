<?php

class qa_html_theme_layer extends qa_html_theme_base {

	function body_suffix()
	{
		qa_html_theme_base::body_suffix();


		$this->output('<script type="text/javascript"> $("#adchattoggle").click (function () 
                        {
				
                                $("#adchat").toggle();
				createCookieAdChat($("#adchat").css("display"));
                           
                        });
			function createCookieAdChat(value) {
        var date = new Date();
        date.setTime(date.getTime()+(365*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    
    document.cookie = "showadchat"+"="+value+expires+"; path=/";
}
</script>');
		
	}
	function head_script()
	{
		qa_html_theme_base::head_script();

		$this->output('<style type="text/css">'.qa_opt('adchat_plugin_css').'</style>');
		
	}



}


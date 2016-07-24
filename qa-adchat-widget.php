<?php

class qa_adchat_widget {

	var $urltoroot;

	function load_module($directory, $urltoroot)
	{
		$this->urltoroot = $urltoroot;
	}

	function allow_template($template)
	{

		return true;
	}

	function allow_region($region)
	{
		return ($region=='side');
	}

	function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
	{
		$out='';
		require_once QA_INCLUDE_DIR.'qa-app-users.php';
		if(qa_is_logged_in())
		{
			$out='


			<button id="adchattoggle" class="adchattoggle btn btn-info btn-lg btn-block">Show/Hide Chat </button>';
			$out.='<div class="adchat" id="adchat" style="display:';
			 if(@$_COOKIE['showadchat'] == 'block')
				$out.="block";
			else $out.="none";



			$out .='">';
			$out.='
	
				<iframe src="'.$this->urltoroot.'/chat" style="border:0; width:100%; height:480px;"></iframe>
				 </div>';

		}
		else {
			$out='<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
				style="display:block"
				data-ad-client="'.qa_html(qa_opt("adsense_publisher_id")).'"
				data-ad-slot="'.qa_html(qa_opt("adsense_adunit_id")).'"
				data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>';
		}			
		$output = '<div class="adchat-widget-container">'.$out.'</div>';

		$themeobject->output(
				$output
				);			
	}
};


/*
   Omit PHP closing tag to help avoid accidental output
 */

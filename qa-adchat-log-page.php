<?php

class qa_adchat_log_page{

	private $directory;
	private $urltoroot;


	public function load_module($directory, $urltoroot)
	{
		$this->directory=$directory;
		$this->urltoroot=$urltoroot;
	}


	public function suggest_requests() // for display in admin interface
	{
		return array(
				array(
					'title' => 'Chat Log Page',
					'request' => 'chatlog',
					'nav' => 'M', // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
				     ),
			    );
	}


	public function match_request($request)
	{
		return $request == 'chatlog';
	}


	public function process_request($request)
	{
		$qa_content=qa_content_prepare(true);
                        $qa_content['title']=qa_opt('site_title').' Chat Logs';

                        $qa_content['custom']= '<iframe src="'.$this->urltoroot.'chat/?view=logs"  width="100%" height="600"></iframe>';
			$qa_content['custom_2']='<script type="text/javascript"> $( document ).ready(function() {  $("#settingsContainer").hide(); }); </script>';


		return $qa_content;

	}
}

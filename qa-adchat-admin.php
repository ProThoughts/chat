<?php
	class qa_adchat_admin {
		
		function allow_template($template)
		{
			return ($template!='admin');
		}

		function option_default($option) {

			switch($option) {
				case 'adchat_plugin_css':
					return '
button#adchattoggle {
	margin-bottom: 10px;
	background-color: #4c9ed9!important;
	color:white;
	float:right;
}
.adchat-widget-container {
display: inline-block;
height:360px;
width:240px;
}
';
			case 'adchat_adcode': return '';
			case 'adchat-expand-categories': 
				return '0';
			}
			
		}



		function admin_form(&$qa_content)
		{

		//	Process form input

			$ok = null;
			if (qa_clicked('adchat_save_button')) {
				
				qa_opt('adchat_plugin_css',qa_post_text('adchat_plugin_css'));
				qa_opt('adchat_adcode',qa_post_text('adchat_adcode'));
				if(qa_post_text('adchat-expand-categories') == 1)
				qa_opt('adchat-expand-categories',"1");
				else
				qa_opt('adchat-expand-categories',"0");
				
				$ok = qa_lang('admin/options_saved');
			}
			else if (qa_clicked('adchat_reset_button')) {
				foreach($_POST as $i => $v) {
					$def = $this->option_default($i);
					if($def !== null) qa_opt($i,$def);
				}
				$ok = qa_lang('admin/options_reset');
			}			
		//	Create the form for display
			
		
			$fields = array();


			$fields[] = array(
				'type' => 'blank',
			);			
			
			$fields[] = array(
				'label' => 'Adchat custom css',
				'tags' => 'NAME="adchat_plugin_css"',
				'value' => qa_opt('adchat_plugin_css'),
				'type' => 'textarea',
				'rows' => 20
			);
			$fields[] = array(
				'label' => 'Adchat Code to show for non-logged users',
				'tags' => 'NAME="adchat_adcode"',
				'value' => qa_opt('adchat_adcode'),
				'type' => 'textarea',
				'rows' => 20
			);
			$fields[] = array(
				'label' => 'Make all categories into chat room',
				'note' => 'Otherwise only top level categories are made to chat room',
				'tags' => 'NAME="adchat-expand-categories"',
				'value' => qa_opt('adchat-expand-categories'),
				'type' => 'checkbox',
			);
									

						
			return array(
				'ok' => ($ok && !isset($error)) ? $ok : null,
				
				'fields' => $fields,
				
				'buttons' => array(
					array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'NAME="adchat_save_button"',
					),
					array(
					'label' => qa_lang_html('admin/reset_options_button'),
					'tags' => 'NAME="adchat_reset_button"',
					),
				),
			);
		}
	}

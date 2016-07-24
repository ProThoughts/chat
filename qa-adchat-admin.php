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
}';
			}
			
		}



		function admin_form(&$qa_content)
		{

		//	Process form input

			$ok = null;
			if (qa_clicked('adchat_save_button')) {
				
				qa_opt('adchat_plugin_css',qa_post_text('adchat_plugin_css'));
				qa_opt('adchat_plugin_widget_only',(bool)qa_post_text('adchat_plugin_widget_only'));
				
				
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
				'type' => 'blank',
			);			

			$fields[] = array(
				'type' => 'blank',
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

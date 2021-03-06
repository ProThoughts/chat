<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license Modified MIT License
 * @link https://blueimp.net/ajax/
 */

class CustomAJAXChat extends AJAXChat {

	// Returns an associative array containing userName, userID and userRole
	// Returns null if login is invalid

	/*function getValidLoginUserData() {

	  $customUsers = $this->getCustomUsers();

	  if($this->getRequestVar('password')) {
	// Check if we have a valid registered user:

	$userName = $this->getRequestVar('userName');
	$userName = $this->convertEncoding($userName, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding'));

	$password = $this->getRequestVar('password');
	$password = $this->convertEncoding($password, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding'));

	foreach($customUsers as $key=>$value) {
	if(($value['userName'] == $userName) && ($value['password'] == $password)) {
	$userData = array();
	$userData['userID'] = $key;
	$userData['userName'] = $this->trimUserName($value['userName']);
	$userData['userRole'] = $value['userRole'];
	return $userData;
	}
	}

	return null;
	} else {
	// Guest users:
	return $this->getGuestUser();
	}
	}*/
	//For Q2A
	function getValidLoginUserData() {

		// Check if we have a valid registered user:
		if(!(qa_get_logged_in_userid()===null)) {
			$userData = array();
			$userId = qa_get_logged_in_userid();
			$userData['userID'] = $userId;
			$userData['userName'] = $this->trimUserName(qa_get_logged_in_handle());

			if(qa_get_logged_in_level() >= QA_USER_LEVEL_MODERATOR)
				$userData['userRole'] = AJAX_CHAT_ADMIN;
			elseif(qa_get_logged_in_level() == QA_USER_LEVEL_EDITOR)
				$userData['userRole'] = AJAX_CHAT_MODERATOR;
			else
				$userData['userRole'] = AJAX_CHAT_USER;
			$user = qa_db_select_with_pending( qa_db_user_account_selectspec($userId, true) );
			$userData['avatar'] = qa_get_user_avatar_html($user['flags'], $user['email'], $user['handle'], $user['avatarblobid'], $user['avatarwidth'], $user['avatarheight'], qa_opt('avatar_users_size'), true);
			return $userData;

		} else {
			// Guest users:
			return $this->getGuestUser();
		}
	}

	//for Q2A login to work
	// Initialize custom request variables: 
	function initCustomRequestVars() { 
		// Auto-login Q2A users: 
		if(!$this->getRequestVar('logout') && !(qa_get_logged_in_userid()===null)) { 
			$this->setRequestVar('login', true); 
		} 
	}

	// Store the channels the current user has access to
	// Make sure channel names don't contain any whitespace
	function &getChannels() {
		if($this->_channels === null) {
			$this->_channels = array();

			$customUsers = $this->getCustomUsers();

			// Get the channels, the user has access to:
			if($this->getUserRole() == AJAX_CHAT_GUEST) {
				$validChannels = $customUsers[0]['channels'];
			} else {
				$channelIDs = $this->getCustomChannelsId();	
				//$validChannels = $customUsers[$this->getUserID()]['channels']; //for Q2A
				$validChannels = $channelIDs;
			}

			// Add the valid channels to the channel list (the defaultChannelID is always valid):
			foreach($this->getAllChannels() as $key=>$value) {
				if ($value == $this->getConfig('defaultChannelID')) {
					$this->_channels[$key] = $value;
					continue;
				}
				// Check if we have to limit the available channels:
				if($this->getConfig('limitChannelList') && !in_array($value, $this->getConfig('limitChannelList'))) {
					continue;
				}
				if(in_array($value, $validChannels)) {
					$this->_channels[$key] = $value;
				}
			}
		}
		return $this->_channels;
	}

	// Store all existing channels
	// Make sure channel names don't contain any whitespace
	function &getAllChannels() {
		if($this->_allChannels === null) {
			// Get all existing channels:
			$customChannels = $this->getCustomChannels();

			$defaultChannelFound = false;

			foreach($customChannels as $name=>$id) {
				$this->_allChannels[$this->trimChannelName($name)] = $id;
				if($id == $this->getConfig('defaultChannelID')) {
					$defaultChannelFound = true;
				}
			}

			if(!$defaultChannelFound) {
				// Add the default channel as first array element to the channel list
				// First remove it in case it appeard under a different ID
				unset($this->_allChannels[$this->getConfig('defaultChannelName')]);
				$this->_allChannels = array_merge(
						array(
							$this->trimChannelName($this->getConfig('defaultChannelName'))=>$this->getConfig('defaultChannelID')
						     ),
						$this->_allChannels
						);
			}
		}
		return $this->_allChannels;
	}
	/*
	   function &getCustomUsers() {
// List containing the registered chat users:
$users = null;
$channelIDs = $this->getCustomChannelsId();
require(AJAX_CHAT_PATH.'lib/data/users.php');
$userscount = count($users);
//users from q2a
$usersfromq2a = qa_db_select_with_pending(qa_db_top_users_selectspec(0));
foreach ($usersfromq2a as $key => $value) {
$users[$key] = array();
$users[$key]['userRole'] = AJAX_CHAT_USER;
$users[$key]['userName'] = 'user';
$users[$key]['password'] = time().mt_rand();
$users[$key]['channels'] = $channelIDs;
}
return $users;
}*/


function &getCustomUsers() {
	// List containing the registered chat users:
	$users = null;
	require(AJAX_CHAT_PATH.'lib/data/users.php');
	return $users;
}
//for Q2A
function getAllCategoriesSelectSpec()
{
	return array(
			'columns' =>  array('^categories.categoryid', '^categories.parentid', 'title' => '^categories.title', 'tags' => '^categories.tags', '^categories.qcount', '^categories.position',   'content'=>'^categories.content', 'backpath'=>'^categories.backpath',
),
			'source' => '^categories',
			'arguments' => '',
			'arraykey' => 'categoryid',
			'sortasc' => 'title',
		    );

}
function getCustomChannels() {
	// List containing the custom channels:
	$channels = array();
	//$channels = getCustomChannelsId();
	//Q2A Categories list
	if(qa_opt('adchat-expand-categories')){
		$q2a_categories=qa_db_select_with_pending( $this->getAllCategoriesSelectSpec() );
	}
	else
	{
		$q2a_categories=qa_db_select_with_pending( qa_db_category_nav_selectspec(false, false, false, true) );
	}
	foreach ($q2a_categories as $catID => $catDet) {
		$channels[$catID] = $catDet["tags"];
	}


	// ChannelName => ChannelID
	return array_flip($channels);
}

function getCustomChannelsId() {
	// List containing the custom channels:
	$channels = array();
	if(qa_opt('adchat-expand-categories')){
		$q2a_categories=qa_db_select_with_pending($this->getAllCategoriesSelectSpec());
	}

	else{
		$q2a_categories=qa_db_select_with_pending( qa_db_category_nav_selectspec(false, false, false, true) );

	}foreach ($q2a_categories as $catID => $catDet) {
		$channels[] = $catID;
	}

	// Channel array structure should be:
	// ChannelName => ChannelID
	return $channels;
}
/*	function getCustomChannels() {
// List containing the custom channels:
$channels = null;
require(AJAX_CHAT_PATH.'lib/data/channels.php');
// Channel array structure should be:
// ChannelName => ChannelID
return array_flip($channels);
}*/

}

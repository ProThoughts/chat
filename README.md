# chat
Question2answer chat
Shows AJAX Chat for logged in users and Google Ad for others.
AJAX chat uses the login of Q2A and by default has a separate chat room per Q2A category.
Requires AJAX chat to be installed in the chat folder of this plugin- just set up the chat database. Instructions can be seen <a href="chat/readme.html">here</a>

In summary 

git clone https://github.com/arjunsuresh/chat.git adchat

Set the database access values in chat/lib/config.php.example and then rename it to config.php.

Then load "qa-plugin/adchat/chat/install.php" from the browser after prepending with the Q2A url.

Delete install.php - Running this again causes the chat database to be deleted.


Now, 

Go to "/admin/layout" and you can create a sidebar widget for chat. 

Also, in "/admin/pages" new pages can be created for full page chat as well as chat logs (chat logs can be searched)


For Ads to be displayed for non-logged in users, please set the Ad sense ID in the admin panel for the Basic Adsense plugin. 
Special thanks to Sebastian Tschan for AJAX chat and also  <a href="http://digitizor.com/integrate-ajaxchat-question2answer-q2a/"> Digitizer.com </a> for Integration Instructions



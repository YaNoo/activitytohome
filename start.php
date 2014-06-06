<?php
elgg_register_event_handler('init', 'system', 'activity_to_home');

function activity_to_home() {	
    elgg_unregister_page_handler('activity');
    elgg_register_page_handler('home', 'activity_to_home_page_handler');
    elgg_register_page_handler('activity', 'activity_to_home_page_fix');

    elgg_unregister_menu_item('site', 'activity');
    elgg_register_menu_item('site', array(
        'name' => 'home',
        'text' => elgg_echo('home'),
        'href' => '/home',
        'priority' => 0,
   ));
   elgg_register_menu_item('site', array(
        'name' => 'discussions',
        'text' => elgg_echo('discussions'),
        'href' => '/discussion/all',
        'priority' => 1,
   ));


}
function activity_to_home_page_fix($page){
 forward('/home');	
}
function activity_to_home_page_handler($page){
	$file = elgg_get_plugins_path().'activitytohome/';

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	$page_type = elgg_extract(0, $page, 'all');
	$page_type = preg_replace('[\W]', '', $page_type);
	if ($page_type == 'owner') {
		$page_type = 'mine';
	}
	set_input('page_type', $page_type);

	require_once("{$file}pages/river.php");
	return true;
}

<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
function callback_init() {
	option::set('dl_yjtz_time',0);
	cron::set('dl_yjtz','plugins/dl_yjtz/run.php',0,0,0);
	}
function callback_inactive() {
	cron::del('dl_yjtz');
}
?>
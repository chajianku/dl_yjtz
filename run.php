<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
$last = option::get('dl_yjtz_last');
if($last != date('Y-m-d')){
	global $m;
	$max = $m->fetch_array($m->query("select max(id) as id from `".DB_NAME."`.`".DB_PREFIX."users`"));
	$max = $max['id'];
	$lastdo = option::get('dl_yjtz_time');
	for($ii=$lastdo;$ii<=$max;$ii++){
		$user = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.'users` where `id` = '.$ii));		
		if(!empty($user['email'])){
			$op = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.'users_options` where `uid` = '.$user['id'].' and `name` = "dl_yjtz_enable"'));
			if($op['value'] == 1){
				$url = SYSTEM_URL.'index.php?pub_plugin=dl_yjtz&username='.$user['name'].'&token='.md5(md5(md5(md5($user['name'].$user['pw'].date('Y-m-d')))));
				$x = misc::mail($user['email'],SYSTEM_NAME.'-签到通知','您可通过此链接查看您的当日签到情况（次日自动失效）：<a href="'.$url.'">'.$url.'</a>');
				option::set('dl_yjtz_time',$ii);
				}
			}
		}
	if(option::get('dl_yjtz_time') >= $max){
		option::set('dl_yjtz_time',0);
		}
	option::set('dl_yjtz_last',date('Y-m-d'));
	}    
?>
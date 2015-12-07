<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
/*
Plugin Name: 签到邮件通知（D丶L）
Version: 1.3
Plugin URL: http://www.tbsign.cn
Description: 用户使用此插件每日可以收到签到邮件通知
Author: D丶L & Pisces
Author Email: wuyao@jt371.cn
Author URL: http://tbsign.cn
For: V3.8+
*/
function dl_yjtz_setting() {
	global $m;
	?>
	<tr><td>签到邮件通知</td>
	<td>
	<input type="radio" name="dl_yjtz_enable" value="1" <?php if (option::uget('dl_yjtz_enable') == 1) { echo 'checked'; } ?> > 开启签到邮件通知<br/>
	<input type="radio" name="dl_yjtz_enable" value="0" <?php if (option::uget('dl_yjtz_enable') != 1) { echo 'checked'; } ?> > 关闭签到邮件通知
	</td>
	<?php
}
function dl_yjtz_set() {
	global $PostArray;
	if (!empty($PostArray)) {
		$PostArray[] = 'dl_yjtz_enable';
	}
}

addAction('set_save1','dl_yjtz_set');
addAction('set_2','dl_yjtz_setting');
?>
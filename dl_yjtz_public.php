<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
loadhead();
global $m;
global $i;
if(isset($_GET['username'])){
	$user = sqladds($_REQUEST['username']);
	if(empty($_REQUEST['username'])){die('参数错误！');}
	$token = $_REQUEST['token'];
	$userinfo = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.'users` where `name` = "'.$user.'"'));
	if(empty($userinfo['email'])){die('嗯哼，你是哪位？ 系统不认识你，一边玩蛋去吧 ~');}	
	$system_token = md5(md5(md5(md5($userinfo['name'].$userinfo['pw'].date('Y-m-d')))));
	if($token != $system_token){die('渣渣，就你这水平也想骗我？你也太嫩了点吧！');}
	$max = $m->fetch_array($m->query("select max(id) as id from `".DB_NAME."`.`".DB_PREFIX.$userinfo['t']."` where `uid`=".$userinfo['id']));
	$min = $m->fetch_array($m->query("select min(id) as id from `".DB_NAME."`.`".DB_PREFIX.$userinfo['t']."` where `uid`=".$userinfo['id']));
	$max = $max['id'];
	$min = $min['id'];
	if(empty($max) || empty($min)){die('抱歉，您没有关注任何贴吧，所以我们无法提供签到报告！');}
	if ($i['opt']['core_version'] >= 4.0) {$zt = 'latest';} else {$zt = 'lastdo';}
	?>
    <h2 align="center"><?php echo date('Y-m-d'); ?> 签到信息</h2><p align="center">站点地址：<a href="<?php echo SYSTEM_URL ?>"><?php echo SYSTEM_URL ?></a></p><br/><br/>
    <div class="alert alert-warning">
    <h3 align="center">待签到</h3><br/>
    <table class="table table-striped">
	<thead>
		<th>UID</th>
        <th>PID</th>
		<th>吧名</th>
		<th>状态</th>
		<th>结果</th>
	</thead>
        <tbody>
			<?php
				$tj = 0;
				for($ii=$min;$ii<=$max;$ii++){
					$tieba = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.$userinfo['t'].'` where `uid` = '.$userinfo['id'].' and `id`='.$ii));
					if((date("Y-m-").$tieba[$zt] == date("Y-m-j",strtotime("-1 day"))) || (empty($tieba[$zt]))){
						$tj = $tj + 1;
						echo '<tr><td>'.$tieba['uid'].'</td><td>'.$tieba['pid'].'</td><td>'.$tieba['tieba'].'</td><td>待签到</td><td>-</td></tr>';
						} 
					} 
				if($tj == 0){
					echo '<tr align="center"><td></td><td></td><td>没有等待签到的吧！</td><td></td><td></td></tr>';
					}
            ?>
        </tbody>
    </table>
    </div><br/><br/>
    <div class="alert alert-danger">
    <h3 align="center">签到出错</h3><br/>
    <table class="table table-striped">
	<thead>
		<th>UID</th>
        <th>PID</th>
		<th>吧名</th>
		<th>状态</th>
		<th>结果</th>
	</thead>
        <tbody>
			<?php	
				$tj = 0;
				for($ii=$min;$ii<=$max;$ii++){
					$tieba = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.$userinfo['t'].'` where `uid` = '.$userinfo['id'].' and `id`='.$ii));
					if((!empty($tieba['status'])) && (date("Y-m-").$tieba[$zt] == date('Y-m-j')) && (empty($tieba['no']))){
						$tj = $tj+1;
						echo '<tr><td>'.$tieba['uid'].'</td><td>'.$tieba['pid'].'</td><td>'.$tieba['tieba'].'</td><td>'.$tieba['status'].'</td><td>'.$tieba['last_error'].'</td></tr>';
						} 
					} 
				if($tj == 0){
					echo '<tr align="center"><td></td><td></td><td>没有签到出错的吧！</td><td></td><td></td></tr>';
					}
            ?>
        </tbody>
    </table>
    </div><br/><br/>
    <div class="alert alert-success">
    <h3 align="center">签到成功</h3><br/>
    <table class="table table-striped">
	<thead>
		<th>UID</th>
        <th>PID</th>
		<th>吧名</th>
		<th>状态</th>
		<th>结果</th>
	</thead>
        <tbody>
			<?php
				$tj = 0;
				for($ii=$min;$ii<=$max;$ii++){
					$tieba = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.$userinfo['t'].'` where `uid` = '.$userinfo['id'].' and `id`='.$ii));
					if((date("Y-m-").$tieba[$zt] == date("Y-m-j")) && (empty($tieba['status'])) && (empty($tieba['no']))){
						$tj = $tj + 1;
						echo '<tr><td>'.$tieba['uid'].'</td><td>'.$tieba['pid'].'</td><td>'.$tieba['tieba'].'</td><td>成功</td><td>-</td></tr>';
						} 
					} 
				if($tj == 0){
					echo '<tr align="center"><td></td><td></td><td>没有签到成功的吧！</td><td></td><td></td></tr>';
					}
            ?>
        </tbody>
    </table>
    </div><br/><br/>
    <div class="alert alert-info">
    <h3 align="center">忽略签到</h3><br/>
    <table class="table table-striped">
	<thead>
		<th>UID</th>
        <th>PID</th>
		<th>吧名</th>
		<th>状态</th>
		<th>结果</th>
	</thead>
        <tbody>
			<?php
				$tj = 0;
				for($ii=$min;$ii<=$max;$ii++){
					$tieba = $m->fetch_array($m->query('select * from `'.DB_NAME.'`.`'.DB_PREFIX.$userinfo['t'].'` where `uid` = '.$userinfo['id'].' and `id`='.$ii));
					if(!empty($tieba['no'])){
						$tj = $tj+1;
						echo '<tr><td>'.$tieba['uid'].'</td><td>'.$tieba['pid'].'</td><td>'.$tieba['tieba'].'</td><td>忽略</td><td>-</td></tr>';
						} 
					} 
				if($tj == 0){
					echo '<tr align="center"><td></td><td></td><td>没有忽略签到的吧！</td><td></td><td></td></tr>';
					}
            ?>
        </tbody>
    </table>
    </div>
    <br/><br/>插件作者：<a href="http://www.tbsign.cn" target="_blank">D丶L</a> & <a href="http://tb.xueyuanblog.cn" target="_blank">Pisces</a> // 程序作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a> & <a href="http://longtings.com" target="_blank">Mokeyjay</a><br/><br/>
	<?php
	} else {
		die('警告：您无权访问此页面！');
		}
?>
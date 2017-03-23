<?php
header('Content-Type: text/html; charset=utf-8');
// 支付服务器端

$merchant = array(
'1009001'=>'#(%#WU)(UFGDKJGNDFG',
'1009002'=>'DJFKklslkdf%78ew9@@@@',
'1009003'=>'!@cd76dsaf%^&#$(12255',
'1009004'=>'48905ldc%^&(*slslUT',
'1009005'=>'12#*&dklsK*&LKFDKLSF'
);

/*
<form method=post action="https://pay3.chinabank.com.cn/PayGate">
<input type=hidden name=v_mid value="20000400">                    商户编号
<input type=hidden name=v_oid value="19990720-20000400-000001234">订单编号
<input type=hidden name=v_amount value="0.01">            		订单总金额
<input type=hidden name=v_moneytype value="CNY">                币种
<input type=hidden name=v_url value="http://domain/chinabank/Receive.asp">
支付动作完成后返回到该url，支付结果以POST方式发送
<input type=hidden name=v_md5info value="1630DC083D70A1E8AF60F49C143A7B95">                 订单MD5校验码


v_amount v_moneytype v_oid v_mid v_url key
*/

// 检查商户号
$v_mid = $_POST['v_mid'];

if(!array_key_exists($v_mid,$merchant)) {
	die("商户号有误");
}

// 检查订单号
$v_oid = $_POST['v_oid'];
if(empty($v_oid)) {
	die("订单号不能为空");
}

// 检查金额
if(($v_amount = $_POST['v_amount']) < 0.01) {
	die("金额不正确");
}

// 检查币种
$v_moneytype = $_POST['v_moneytype'];
if(empty($v_moneytype)) {
	die("没设置币种");
}

// 检查返回地址
$v_url = $_POST['v_url'];
$prot = substr($v_url,0,6);
if($prot!='http:/'&&$prot!='https:') {
	die('返回地址不正确');
}

// 获取用户传来的MD5校验码
$v_md5info = $_POST['v_md5info'];

/*
echo $v_mid."<br />";
echo $v_oid."<br />";
echo $v_amount."<br />";
echo $v_moneytype."<br />";
echo $v_url."<br />";
*/



// 计算订单的MD5检验码
$key = $merchant[$v_mid];
$real_md5info = strtoupper(md5($v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key));




if($v_md5info!=$real_md5info) {
	die('检验码错误');
}
?>

<?php

/********

这里的逻辑是 网银在线联系银行,扣顾客的钱,再给商品打钱,这部分我们不用关心
当网银完成这些逻辑后(有可能支付成功,也有可能失败),执行下面的代码
********/


// 20 为成功,30为支付失败,这里有1/10的概率模拟失败的情况
$v_pstatus = rand(0,9) <=8 ? 20 :30;

// 给客户生成md5供检验这确实是网银过来的信息
$p_md5info = strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));


$payed = array(
	'v_oid'=>$v_oid,
	'v_pstatus'=>$v_pstatus,
	'v_pstring'=>'支付完成',
	'v_pmode'=>'工商银行',
	'v_md5str'=>$p_md5info,
	'v_amount'=>$v_amount,
	'v_moneytype'=>$v_moneytype,
	'remark1'=>'',
	'remark2'=>''
);
?>


<html>
<head>
<script type="text/javascript">
	function pay() {
		var img = document.images[0];
		if(img.src.indexOf('6.gif')>=0) {
			img.src="7.gif";
		} else if(img.src.indexOf('7.gif')>=0) {
			alert("支付成功!");
			document.forms[0].submit();
		}
	}
</script>
</head>
<img src="6.gif" onclick="pay();" />
<form action="<?php echo $v_url; ?>" method="post">
	<input type="hidden" name="v_oid" value="<?php echo $payed['v_oid']; ?>" />
	<input type="hidden" name="v_pstatus" value="<?php echo $payed['v_pstatus']; ?>" />
	<input type="hidden" name="v_pstring" value="<?php echo $payed['v_pstring']; ?>" />
	<input type="hidden" name="v_pmode" value="<?php echo $payed['v_pmode']; ?>" />
	<input type="hidden" name="v_md5str" value="<?php echo $payed['v_md5str']; ?>" />
	<input type="hidden" name="v_amount" value="<?php echo $payed['v_amount']; ?>" />
	<input type="hidden" name="v_moneytype" value="<?php echo $payed['v_moneytype']; ?>" />
	<input type="hidden" name="remark1" value="<?php echo $payed['remark1']; ?>" />
	<input type="hidden" name="remark2" value="<?php echo $payed['remark2']; ?>" />

</form>
<body>
</body>
</html>




<!-- 
// 支付成功后, 往客户端发信息确认
$ch = curl_init();

$opt =
array(
CURLOPT_URL=>$v_url,
CURLOPT_POST=>1,
CURLOPT_HEADER=>1,
CURLOPT_FOLLOWLOCATION=>1,
CURLOPT_POSTFIELDS=>$payed,
);

curl_setopt_array($ch,$opt);

curl_exec($ch);
 -->
<?php


// 在线支付的返回信息接收页面


$md5key = '#(%#WU)(UFGDKJGNDFG';

// 计算出md5info
$md5info = md5($_POST['v_oid'] . $_POST['v_pstatus'] . $_POST['v_amount'] . $_POST['v_moneytype'] . $md5key);
$md5info = strtoupper($md5info);


// 再拿计算出的md5info和表单发来的md5info对比

if($md5info !== $_POST['v_md5str']) {
    echo '你想篡改数据，没门!';
    exit;
}


echo '执行sql语句,把订单号',$_POST['v_oid'];
echo '对应的订单改为已支付';




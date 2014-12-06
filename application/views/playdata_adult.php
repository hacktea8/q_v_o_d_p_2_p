<!Doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta http-equiv=Content-Type content="text/html;charset=utf-8">
<title>溫馨提示:尊敬的<?php echo $uinfo['uname'];?>會員，您無權訪問此頁面的內容 </title>
<style type="text/css">
.tipDiv{background-color: white;
height: 500px;
text-align: center;
padding-top: 30px;}
</style>
</head>
<body>
 <div class="tipDiv">
  <h3><?php if( !$uinfo['uid']){echo '抱歉您還未登錄!請登錄后在來~~~~';}else{echo '抱歉您觀看影片所需的點數不夠了';}?></h3>
  <div class="msgDiv">
  <?php if( !$uinfo['uid']){echo '<a href="/maindex/login/?goto='.$base_url.'/maindex/views/'.$vid.'" target="_top">點我登錄</a>';}else{echo '每部影片消耗8點,如何獲取觀看點數?<a href="" target="_top">點我悄悄告訴你</a>';}?>
  </div>
 </div>
</body>
</html>

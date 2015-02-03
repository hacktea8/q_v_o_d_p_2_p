<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:url" content="<?php echo $base_url,'/checkage';?>" />
<meta property="og:title" content="全台灣最大的成人娛樂平台" />
<meta property="og:description" content="<?php echo $web_title;?> 提供『最新』、『最快』、『最高畫質』成人娛樂享受！" />
<meta property="og:image" content="<?php echo $base_url;?>/public/images/FB_logo.png" />
<title>【<?php echo $web_title;?>】您即將進入成人網站，未滿18歲者請勿進入。</title>
<style type="text/css">
<!--
html, body {
	height: 100%;
	margin:0;
}
body {
	background-color: #fe6e6d;
}
-->
</style>
<link href="page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function getCookie(c_name){
    if (document.cookie.length>0)
    { 
        c_start=document.cookie.indexOf(c_name + "=")
        if (c_start!=-1)
        { 
            c_start=c_start + c_name.length+1 
            c_end=document.cookie.indexOf(";",c_start)
            if (c_end==-1) 
                c_end=document.cookie.length

            return unescape(document.cookie.substring(c_start,c_end))
        } 
    }
    return ""
}

function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays)
    document.cookie=c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : "; expires="+exdate.toGMTString());
}
function go941(){
 if($('#over18:checked').val()){
  <?php $week=date('w'); if($auth || in_array($week,array(0,6))){?>
  setCookie('isAdult','1',1);
  referer = getCookie('goReferer');
  referer = referer ? referer: '';
  location.href=referer;
 <?php }else{?>
 alert('中國大陸用戶，請自覺離開!謝謝合作!!');
 <?php }?>
 }else{
  alert('請先同意上述規範:D');
 }
}

//-->
</script>
</head>

<body onload="MM_preloadImages('<?php echo $cdn_url;?>/public/images/18leave02.png','<?php echo $cdn_url;?>/public/images/18enter02.png')">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><table width="800" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
      <tr>
        <td height="500" align="left" valign="bottom" background="<?php echo $cdn_url;?>/public/images/18ornot.jpg"><table width="800" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="250" height="70">&nbsp;</td>
            <td width="550" height="70" colspan="2" align="right" valign="top"><label></label>
              <img src="<?php echo $cdn_url;?>/public/images/blank.png" width="239" height="57" border="0" usemap="#Map" /></td>
            </tr>
          <tr>
            <td width="250" height="50">&nbsp;</td>
            <td width="550" height="50" colspan="2" align="center" valign="middle"><label>
              <input name="checkbox" type="checkbox" class="fontmain-B" id="over18" />
            </label>
              <span class="fontmain-skin">
               我已閱讀並同意上述規範</span></td>
          </tr>
          <tr>
            <td width="250" height="80">&nbsp;</td>
            <td width="275" height="80" align="center" valign="top"><a href="javascript:void(0);" onclick="go941();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','<?php echo $cdn_url;?>/public/images/18enter02.png',1)"><img src="<?php echo $cdn_url;?>/public/images/18enter01.png" name="Image2" width="200" height="60" border="0" id="Image2" /></a></td>
            <td width="275" height="80" align="center" valign="top"><a href="javascript:void(0);" onclick="window.location.href='/';" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','<?php echo $cdn_url;?>/public/images/18leave02.png',1)"><img src="<?php echo $cdn_url;?>/public/images/18leave01.png" name="Image3" width="200" height="60" border="0" id="Image3" /></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="90" align="center" valign="middle" bgcolor="#FE6E6D"><span class="fontmain-white">&copy;2013<img src="<?php echo $cdn_url;?>/public/images/logo-copy.png" width="120" height="12" />ALL RIGHTS RESERVED.</span></td>
      </tr>
    </table>
    </td>
  </tr>
</table>

<map name="Map" id="Map"><area shape="rect" coords="1,2,123,27" href="http://hicare.hinet.net/main.php" target="_blank" />
</map>
</body>
</html>

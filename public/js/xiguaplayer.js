document.writeln("<div id=\"xg_box\"></div>");
if(XgPlayer.Second<1){
	XgPlayer.Second=1;
}
var browser;
var installflag=1;
function $XghdInstall(){
	$$("xg_box").style.display="none";
	if(installflag==1){
	document.writeln('<iframe border="0" src="'+XgPlayer.Installpage+'" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" noResize scrolling="no" width="'+XgPlayer.Width+'" height="'+XgPlayer.Height+'" vspale="0" ></iframe>');
	installflag=0;
	}
}
var AdsBeta6 = {
	'Start': function() {
		$$('buffer').style.display = 'block';
		if(xiguaPlayer.IsBuffing()){
			$$('buffer').height = XgPlayer.Height-80;
		}else{
			$$('buffer').height = XgPlayer.Height-60;
		}
	},
	'End': function() {
		if(!XgPlayer.Second){
			$$('buffer').style.display = 'none';
			$$('xiguaPlayer').style.display = 'block';
			xiguaPlayer.height = XgPlayer.Height;
		}
	},
	'Status' : function() {
		if(xiguaPlayer.IsPlaying()){
			this.End();
		}else{
			this.Start();
		}
	}
}
function $$(id){
	return document.getElementById(id);
}
function $Showhtml(){
	 browser = navigator.appName;
	if(browser == "Netscape"|| browser == "Opera"){
		if(isIE()){
		return $PlayerIe();
		}else{
			return $PlayerNt();
		}
	}else if(browser == "Microsoft Internet Explorer"){
		return $PlayerIe();
	}else{
		alert('请使用IE内核浏览器观看本站影片!');
	}	
}
    function isIE() {
        if (!!window.ActiveXObject || "ActiveXObject" in window)  {
			browser = "Microsoft Internet Explorer";
            return true;  
		}
        return false;  
    }  

function $PlayerNt(){
	if (navigator.plugins) {
		var install = true;
		for (var i=0;i<navigator.plugins.length;i++) {
			if(navigator.plugins[i].name == 'XiGua Yingshi Plugin'){
				install = false;break;
			}
		}
		if(!install){
			player = '<div style="width:'+XgPlayer.Width+'px;height:'+XgPlayer.Height+'px;overflow:hidden;position:relative"><iframe src="'+XgPlayer.Buffer+'" scrolling="no" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" name="buffer" id="buffer" style="position:absolute;z-index:2;top:0px;left:0px"></iframe><object  width="'+XgPlayer.Width+'" height="'+XgPlayer.Height+'" type="application/xgyingshi-activex" progid="xgax.player.1" param_URL="'+XgPlayer.Url+'" param_NextCacheUrl="'+XgPlayer.NextcacheUrl+'" param_LastWebPage="'+XgPlayer.LastWebPage+'" param_NextWebPage="'+XgPlayer.NextWebPage+'" param_OnPause="onPause" param_OnFirstBufferingStart="onFirstBufferingStart" param_OnFirstBufferingEnd="onFirstBufferingEnd" param_OnPlayBufferingStart="onPlayBufferingStart" param_OnPlayBufferingEnd="onPlayBufferingEnd" param_OnComplete="onComplete" param_Autoplay="1" id="xiguaPlayer" name="xiguaPlayer"></object></div>';
			if(XgPlayer.Second){
				setTimeout("onAdsEnd()",XgPlayer.Second*1000);
			}	
			return player;
		}
	}
	return '<iframe border="0" src="'+XgPlayer.Installpage+'" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" noResize scrolling="no" width="'+XgPlayer.Width+'" height="'+XgPlayer.Height+'" vspale="0" ></iframe>';
}
function $PlayerIe(){
	playerhtml = '<iframe src="'+XgPlayer.Buffer+'" id="buffer" width="'+XgPlayer.Width+'" height="'+(XgPlayer.Height-80)+'" scrolling="no" frameborder="0" style="position:absolute;z-index:9;"></iframe><object classid="clsid:BEF1C903-057D-435E-8223-8EC337C7D3D0"  style="display:none" width="'+XgPlayer.Width+'" height="'+XgPlayer.Height+'" id="xiguaPlayer" name="xiguaPlayer" onerror="$XghdInstall();"><param name="URL" value="'+XgPlayer.Url+'"/><param name="NextCacheUrl" value="'+XgPlayer.NextcacheUrl+'"><param name="LastWebPage" value="'+XgPlayer.LastWebPage+'"><param name="NextWebPage" value="'+XgPlayer.NextWebPage+'"><param name="OnPlay" value="onPlay"/><param name="OnPause" value="onPause"/><param name="OnFirstBufferingStart" value="onFirstBufferingStart"/><param name="OnFirstBufferingEnd" value="onFirstBufferingEnd"/><param name="OnPlayBufferingStart" value="onPlayBufferingStart"/><param name="OnPlayBufferingEnd" value="onPlayBufferingEnd"/><param name="OnComplete" value="onComplete"/><param name="Autoplay" value="1"/></object>';
	return playerhtml;
}
function $PlayerIeBack(){
	if(browser == "Microsoft Internet Explorer"){
		if(xiguaPlayer.URL != undefined){
			if(XgPlayer.Second){
				setTimeout("onAdsEnd()",XgPlayer.Second*1000);
			}	
		}
	}
}
//beta7版播放器回调函数
var onPlay = function(){
	$$('buffer').style.display = 'none';
	//强制缓冲广告倒计时
	if(XgPlayer.Second&&xiguaPlayer.IsPlaying()){
		xiguaPlayer.Play();
	}
}
var onPause = function(){
	$$('buffer').height = XgPlayer.Height-63;
	$$('buffer').style.display = 'block';
}
var onFirstBufferingStart = function(){
	$$('buffer').height = Player.Height-80;
	$$('buffer').style.display = 'block';
}
var onFirstBufferingEnd = function(){
	if(XgPlayer.Second){
		xiguaPlayer.Play();
	}else{
		$$('buffer').style.display = 'none';
	}
}
var onPlayBufferingStart = function(){
	$$('buffer').height = XgPlayer.Height-80;
	$$('buffer').style.display = 'block';
}
var onPlayBufferingEnd = function(){
	$$('buffer').style.display = 'none';
}
var onComplete = function(){
	onPause();
}
var onAdsEnd = function(){
	XgPlayer.Second = 0;
	$$('buffer').style.display = 'none';
	xiguaPlayer.style.display = 'block';
	setInterval("adshow()",1000);
}
  function adshow(){
	  if(xiguaPlayer.IsPlaying()){
		$$('buffer').style.display = 'none';
	  }else if(xiguaPlayer.IsBuffing()){
		$$('buffer').height = XgPlayer.Height-63;
	    $$('buffer').style.display = 'block';
	  }else if(xiguaPlayer.IsPause()){
		$$('buffer').height = XgPlayer.Height-63;
	    $$('buffer').style.display = 'block';
	  }else{
	    $$('buffer').height = XgPlayer.Height-63;
	    $$('buffer').style.display = 'block';
	  }
  }
var install = true;
playerhtml=$Showhtml();
$$("xg_box").innerHTML=playerhtml;
$PlayerIeBack();

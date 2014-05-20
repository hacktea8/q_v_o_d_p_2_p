var zzid=0;
var max_Player_File="play.swf";//播放器款式
var playerw='640';//播放器宽度
var playerh='480';//播放器高度
var skinColor="d6eaf4,333333|000000,FFFFCC|94d2e2,000000|d1d3a2,000000|c9abca,000000";//"背景颜色1,文字颜色1|背景颜色2,文字颜色2";
var autoPlay="1";//是否默认自动播放
var openMenu="1";//是否默认打开播放列表
var logoURL="logo.png";//logo地址,与播放器目录同级或使用绝对地址
var adsPage="/"+sitePath+"js/loading.html";//视频播放前广告页路径
var adsPage2="/"+sitePath+"js/loading2.html";//视频播放前广告页路径
var adsTime=0;//视频播放前广告时间，单位秒
var showFullBtn="1"; //是否显示全屏按钮
var rehref="1";//是否刷新页面点播节目
var alertwin="0";//是否弹窗播放
var btnName="上一集,下一集";

try{top.moveTo(0,0);top.resizeTo(screen.availWidth,screen.availHeight);}catch(e){}

var w3c = (document.getElementById) ? true: false;
var agt = navigator.userAgent.toLowerCase();
var ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1) && (agt.indexOf("omniweb") == -1));
var ie5 = (w3c && ie) ? true: false;
var ns6 = (w3c && (navigator.appName == "Netscape")) ? true: false;
var op8 = (navigator.userAgent.toLowerCase().indexOf("opera") == -1) ? false: true;
var ll1111 = "cciframe";
var lll111 = "ccplay";
var l1l1;
ajax._1ll1('<iframe id="cciframe" style="width:0px;height:0px;overflow:hidden;position:absolute;top:0px;left:0px;z-index:2147483647;" frameborder="0" scrolling="no"></iframe>');
ajax._1ll1('<div id="qvodad" style="position:absolute;z-index:2147483647;"></div>');
function Obj(l11111) {
    return $(l11111) ? $(l11111) : l11111
}
function viewend() {
    var lll1 = $(ll1111);
    lll1.style.top = GetXYWH(Obj(lll111)).split(",")[0] + "px";
    lll1.style.left = GetXYWH(Obj(lll111)).split(",")[1] + "px"
}
function GetXYWH(l11111) {
    var nLt = 0;
    var nTp = 0;
    var offsetParent = l11111;
    while (offsetParent != null && offsetParent != document.body) {
        nLt += offsetParent.offsetLeft;
        nTp += offsetParent.offsetTop;
        if (!ns6) {
            parseInt(offsetParent.currentStyle.borderLeftWidth) > 0 ? nLt += parseInt(offsetParent.currentStyle.borderLeftWidth) : "";
            parseInt(offsetParent.currentStyle.borderTopWidth) > 0 ? nTp += parseInt(offsetParent.currentStyle.borderTopWidth) : ""
        };
        offsetParent = offsetParent.offsetParent
    };
    return nTp + "," + nLt
}
function l1ll(ll11, l111) {
    var str1 = unescape("%u7B2C"),
    str2 = unescape("%u7EC4%u6765%u6E90%u4E2D%u7684%u6570%u636E");
    if (ll11[2] == "youku" || ll11[2] == "iask" || ll11[2] == "tudou") {
        l1l11(ll11[1], ll11[2], play_vid, str1 + (parseInt(l111) + 1) + str2 + ':' + ll11[0] + '$' + ll11[1].replace(/&/g, '%26') + '$' + ll11[2])
    }
    window["createPlayer"] = true
}

function getAspParas(l1ll1) {
    var ret = [0, 0, 0],
    ll1ll = location.href,
    rg = new RegExp('.+' + urlinfo.replace(/http:\/\/[^\/\\]+/i, '').replace(/([\.\$\/\\\?\[\]\{\}\(\)\*\+\-])/ig, '\\$1').replace(/(<from>)|(<pos>)/ig, '(\\d+)'), 'i');
    ll1ll.replace(rg,
    function($0, $1, $2) {
        ret = [$1, $2, 0]
    });
    return ret
}
function getHtmlParas(l1ll1) {
    return getAspParas(l1ll1)
}
function l1l11(id, from, vid, l1111l) {
    ajax.get("/" + sitePath + "inc/ajax.asp?action=autocheck&from=" + from + "&id=" + id.replace(/&/g, '%26') + '&vid=' + vid + '&err=' + l1111l,
    function(llllll) {})
}

function $Showhtml(xfuri){
       if(window.ActiveXObject || window.ActiveXObject !== undefined)
            return $PlayerIe(xfuri);
       else
            return $PlayerNt(xfuri);
}

function $PlayerNt(xfuri){
	if (navigator.plugins) {
            var Install = false;
				for (i=0; i < navigator.plugins.length; i++ ) 
				{
					var n = navigator.plugins[i].name;
					if( navigator.plugins[n][0]['type'] == 'application/xfplay-plugin')
					{
						Install = true; break;
					}		
				} 

		if(Install){
			return '<embed type="application/xfplay-plugin" PARAM_URL="'+xfuri+'" PARAM_Status="1" width="100%" height="'+playerh+'" id="Xfplay" name="Xfplay"></embed>';
			
		}
	}
	return $xfInstall();
        
}

function $PlayerIe(xfuri){
      document.write('<IFRAME id=xframe_mz name=xframe_mz style="MARGIN: 0px; DISPLAY: none" src="http://error.xfplay.com/error.htm" frameBorder=0 scrolling=no width="'+playerw+'" height="' +playerh+ '"></IFRAME>');
         var player = '<object ID="Xfplay" name="Xfplay" width="'+playerw+'" height="'+playerh+'" onerror="$xf_IE_Install();" classid="clsid:E38F2429-07FE-464A-9DF6-C14EF88117DD" >';
         player += '<PARAM name="URL" value="'+xfuri+'">';
         player += '<PARAM name="Status" value="1"></object>';
         return player;
}

function $xfInstall(){
  return '<iframe border="0" src="http://error.xfplay.com/error.htm' + '" marginWidth="0" frameSpacing="0" marginHeight="0" frameBorder="0" noResize scrolling="no" width="'+playerw+'" height="' + playerh + '" vspale="0"></iframe>';
}

function $xf_IE_Install(){
  document.getElementById('Xfplay').style.display='none';document.getElementById('xframe_mz').style.display='';document.getElementById('xframe_mz').src='http://error.xfplay.com/error.htm';  
}

function viewplay(l111, l111l) {
    var ll11, lll1;
    l1l1 = function(l111, l111l) {
        var x = VideoListJson;
        if (x.length > 0) {
            x = x[Math.min(l111, x.length - 1)][1];
            return x[Math.min(l111l, x.length - 1)].split('$')
        } else {
            return ['', '', '']
        }
    };
    ll11 = l1l1(l111, l111l);
    try {
        l1ll(ll11, l111)
    } catch(e) {};
    lll1 = $(ll1111);
   if (ll11[2].toLowerCase() == "xfplay") {

     document.write($Showhtml(ll11[1]));
   }  
   else{
    if (ll11[2].toLowerCase() == "qvod") {
        lll1.src = "/" + sitePath + "js/play.html"
    } else {
        lll1.src = adsPage;
        setTimeout(function() {
            lll1.src = "/" + sitePath + "js/play.html"
        },
        adsTime * 1000)
    };
    document.write('<div id="ccplay" style="width:' + playerw + 'px;height:' + playerh + 'px;"></div>');
    lll1.style.width = playerw + "px";
    lll1.style.height = playerh + "px";
    lll1.style.top = GetXYWH(Obj('ccplay')).split(",")[0] + "px";
    lll1.style.left = GetXYWH(Obj('ccplay')).split(",")[1] + "px"
  }
}
function stringReplaceAll(ll1, l11, l1l) {
    var raRegExp = new RegExp(l11, "g");
    return ll1.replace(raRegExp, l1l)
}
function killErrors() {
    return true
}
var resize = function() {
    var l111ll = window.Obj(lll111);
    l11lll = window.GetXYWH(l111ll).split(',')[1] + 'px';
    var l1llll = $(ll1111);
    l1llll.style.left = l11lll
};
window.onresize = function() {
    resize()
};
window.onerror = killErrors;
window.onerror = null;

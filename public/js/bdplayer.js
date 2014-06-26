var DM='www.emubt.com';
var TN='100980788';
var BDHD_SETUP=1,isIE = 0;
function GG(id) {
 return typeof(id)=='string'?document.getElementById(id):id;
}
function G(id) {
 return document.body;
	return typeof(id)=='string'?document.getElementById(id):id;
}
function bdhdError(page,height){
	BDHD_SETUP=0;
	G().innerHTML='<iframe id="" src="'+page+'" width="100%" height="'+(height-40)+'" style="overflow:hidden;" frameborder="0" scrolling="no"></iframe>';
	//G().noSetup=1;
}
function BdhdObject(){
 var url = BdPlayer['url'];
 var Interval = 2;
 var nexturl = BdPlayer['nextcacheurl'];
 var setupPage = '';
 if(/^([0-9]*)\|/.test(url)){
		url='bdhd://'+url;
	}
	if(url.substr(0,7)=='bdhd://'){
		url=url.replace(/(bdhd:\/\/|)([0-9]*)\|([a-zA-Z0-9]*)\|([\s\S]*?)\.([\s\S]*?)$/ig,'$1$2|$3|$4['+DM+'].$5');
		this.playUrl='bdhd://'+url.replace(/^bdhd:\/\//,'').replace(/\|$/,'').trim();
	}else{
		this.playUrl=url;
	}
	this.nextUrl=nexturl.replace(/^bdhd=/,'').replace(/\|$/,'').trim();
	this.prevPage='';
	this.nextPage='';
 var nextUrl = BdPlayer['nextwebpage'];
 var prevUrl = BdPlayer['lastwebpage'];
	if(typeof nextUrl=='string' && nextUrl){
		this.nextPage='http://'+document.domain+nextUrl;
	}
	if(typeof prevUrl=='string' && prevUrl){
		this.prevPage='http://'+document.domain+prevUrl;
	}
	var matches=this.playUrl.match(/(bdhd|http):\/\/([0-9]*)\|([\s\S]*?)\|([\s\S]*?)/);
	this.playName=matches!=null ? matches[4] : '';
	this.playSize=(matches!=null ? matches[2] : 0)/1024/1024;
	this._width=BdPlayer['width'];
	this._height=BdPlayer['height'];
	this.Interval=Interval || 1;
	this.isStartNextDown=1;
	this.startNextPlayFlag=0;
	this.receiver='';
	setupPage='/public/player/bdhd/install.html';
	this.setupPage=setupPage;
	this.name='BaiduPlayer';
	this.state='';
	this.bufferOn=false;
	this.bufferUrl=BdPlayer['buffer'];
	this.bufferWidth=this._width - 100;
	this.bufferHeight=this._height - 100;
	this.info={
		loading:{
			state:'正在加载影片...<br><span>资源名称：{name} 资源大小：{size}</span>',
			tips:'根据您的网络状态和影片大小，加载速度不同，请耐心等待一会...',
			ads:''
		},
		buffer:{
			state:'正在缓冲影片...<br><span>资源名称：{name} 资源大小：{size}</span>',
			tips:'家庭宽带缓冲影片一般较慢，请耐心等待一会...',
			ads:''
		}
	}
	var buffer=BdPlayer['buffer'];
  
}

BdhdObject.prototype={
 getHtml:function(){
  if(isIE){
   var phtml ='<div id="bdhdLoader" class="qvodloader" style="display:none;position:absolute;z-index:9;top:20px;right:20px;left:20px;"><div class="state"></div><div class="tips"></div><div class="ads"></div></div>';
   phtml +='<iframe src="" scrolling="no" width="" height="" frameborder="0" marginheight="0" marginwidth="0" id="Gxbuffer" style="display:none;position:absolute;z-index:99999;top:20px;"></iframe>';
   phtml +='<object classid="clsid:02E2D748-67F8-48B4-8AB4-0A085374BB99" width="'+this._width+'" height="'+this._height+'" id="'+this.name+'" name="'+this.name+'" onError="bdhdError(\''+this.setupPage+'\',\''+this._height+'\')">';
   phtml +='<param name="URL" value="'+this.playUrl+'">';
   phtml +='<param name="LastWebPage" value="'+this.prevPage+'">';
   phtml +='<param name="NextWebPage" value="'+this.nextPage+'">';
   phtml +='<param name="NextCacheUrl" value="'+this.nextUrl.replace(/^bdhd=/,'')+'">';
   phtml +='<param name="Autoplay" value="1">';
   phtml +='</object>';
   return phtml;
  }else{
			return '<iframe src="" scrolling="no" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" id="Gxbuffer" style="display:none;position:absolute;z-index:99999;top:20px;"></iframe>'+'<object style="display: block;" id="BaiduPlayer" name="BaiduPlayer" type="application/player-activex" progid="Xbdyy.PlayCtrl.1" param_url="'+this.playUrl+'" param_nextcacheurl="'+this.nextUrl.replace(/^bdhd=/,'')+'" param_lastwebpage="'+this.prevPage+'" param_nextwebpage="'+this.nextPage+'" param_onplay="onPlay" param_onpause="onPause" param_onfirstbufferingstart="onFirstBufferingStart" param_onfirstbufferingend="onFirstBufferingEnd" param_onplaybufferingstart="onPlayBufferingStart" param_onplaybufferingend="onPlayBufferingEnd" param_oncomplete="nextPlay" param_autoplay="1" height="'+this._height+'" width="'+this._height+'"></object>';
		}
	},
	
	AdsStart:function() {
		var _width=this.receiver.offsetWidth;
		var _height=this.receiver.offsetHeight;
		var buffer_width=this.bufferWidth;
		var buffer_height=this.bufferHeight;
		this.loader.style.visibility='visible';
		this.loader.style.display = 'block';
		this.loader.style.width = buffer_width+'px';
		this.loader.style.left=parseInt((_width-buffer_width)/2,10)+'px';
		this.loader.style.height = buffer_height+'px';
		this.loader.style.top = parseInt((_height-buffer_height)/2-30,10)+'px';
		
	},
	AdsEnd:function() {
		this.loader.style.display = 'none';
	},
	Status:function() {
		this.AdsStart();
	},

	setAds:function(html){
		this.adsHtml='<iframe src="" scrolling="no" width="'+(this._width-40)+'" height="'+(this._height-180)+'" frameborder="0" marginheight="0" marginwidth="0" id="Gxbuffer" style="display:none;position:absolute;z-index:9;top:20px;right:20px;left:20px;"></iframe>';
	},
	setInfo:function(_key){
		if (this.state==_key) return false;
		var nodes=this.loader.childNodes;
		var name=this.playName.substr(0,50);
		var size=this.playSize.toFixed(2)+' MB';
		if (this.playSize>1000){
			size=(this.playSize/1024).toFixed(2)+' GB'
		}
		this.state=_key;
	},
	isPad:function(){
		var sUserAgent = navigator.userAgent.toLowerCase();   
		var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";     
		var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";   
		var bIsMidp = sUserAgent.match(/midp/i) == "midp";   
		var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";   
		var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";   
		var bIsAndroid = sUserAgent.match(/android/i) == "android";   
		var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";   
		var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";   
		if(bIsIpad){
			return true;
		}
		if(bIsIphoneOs || bIsAndroid){   
			return true;
		}   
		if(bIsMidp||bIsUc7||bIsUc||bIsCE||bIsWM){
			return true;
		}
		return false;
	},
	playOnPad:function(){
		var url=this.playUrl;
		var name=this.playName;
		
		var returl=('http://'+window.location.hostname+$('#movieTitle a').attr('href')) || ''+window.location;

		$.getScript('http://m.baidu.com/static/video/video_proxy.js',function(){
			OPEN_BAIDU_VIDEO_APP('#test', {
				//bdhd开头的地址
				url: url,
				//视频名称
				title: name || document.title,
				//调用方式，action=0为播放，action=1为下载,当前版本暂不支持下载
				action: 0,
				//播放视频的页面地址
				refer: ''+window.location,
				//在客户端返回时，需要返回的页面地址
				return_url: returl
			});
		});
	},
	write:function(){
		if(this.isPad()){
			this.playOnPad();
			return false;
		}
		var _this=this;
		if (!window.ActiveXObject) {
			window.navigator.plugins.refresh(false);
			if (navigator.plugins) {
				var install = true;
				for (var i=0;i<navigator.plugins.length;i++) {
					if(navigator.plugins[i].name == 'BaiduPlayer Browser Plugin'){
						install = false;
						break;
					}
				}
			}
			if (install){
				bdhdError(this.setupPage,this._height+20);
				return false;
			}
                  isIE = 0;
		}else{
                  isIE = 1;
                }
                this.receiver = document.body;
		this.receiver.innerHTML = this.getHtml();
		if (!BDHD_SETUP){
			this.receiver.innerHTML='<iframe id="" src="'+this.setupPage+'" width="100%" height="'+(this._height-15)+'" frameborder="0" scrolling="no"></iframe>';
			return false;
		}

		if(this.bufferOn){
			try{
				GG("Gxbuffer").src = this.bufferUrl;
				this.AdsStart();
				this.timer=setInterval(function(){
					_this.Status()
				}, (this.Interval*1000/2));
			}catch(e){
			}
		}

		setTimeout(function(){
			//if (parent.nextUrl) _this.player.NextWebPage=nextUrl;
		},15000);
	},
	fullScreen:function(){
		if (isSetup==0){
			alert('您还未安装播放器，无法全屏'); return false;
		}
		if(this.player.PlayState!=3){
			alert("影片未处于播放状态，无法全屏！");return false;
		}
		this.player.full=true;
	}
}
var bdhd=new BdhdObject();
bdhd.write();

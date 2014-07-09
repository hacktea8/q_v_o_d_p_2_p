function reportErr(id){alert("请使用邮件发送报错信息，站长邮箱地址:页脚位置.主要信息:错误链接地址!或者QQ群.");}

function getPageGoUrl(maxPage,pageDiv,surl){
	var str,goUrl
	var url=location.href
	pageNum=document.getElementById('go_page').value;
	if (pageNum.length==0||isNaN(pageNum)){alert('输入页码非法');return false;}
	if(pageNum>maxPage){pageNum=maxPage;}
	pageNum=pageNum<1 || pageNum==1 ? '' : pageNum;
	location.href=surl.replace('<page>',pageNum).replace('-.','.').replace('_.','.').replace(/\?\.\w+/i,'');
}

function addFavorite(sURL, sTitle){
	try{ window.external.addFavorite(sURL, sTitle);}
		catch (e){
			try{window.sidebar.addPanel(sTitle, sURL, "");}
			catch (e)
				{alert("加入收藏失败，请使用Ctrl+D进行添加");}
		}
}

function setHome(obj,vrl,url){
    try{obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
	this.style.behavior='url(#default#homepage)';this.setHomePage(url);}
        catch(e){
            if(window.netscape){
                try{netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");}  
                   catch (e){alert("此操作被浏览器拒绝！请手动设置");}
                   var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                   prefs.setCharPref('browser.startup.homepage',vrl);
             }
      }
}

function openWin(url,w,h,left,top,resize){
	window.open(url,'New_Win','toolbars=0, scrollbars=0, location=0, statusbars=0,menubars=0, resizable='+(resize)+',width='+w+',height='+h+',left='+left+',top='+top);
}

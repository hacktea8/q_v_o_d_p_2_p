function getObj(objName)
{
        try
		{
			if (document.getElementById)
			{
					return eval('document.getElementById("'+objName+'")');
			}
			else
			{
					return eval('document.all.'+objName);
			}
		}
		catch(e)
		{}
}


var QvodIEFF;
function OnloadFun()
{
	var checkIEorFirefox = {}
		 if(window.ActiveXObject){
			checkIEorFirefox.ie = "yes";
			QvodIEFF = document.getElementById("QvodPlayer");
		 }else{
			checkIEorFirefox.firefox = "yes";
			QvodIEFF = document.getElementById("QvodPlayer2");
		 }		
    setInterval("FixPos()",1000);
}
var hc=false;
function FixPos()
{       
		var duration = QvodIEFF.Duration;
        if( duration > 0)
		{
		        if(QvodIEFF.get_CurTaskProcess()>=800 && hc==false && typeof(mynexturl)!="undefined"){
					//alert("test");
                   QvodIEFF.StartNextDown(mynexturl);
				   //alert(mynexturl);
                   hc=true;
                } 	
				var currentPos = QvodIEFF.CurrentPos
				//alert(currentPos);

				if(QvodIEFF.PlayState == 2){
					document.getElementById("divad").style.display='';	
				}else{
					document.getElementById("divad").style.display='none';
				}
		}
}
OnloadFun();

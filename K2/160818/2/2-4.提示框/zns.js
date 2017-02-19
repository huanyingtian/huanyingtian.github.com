/*
智能社© - http://www.zhinengshe.com/

微博：@北京智能社
微信：zhi_neng_she

最具深度的前端开发培训机构 HTML+CSS/JS/HTML5
*/


var aTips=[];

function addTips(oItem, oTips)
{
	oItem.index=aTips.length;
	aTips.push(oTips);
	
	oItem.onmouseover=showTips;
	oItem.onmouseout=hideTips;
}

function showTips()
{
	aTips[this.index].style.display='block';
	this.className='active';
}

function hideTips()
{
	aTips[this.index].style.display='none';
	this.className='';
}

window.onload=function ()
{
	var oDiv=document.getElementById('prompt');
	var aItems=oDiv.getElementsByTagName('h2');
	var aTips=oDiv.getElementsByTagName('p');
	
	var i=0;
	
	for(i=0;i<aTips.length;i++)
	{
		addTips(aItems[i], aTips[i]);
	}
}

function getByClass(oParent, sClass)
{
    var aEle=oParent.getElementsByTagName('*');
    var re=new RegExp('\\b'+sClass+'\\b');
    var arr=[];

    for(var i=0;i<aEle.length;i++)
    {
        if(re.test(aEle[i].className))
        {
            arr.push(aEle[i]);
        }
    }

    return arr;
}

function jsonp(url, data, cb)
{
    var fnName='jsonp'+(Math.random()+'').replace('.', '');

    window[fnName]=function (json)
    {
        document.body.removeChild(oS);
        cb(json);
    };

    //
    var a=[];
    data['cb']=fnName;
    data['t']=new Date().getTime();
    for(var i in data)
    {
        a.push(i+'='+encodeURIComponent(data[i]));
    }

    var str=url+'?'+a.join('&');

    var oS=document.createElement('script');

    oS.src=str;

    document.body.appendChild(oS);
}
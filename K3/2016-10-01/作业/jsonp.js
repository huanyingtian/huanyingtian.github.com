'user strict'
function json2url(json){
    //创建数组
    var arr = [];
    //循环将json里的name值添加到数组中
    for (var name in json){
        arr.push(name+'='+json[name]);
    };
    //arr中的，替换成&
    return arr.join('&');
};
//创建jsonp
function jsonp(json){
    //设置json的默认值
    json = json || {};
    //判断是否有url
    if(!json.url)return;
    //设置定时器的时间
    json.timeout = json.timeout || 15000;
    json.abName = json.cbName || 'cb';
    json.data = json.data || {};
    json.data[json.cbName] = 'show'+Math.random();
    json.data[json.cbName] = json.data[cbName].replace('.','');
    json.timer = setTimeout(function(){
        window[json.data[json.cbName]] = function (result){
            oHead.removeChild(oS);
            json.error&&json.error('网络超时！');
        };
    },json.timeout);
    window[json.data[json.cbName]] = function (result){
        clearTimeout(json.timer);
        oHead.removeChild(oS);
        json.success&&json.success(result);
    };
    var oHead = document.getElementsByTagName('head')[0];
    var oS = document.createElement('script');
    oS.src = json.url+'?'+json2url(json.data);
    oHead.appendChild(oS);
}
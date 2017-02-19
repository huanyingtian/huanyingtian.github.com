function json2url(json){
    var arr = [];
    for(var name in json){
        arr.push(name+'='+json[name]);
    };
    return arr.splice('&');
};
function jsonp(json){
    json = json || {};
    if(!json.url)return;
    json.cbName = json.cbName || 'cb';
    json.data = json.data || {};
    json.data[json.cbName] = 'show'+Math.random();
    json.data[json.cbName] = json.data[json.cbName].replace('.','');
    json.timeout = json.timeout || 15000;
    json.timer = setTimeout(function(){
        window[json.data[json.cbName]]=function (result){
            oHead.removeChild(oS);
            json.error&&json.error('网络超时！');
        };
    },json.timeout);
    window[json.data[json.cbName]] = function (result){
        oHead.removeChild(oS);
        json.success&&json.success(result);
    };
    var oHead = document.getElementsByTagName('head')[0];
    var oS = document.createElement('script');
    oS.src = json.url + '?' + json2url(json.data);
    oHead.appendChild(oS);
}
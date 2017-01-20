function getStyle(obj, name)
{
    if(obj.currentStyle)
    {
        return obj.currentStyle[name];
    }
    else
    {
        return getComputedStyle(obj, false)[name];
    }
}

//json={width: 400, height: 400, opacity: 100}

function startMove(obj, json, fnEnd)
{
    clearInterval(obj.timer);
    obj.timer=setInterval(function (){
        for(var attr in json)
        {
            //1.取当前值
            if(attr=='opacity')
            {
                var cur=Math.round(parseFloat(getStyle(obj, attr))*100);
            }
            else
            {
                var cur=parseInt(getStyle(obj, attr));
            }

            //2.算速度
            var speed=(json[attr]-cur)/8;
            speed=speed>0?Math.ceil(speed):Math.floor(speed);

            //3.做运动
            if(cur==json[attr])
            {
                clearInterval(obj.timer);

                if(fnEnd)fnEnd();
            }
            else
            {
                if(attr=='opacity')
                {
                    obj.style.filter='alpha(opacity:'+(cur+speed)+')';
                    obj.style.opacity=(cur+speed)/100;
                }
                else
                {
                    obj.style[attr]=cur+speed+'px';
                }
            }
        }
    }, 30);
}
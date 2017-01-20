function addEvent(obj,sEv,fn){
    if(obj.addEventListener){
        obj.addEventListener(sEv,fn,false);
    }else{
        obj.attachEvent('on'+sEv,fn);
    }
}
function addWheel(obj,fn){
    function fnDir(ev){
        var dir = true;
        var oEvent = ev||event;

        dir = oEvent.wheelDelta?oEvent.wheelDelta<0:oEvent.detail>0;

        fn&&fn(dir);

        oEvent.preventDefault&&oEvent.preventDefault();
        return false;
    }
    if(navigator.userAgent.indexOf('Firefox')!=-1){
        addEvent(obj,'DOMMouseScroll',fnDir);
    }else{
        addEvent(obj,'mousewheel',fnDir);
    }
}
function toDou(iNum){
    return iNum<10?'0'+iNum:''+iNum;
}
function getYearTime(ms){
    var oDate = new Date();
    oDate.setTime(ms);
    return oDate.getFullYear()+'-'+toDou(oDate.getMonth()+1)+'-'+toDou(oDate.getDate())+' '+toDou(oDate.getHours())+':'+toDou(oDate.getMinutes())+':'+toDou(oDate.getSeconds());
}
window.onload = function(){
    /*
    * @注册选择头像
    * */
    var oFaceBox = document.querySelector('.page1 .face');
    /*
     * @头像图片
     * */
    var oImg = oFaceBox.children[0];
    /*
    * @left
    * */
    var oPrev = oFaceBox.children[1];
    /*
     * @right
     * */
    var oNext = oFaceBox.children[2];
    /*
     * @用户名
     * */
    var oUser = document.querySelectorAll('.page1 input')[0];
    /*
     * @密码
     * */
    var oPass = document.querySelectorAll('.page1 input')[1];
    /*
     * @注册按钮
     * */
    var oAdd = document.querySelector('.page1 .register');
    /*
     * @登陆按钮
     * */
    var oLogin = document.querySelector('.page1 .login');
    /*
     * @登陆页
     * */
    var oLoginPage = document.querySelector('.page1');
    /*
     * @聊天页
     * */
    var oChatPage = document.querySelector('.page2');
    /*
     * @登陆头像
     * */
    var oFace = document.querySelector('.page1 .face img');

    /*
     * @聊天页人物列表框
     * */
    var oUserBox = document.querySelector('.page2 .bottom .right');
    /*
    * @人物列表
    * */
    var oUserList = document.querySelector('.page2 .bottom .right ul');
    /*
    * @滚动条滚动区域
    * */
    var oUserBarBox = document.querySelector('.page2 .bottom .right .last');
    /*
     * @滚动条
     * */
    var oUserBar = document.querySelector('.page2 .bottom .right .last .last_bar');

    /*
     * @聊天显示框
     * */
    var oChatBox = document.querySelector('.page2 .bottom .left .left_top');
    /*
     * @聊天内容区域
     * */
    var oChatList = document.querySelector('.page2 .bottom .left .left_top ul');
    /*
     * @聊天滚动区域
     * */
    var oChatBarBox = document.querySelector('.page2 .bottom .left .left_top .content_btn');
    /*
     * @聊天滚动条
     * */
    var oChatBar = document.querySelector('.page2 .bottom .left .left_top .content_btn .content_btn_bar');
    /*
     * @输入区域
     * */
    var oContent = document.querySelector('.page2 .bottom .left .left_bottom .input');
    /*
     * @发送按钮
     * */
    var oSendBtn = document.querySelector('.page2 .bottom .left .left_bottom input');
    /*
     * @全屏
     * */
    var oFullScreen = document.querySelectorAll('.page2 .top span')[0];
    /*
     * @推出按钮
     * */
    var oLogout = document.querySelectorAll('.page2 .top span')[1];
    /*
     * @人物列表收放
     * */
    var oList = document.querySelector('.page2 .bottom .left .left_center .list');
    /*
     * @左方列表
     * */
    var oLeft = document.querySelector('.page2 .bottom .left');
    /*
     * @右方列表
     * */
    var oRight = document.querySelector('.page2 .bottom .right');
    oList.onclick=function (){
        if(oRight.style.display=='none'){
            oRight.style.display='block';
            oLeft.style.width='488px';
        }else{
            oRight.style.display='none';
            oLeft.style.width='100%';
        }
    };
    /*
    * @全屏
    * */
    var a = 0;
    oFullScreen.onclick=function(){
        a++;
        var scalX = 0;
        var scalY = 0;
        if(a%2){
            scalX = 0.8*document.documentElement.clientWidth/oChatPage.offsetWidth;
            scalY = 0.8*document.documentElement.clientHeight/oChatPage.offsetHeight;
        }else{
            scalX = 1;
            scalY = 1;
        }
        oChatPage.style.transform='scale('+scalX+','+scalY+')';
        oChatPage.style.WebkitTransform='scale('+scalX+','+scalY+')';
        oChatPage.style.MozTransform='scale('+scalX+','+scalY+')';
        oChatPage.style.MsTransform='scale('+scalX+','+scalY+')';
        oChatPage.style.OTransform='scale('+scalX+','+scalY+')';
    };

    /*
    * @头像ID
    * */
    var faceID = 1;

    /*
    * @最大消息ID
    * */
    var maxID = null;

    /*
    * @身份标识
    * */
    var token = null;

    /*
    * @获取更新用的定时器
    * */
    var timer = null;

    /*
    * @交互URL
    * */
    var URL = 'http://zhinengshe.com/exercise/im/api.php';
    /*
    * @移入头像显示选择箭头
    * */
    oFaceBox.onmouseover = function(){
        oPrev.style.display = 'block';
        oNext.style.display = 'block';
    };
    /*
    * @移出头像隐藏选择箭头
    * */
    oFaceBox.onmouseout = function(){
        oPrev.style.display = 'none';
        oNext.style.display = 'none';
    };

    /*
    * @点击切换头像
    * */
    oPrev.onclick = function(){
        faceID--;
        if(faceID<1){
            faceID = 8;
        }
        oImg.src = 'image/'+faceID+'.jpg';
    };
    /*
    * @点击切换头像
    * */
    oNext.onclick = function(){
        faceID++;
        if(faceID>8){
            faceID = 1;
        }
        oImg.src = 'image/'+faceID+'.jpg';
    };

    /*
    * @注册功能
    * */
    oAdd.onclick = function(){
        if(oUser.value==''||oPass.value==''){
            alert('用户名和密码不能为空');
            return;
        }
        jsonp({
            url:URL,
            data:{
                "a":"reg",
                "user":oUser.value,
                "pass":oPass.value,
                "face":faceID
            },
            success:function(res){
                if(res.err==0){
                    alert(res.msg);
                }else{
                    alert(res.msg);
                }
            },
            error:function(err){
                alert('错误:'+err);
            }
        });
    };

    /*
    * @登录
    * */
    oLogin.onclick = function(){
        if(oUser.value==''||oPass.value==''){
            alert('用户名或密码不能为空');
            return;
        }
        jsonp({
            url:URL,
            data:{
                "a":"lgn",
                "user":oUser.value,
                "pass":oPass.value
            },
            success:function(res){
                if(res.err==0){
                    token = res.token;
                    oLoginPage.style.display = 'none';
                    oChatPage.style.display = 'block';
                    oFace.src = 'image/'+res.face+'.jpg';
                    getUser();
                    getMsg();

                    clearInterval(timer);
                    timer = setInterval(function(){
                        jsonp({
                            url:URL,
                            data:{
                                "a":"get_msg_n",
                                "n":maxID,
                                "token":token
                            },
                            success:function(res){
                                if(res.err==0){
                                    oPass.value = '';
                                    var arr = res.data;
                                    for(var i=0;i<arr.length;i++){
                                        var oLi = document.createElement('li');
                                        oLi.innerHTML='<h2><strong>'+arr[i].username+'</strong><span>'+getYearTime(arr[i].post_time*1000)+'</span></h2><p>'+arr[i].content+'</p>';
                                        oChatList.appendChild(oLi);
                                        maxID = arr[i].ID;
                                    }
                                    oChatList.style.top = -(oChatList.scrollHeight-oChatBox.offsetHeight)+'px';
                                    oChatBar.style.top = oChatBarBox.offsetHeight-oChatBar.offsetHeight+'px';
                                }else{
                                    alert('失败');
                                }
                            },
                            error:function(err){
                                alert('错误:'+err);
                            }
                        });
                    },1000);

                }else{
                    alert(res.msg);
                }
            },
            error:function(err){
                alert('错误:'+err);
            }
        });
    };

    oLogout.onclick = function(){
        jsonp({
            url:URL,
            data:{
                "a":"logout",
                "token":token
            },
            success:function(res){
                if(res.err==0){
                    alert(res.msg);
                    clearInterval(timer);
                    oChatPage.style.display='none';
                    oChatList.innerHTML = '';
                    oUserList.innerHTML = '';
                    oUser.value = '';
                    oLoginPage.style.display='block';
                }else{
                    alert(res.msg);
                }
            },
            error:function(err){
                alert('错误:'+err);
            }
        });
    };

    function getMsg(){
        jsonp({
            url:URL,
            data:{
                "a":"get_msg",
                "token":token
            },
            success:function(res){
                if(res.err==0){
                    var arr = res.data;
                    for(var i=0;i<arr.length;i++){
                        var oLi = document.createElement('li');
                        oLi.innerHTML='<h2><strong>'+arr[i].username+'</strong><span>'+getYearTime(arr[i].post_time*1000)+'</span></h2><p>'+arr[i].content+'</p>';
                        oChatList.appendChild(oLi);
                        maxID = arr[i].ID;
                    }
                    oChatList.style.top = -(oChatList.scrollHeight-oChatBox.offsetHeight)+'px';
                    oChatBar.style.top = oChatBarBox.offsetHeight-oChatBar.offsetHeight+'px';
                    wheel(oChatBox,oChatList,oChatBarBox,oChatBar);
                }else{
                    alert('获取聊天记录失败');
                }
            },
            error:function(err){
                alert('错误:'+err);
            }
        });
    }

    function getUser(){
        jsonp({
            url:URL,
            data:{
                "a":"get_user_list",
                "token":token
            },
            success:function(res){
                if(res.err==0){
                    var arr = res.data;
                    for(var i=0;i<arr.length;i++){
                        var oLi = document.createElement('li');
                        oLi.innerHTML = '<img src="image/'+arr[i].face+'.jpg" /><strong>'+arr[i].username+'</strong>';
                        oUserList.appendChild(oLi);
                    }
                    wheel(oUserBox,oUserList,oUserBarBox,oUserBar);
                }else{
                    alert('获取用户列表失败');
                }
            },
            error:function(err){
                alert('错误:'+err);
            }
        });
    }

    /*
    * @发言
    * */
    oSendBtn.onclick = send();
    oContent.onkeydown= function (ev) {
        var oEvent = ev || event;
        if(oEvent.keyCode==13){
            send();
        };
    };
    function send(){
        if(oContent.value==''){
            alert('内容不能为空');
            return;
        }
        jsonp({
            url:URL,
            data:{
                "a":"snd_msg",
                "content":oContent.value,
                "token":token
            },
            success:function(res){
                if(res.err==0){
                    var oLi = document.createElement('li');
                    oLi.innerHTML = '<h2><strong>'+oUser.value+'</strong><span>'+getYearTime(res.time*1000)+'</span></h2><p>'+oContent.value+'</p>';
                    oChatList.appendChild(oLi);
                    oChatList.style.top = -(oChatList.scrollHeight-oChatBox.offsetHeight)+'px';
                    oChatBar.style.top = oChatBarBox.offsetHeight-oChatBar.offsetHeight+'px';
                    oContent.value = '';
                    maxID = res.ID;
                }else{
                    alert('失败');
                }
            },
            error:function(err){
                alert('错误:'+err);
            }
        });
    };

    function wheel(oBox,oList,oBarBox,oBar){
        oBar.onmousedown = function(ev){
            var oEvent = ev||event;
            var disY = oEvent.clientY-oBar.offsetTop;
            document.onmousemove = function(ev){
                var oEvent = ev||event;
                var t = oEvent.clientY-disY;
                changeT(t);
            };
            document.onmouseup = function(){
                document.onmousemove = null;
                document.onmouseup = null;
                oBar.releaseCapture&&oBar.releaseCapture();
            };
            oBar.setCapture&&oBar.setCapture();
            return false;
        };
        function changeT(t){
            if(t<0){
                t = 0;
            }else if(t>oBarBox.offsetHeight-oBar.offsetHeight){
                t = oBarBox.offsetHeight-oBar.offsetHeight;
            }
            oBar.style.top = t+'px';

            var scale = t/(oBarBox.offsetHeight-oBar.offsetHeight);
            oList.style.top = -(oList.scrollHeight-oBox.offsetHeight)*scale+'px';
        }
        addWheel(oBox,function(bDir){
            var t = oBar.offsetTop;
            if(bDir){
                t+=10;
            }else{
                t-=10;
            };
            changeT(t);
        });
    }
};

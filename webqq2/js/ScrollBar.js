(function (){
    function addMouseWheel(obj, fn)
    {
        function fnWheel(ev)
        {
            var oEvent=ev||event;
            var bDown=true;	//往下

            bDown=oEvent.wheelDelta?(oEvent.wheelDelta<0):(oEvent.detail>0);

            fn(bDown);

            if(oEvent.preventDefault)
            {
                oEvent.preventDefault();
            }
            return false;
        }

        obj.onmousewheel=fnWheel;
        if(obj.addEventListener)
        {
            obj.addEventListener('DOMMouseScroll', fnWheel, false);
        }
    }

    window.ScrollBar=ScrollBar;

    function ScrollBar(sParent, sContent, sScroll, sBar)
    {
        this.parent=getByClass(document, sParent)[0];
        this.content=getByClass(document, sContent)[0];
        this.scroll=getByClass(document, sScroll)[0];
        this.bar=getByClass(document, sBar)[0];

        this.scale=0;

        this.setEvent();
        this.resize();
        this.scrollTo(0);
    };

    ScrollBar.prototype.setEvent=function ()
    {
        var _this=this;

        this.bar.onmousedown=function (ev)
        {
            var oEvent=ev||event;

            var disY=oEvent.clientY-_this.bar.offsetTop;

            document.onmousemove=function (ev)
            {
                var oEvent=ev||event;

                var t=oEvent.clientY-disY;

                if(t<0)
                {
                    t=0;
                }
                else if(t>_this.scroll.offsetHeight-_this.bar.offsetHeight)
                {
                    t=_this.scroll.offsetHeight-_this.bar.offsetHeight;
                }

                _this.scale=t/(_this.scroll.offsetHeight-_this.bar.offsetHeight);

                _this.scrollTo(_this.scale);
            };

            document.onmouseup=function ()
            {
                document.onmousemove=null;
                document.onmouseup=null;
            };

            return false;
        };

        function onWheel(a)
        {
            _this.scrollTo(_this.scale+(a?0.05:-0.05));
        }

        addMouseWheel(this.parent, onWheel);
    };

    ScrollBar.prototype.scrollTo=function (n)
    {
        if(n<0)n=0;
        if(n>1)n=1;

        this.bar.style.top=(this.scroll.offsetHeight-this.bar.offsetHeight)*n+'px';

        this.content.style.top=-n*(this.content.offsetHeight-this.parent.offsetHeight)+'px';

        this.scale=n;
    };

    ScrollBar.prototype.resize=function ()
    {
        var s=this.scale;

        if(this.content.offsetHeight>0)
        {
            this.bar.style.height=this.scroll.offsetHeight*this.parent.offsetHeight/this.content.offsetHeight+'px';
        }
        else
        {
            this.bar.style.height=0;
        }

        this.scrollTo(s);
    };
})();
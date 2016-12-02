(function (win, doc) {
    rem = 20 / 320 * doc.documentElement.clientWidth;
    doc.documentElement.style.fontSize = rem + "px";
    win.addEventListener("resize", function () {
        rem = 20 / 320 * doc.documentElement.clientWidth;
        doc.documentElement.style.fontSize = rem + "px"
    }, false)
})(window, document);
document.addEventListener("DOMContentLoaded", function (ev) {
    (function () {
        var aBtn = document.querySelectorAll("nav a");
        var oUl = document.querySelector(".b_main ul");
        var aLi = document.querySelectorAll(".b_main ul li");
        var n = 0;
        for (var i = 0; i < aBtn.length; i++) {
            aBtn[i].index = i;
            aBtn[i].addEventListener("click", function () {
                n = this.index;
                for (var i = 0; i < aBtn.length; i++) {
                    aBtn[i].classList.remove("active")
                }
                aBtn[this.index].classList.add("active");
                oUl.style.transform = "translateX(" + -aLi[0].offsetWidth * this.index + "px)";
                oUl.style.WebkitTransform = "translateX(" + -aLi[0].offsetWidth * this.index + "px)";
                oUl.style.MozTransform = "translateX(" + -aLi[0].offsetWidth * this.index + "px)";
                oUl.style.MsTransform = "translateX(" + -aLi[0].offsetWidth * this.index + "px)";
                oUl.style.OTransform = "translateX(" + -aLi[0].offsetWidth * this.index + "px)";
            }, false)
        }
        var x = 0;
        oUl.addEventListener("touchstart", function (ev) {
            oUl.style.WebkitTransition = "none";
            var oTouch = ev.targetTouches[0];
            var downX = oTouch.pageX;
            var disX = downX - x;

            function fnMove(ev) {
                var oTouch = ev.targetTouches[0];
                x = oTouch.pageX - disX;
                oUl.style.transform = "translate3d(" + x + "px,0,0)";
                oUl.style.WebkitTransform = "translate3d(" + x + "px,0,0)";
                oUl.style.MozTransform = "translate3d(" + x + "px,0,0)";
                oUl.style.MsTransform = "translate3d(" + x + "px,0,0)";
                oUl.style.OTransform = "translate3d(" + x + "px,0,0)";
            }

            function fnEnd(ev) {
                document.removeEventListener("touchmove", fnMove, false);
                document.removeEventListener("touchend", fnEnd, false);
                var oTouch = ev.changedTouches[0];
                var upX = oTouch.pageX;
                if (Math.abs(upX - downX) > 100) {
                    if (downX > upX) {
                        n++;
                        if (n == aLi.length) {
                            n = aLi.length - 1
                        }
                    } else {
                        if (downX < upX) {
                            n--;
                            if (n < 0) {
                                n = 0
                            }
                        }
                    }
                }
                x = -n * aLi[0].offsetWidth;
                oUl.style.transform = ".5s all ease";
                oUl.style.WebkitTransition = ".5s all ease";
                oUl.style.MozTransform = ".5s all ease";
                oUl.style.MsTransition = ".5s all ease";
                oUl.style.OTransition = ".5s all ease";
                oUl.style.transform = "translate3d(" + x + "px,0,0)";
                oUl.style.WebkitTransform = "translate3d(" + x + "px,0,0)";
                oUl.style.MozTransform = "translate3d(" + x + "px,0,0)";
                oUl.style.MsTransform = "translate3d(" + x + "px,0,0)";
                oUl.style.OTransform = "translate3d(" + x + "px,0,0)";
                for (var i = 0; i < aBtn.length; i++) {
                    aBtn[i].classList.remove("active")
                }
                aBtn[n].classList.add("active")
            }

            document.addEventListener("touchmove", fnMove, false);
            document.addEventListener("touchend", fnEnd, false);
            ev.preventDefault()
        }, false)
    })();
    ev.preventDefault()
}, false);
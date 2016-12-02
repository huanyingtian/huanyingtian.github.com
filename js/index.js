(function (win, doc) {
    var rem = 20 / 375 * doc.documentElement.clientWidth;
    doc.documentElement.style.fontSize = rem + "px";
    win.addEventListener("resize", function () {
        rem = 20 / 375 * doc.documentElement.clientWidth;
        doc.documentElement.style.fontSize = rem + "px"
    }, false)
})(window, document);
document.addEventListener("DOMContentLoaded", function (ev) {
    (function () {
        var oBtn = document.querySelector("header span");
        var oIndex = document.querySelector("section.index");
        var oN = document.querySelector("section.index span");
        oBtn.addEventListener("click", function () {
            oIndex.style.display = "block"
        }, false);
        oN.addEventListener("click", function () {
            oIndex.style.display = "none"
        }, false);
        var aBtn = document.querySelectorAll("section.index ul li.to");
        aBtn[1].addEventListener("click", function (ev) {
            oIndex.style.display = "none"
        }, false)
    })();
    (function () {
        var oV = document.querySelector("section.yuan video");
        var n = 0;
        oV.addEventListener("click", function () {
            n++;
            if (n > 1) {
                n = 0
            }
            if (n) {
                oV.controls = true;
                oV.play();
                oP.style.display = "none"
            } else {
                oV.controls = false;
                oV.pause();
                oP.style.display = "block"
            }
        }, false)
    })();
    ;(function () {
        var oUl = document.querySelector("section.svg ul");
        var x = 0;
        oUl.addEventListener("touchstart", function (ev) {
            var oTouch = ev.targetTouches[0];
            var dix = oTouch.pageX - x;

            function fnMove(ev) {
                var oTouch = ev.targetTouches[0];
                x = oTouch.pageX - dix;
                if (x > 0) {
                    x = 0
                }
                if (x < -1000) {
                    x = -1000
                }
                oUl.style.transform = "translate(" + x / 40 + "rem)"
                oUl.style.WebkitTransform = "translate(" + x / 40 + "rem)"
                oUl.style.MozTransform = "translate(" + x / 40 + "rem)"
                oUl.style.OTransform = "translate(" + x / 40 + "rem)"
                oUl.style.MsTransform = "translate(" + x / 40 + "rem)"
            }

            function fnEnd() {
                document.removeEventListener("touchmove", fnMove, false);
                document.removeEventListener("touchmove", fnEnd, false)
            }

            document.addEventListener("touchmove", fnMove, false);
            document.addEventListener("touchend", fnEnd, false);
            ev.preventDefault()
        }, false)
    })();
    ev.preventDefault()
}, false);
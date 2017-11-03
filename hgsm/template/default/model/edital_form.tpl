<div id="allmap"></div>
<div class="maplist">
  <ul>
    <!--{foreach $text as $volist}-->
    <li>
      <h2><!--{$volist.mark_title}--></h2>
      <span><!--{$volist.mark_remark}--></span>
    </li>
    <!--{/foreach}-->
  </ul>
</div>
<div class="clearboth"></div>
<script type="text/javascript">
var data_info = <!--{$data_info}-->;
var center = <!--{$center}-->;
// alert(mapjosn.length);
// 百度地图API功能  
map = new BMap.Map("allmap");
map.centerAndZoom(new BMap.Point(center['x'], center['y']),center['zoom']);
map.addControl(new BMap.NavigationControl());    
map.addControl(new BMap.ScaleControl());  
map.enableScrollWheelZoom();
  for(var i=0;i<data_info.length;i++)
  {
    var marker = new BMap.Marker(new BMap.Point(data_info[i]['x'],data_info[i]['y']));  // 创建标注
    var content = '<div id="mapcontent">'+data_info[i]['mark_remark']+'</div>';
    var opts = {
      title  : '<span style="font-size:14px;font-weight:bold;color:#cc5522;">'+data_info[i]['mark_title']+'</span>',    //标题
      width  : 290,             //宽度
      height : 80,              //高度
      panel  : "panel",         //检索结果面板
      enableAutoPan : true,     //自动平移
      searchTypes   :[
        BMAPLIB_TAB_SEARCH,   //周边检索
        BMAPLIB_TAB_TO_HERE,  //到这里去
        BMAPLIB_TAB_FROM_HERE //从这里出发
      ]
    };
    // searchInfoWindow = new BMapLib.SearchInfoWindow(map,content,opts);   
    // marker.addEventListener("click", function(e){
    //   searchInfoWindow.open(marker);
    // });
    map.addOverlay(marker);               // 将标注添加到地图中
    addClickHandler(content,marker,opts);
  }
  function addClickHandler(content,marker,opts)
  {
    marker.addEventListener("click",function(e){
      openInfo(content,e,opts)}
    );
  }
  function openInfo(content,e,opts){
    var p = e.target;
    var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
    var searchInfoWindow = new BMapLib.SearchInfoWindow(map,content,opts);  // 创建信息窗口对象 BMapLib.SearchInfoWindow 
    searchInfoWindow.open(point); //开启信息窗口
  }


$(function(){
  $(".maplist ul li").each(function(){
    var index = $(this).index()+1;
    if(index%3 == 0){
      $(this).css("border","none");
    }
  });
});
</script>
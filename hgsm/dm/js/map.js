//百度地图
// 去掉左右空格
//function String.prototype.trim() { 
//	return this.replace(/(^/s*)|(/s*$)/g, ""); 
//}
(function(window, undefined){
	var isStr = function(o){
		return (typeof o ==='string' ? o : false);
	}  
	//地图构造器
	function MarkerManager() {
		window._map 	= null;	
		_this 			= this;
		this.followText = '点击标注';
		this.marker     = null;
		this._markers   = [];
		this.mkrTool    = null;
		this.icon_index = 8;
	}
	MarkerManager.prototype = {
		    //添加控件
		    addControl : function () {
		    	_map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
		    },	
		    //设置中心
		    setCenter : function(lng, lat) {
		    	return new BMap.Point(lng, lat);
		    },
		    //添加标注
		    addMarker : function(icon_index){
		    	 this.mkrTool.open(); //打开工具
		    	 
		    	//设置工具样式，使用系统提供的样式BMapLib.MarkerTool.SYS_ICONS[0]--BMapLib.MarkerTool.SYS_ICONS[23]
		    	 var icon = BMapLib.MarkerTool.SYS_ICONS[this.icon_index]; 
		    	 this.mkrTool.setIcon(icon);
		    },
		    //初始化标注，将已经存在的标注添加的地图中
		    initMarker : function(){
		    	if (allMarker) {
	    		  var point = new BMap.Point(allMarker.x, allMarker.y);
	    		  var marker = new BMap.Marker(point);
	    		  this.addOneMarker(point);
		    	}
		    },
		    //用坐标添加一个标注
		    addOneMarker : function(point, icon_index){
		    	var icon   = BMapLib.MarkerTool.SYS_ICONS[this.icon_index]; 
		    	// alert(icon);
		    	var marker = new BMap.Marker(point, {icon:icon})
		    	_map.addOverlay(marker);
		    	var opts = {
						  margin : [10, 10, 20, 10],     // 信息窗口宽度
						  height: 0,     // 信息窗口高度
						  offset: new BMap.Size(6, -24),
						  title : '<span style="font-size:14px;font-weight:bold;color:#cc5522;">'+allMarker.mark_title+'</span>', // 信息窗口标题
						  enableMessage:false,//设置允许信息窗发送短息
						}
				var infoWindow = new BMap.InfoWindow(allMarker.mark_remark, opts);
		    	marker.enableDragging();
		    	marker.addEventListener("click", function(){          
						_map.openInfoWindow(infoWindow,point); //开启信息窗口
					});
		    	this._markers.push(marker);
		    	this.addEvent(marker, 'dragging', this.markDragging);
		    },
		    //信息的窗口
		    createInfoWnd : function(index, title, remark){
		    	 var a = this.createInfoWindow(title, remark);
		    	 this._markers[index].openInfoWindow(a);
		    },
		    createInfoWindow : function(title, remark){
		    	title = '<span class="w-title">'+title+'</span>';
		    	var a = new BMap.InfoWindow(remark, {title: title, height: 0, offset: new BMap.Size(6, -24), margin: [10, 10, 20, 10], enableMessage:false});
		    	return a;
		    },
		    //删除标注
		    removeMarker : function(index){
		    	_map.removeOverlay(this._markers[index]);
		    	this._markers.splice(index, 1);
		    },
		    //自动完成
		    Autocomplete : function(){
		    	//建立一个自动完成的对象
		    	var ac = new BMap.Autocomplete({"input" : "searchMap", "location" : _map});
		    	this.addEvent(ac, 'onconfirm', this.onconfirm);
		    },
		    //根据关键字本地搜索
		    localSearch : function(keyword) {
		    	this._search(keyword);
		    },
		    //添加标注完成后把标注信息添加到HTML中
		    addHtml : function(){
				var info = {
						'lng': this.marker.getPosition().lng, // 经度
						'lat': this.marker.getPosition().lat  // 纬度
					}
				var html = '<li><div class="mark-nav"><span class="mark-title">我的标注点</span><div class="mark-manager"><span class="mark-delete">删除</span></div></div><div class="mark-info">' +
						   '<div class="mark-item">坐标：<span><input type="text" class="input input-large mark-coord" name="mark[mark-coord]" value="'+ info.lng + '|' + info.lat + '" readonly="true"></span></div>' +
				   		   '<div class="mark-item mark-item-list"><span>名称：<input type="text" class="input input-large mark-title" name="mark[mark_title]" value="我的名称"></span><span>备注：<textarea row="2" cols="20" class="input input-large mark-remark" name="mark[mark_remark]" >我的备注</textarea></span></div></div></li>';
				$('.mark-list').append(html);
				this.addEvent(this.marker, 'dragging', this.markDragging);
		    },
		    //添加事件
		    addEvent : function(obj, type, fn){
		    	if(!type) return;
		    	obj.addEventListener(type, fn);
		    },
		    //重定向地图中心
		    locateMarkerCenter : function(index, zoom){
		    	zoom  = zoom ? zoom : _map.getZoom();
				var x = this._markers[index].getPosition().lng;
				var y = this._markers[index].getPosition().lat;
		    	_map.centerAndZoom(this.setCenter(x, y), zoom);
		    },
		    //初始化地图
		    initMap : function(center, opts){
		    	_map = new BMap.Map(opts.container);
		    	_map.centerAndZoom(center, parseInt(opts.zoom));  //opts.zoom 必须是整数负责无法用滚轮缩放
		    	_map.enableScrollWheelZoom();
		    	this.addControl();
		    },
		    initCenter : function(){
		    	var centerPinter = _map.getCenter();
		    	$('#mapCenterPointX').val(centerPinter.lng);
		    	$('#mapCenterPointY').val(centerPinter.lat);
		    },
		    initZoom : function(){
		    	$('#mapCenterLevel').val(_map.getZoom());
		    },
		    initTool : function(){
		    	this.mkrTool = new BMapLib.MarkerTool(_map, {autoClose: true, followText: this.followText});
		    	this.addEvent(this.mkrTool, 'markend', this.markend);
		    },
		    showMap : function(opts){  	  	
		    	var opts_default = {container: 'map', zoom : 15, x : 116.404, y : 39.915};
		    	opts = opts ? opts : opts_default;
		    	var center = this.setCenter(opts.x, opts.y);
		    	this.initMap(center, opts);
		    	
		    	this.Autocomplete();
		    	
		    	this.addEvent(_map, 'zoomend', this.zoomend);  //监听缩放级别
		    	this.addEvent(_map, 'dragend', this.dragend);  //监听缩放级别
		    	
		    	//初始化相应的信息
		    	this.initCenter();
		    	this.initZoom();
		    	this.initTool();
		    	this.initMarker();
		    },
		    
		    //一下为事件函数-------------------------------------------------------------
		    
		    //搜索
		    _search : function(keyword){
//		    	renderOptions:{map:_map}  //标注多个结果
		    	var local = new BMap.LocalSearch(_map, {onSearchComplete: function(){
		    		 var pp = local.getResults().getPoi(0).point;
		    		 _map.centerAndZoom(pp, 18);
		    		 _this.initCenter();
		    		 //_map.addOverlay(new BMap.Marker(pp));    //添加标注
		    	}});
		    	 local.search(keyword);
		    },
		    //标注结束事件
		    markend : function(e){
		    	_this.marker = e.marker;
		    	_this.marker.enableDragging();
		    	_this._markers.push(e.marker);
		    	_this.addHtml();
		    	//绑定标注拖动事件
//		    	_this.addEvent(e.marker, 'click', this.markDragging);
		    },
		    zoomend : function(){
		    	_this.initZoom();
		    },
		    dragend : function(){
		    	_this.initCenter();
		    },
		    markDragging : function(e){
		    	var index = _this._markers.indexOf(this);
				var coord = this.getPosition().lng + '|' + this.getPosition().lat;
		    	$('.mark-list > li').eq(index).find('input.mark-coord').val(coord);
		    },
		    //鼠标点击下拉列表后的事件
		    onconfirm : function(e){
		    	var _value  = e.item.value;
		    	var myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		    	_this._search(myValue);
		    },
	}
	window.M = new MarkerManager();
})(window);

var getWindowSize = function(){
	return ["Height","Width"].map(function(name){
	  return window["inner"+name] ||
		document.compatMode === "CSS1Compat" && document.documentElement[ "client" + name ] || document.body[ "client" + name ]
	});
}
	$(function(){
		var str  = getWindowSize();
		var strs = new Array(); 				//定义一数组
		strs     = str.toString().split(",");   //字符分割
		$('.right').height(strs[0] - 80);
		M.showMap(center);
		$('.map-btn').on('click', function(){
			var keyword = $('#searchMap').val();
			if (keyword) {
				M.localSearch(keyword);
			}
		});
		$('#searchMap').on('keydown', function(e){
			if (e.keyCode == 13) {
				$('.map-btn').click();
			}
		});
		
		$('.icon-select').on('click', 'a', function(){
			$('.icon-select').hide();
			var icon_index = $(this).data('icon');
			M.addMarker(icon_index);
		});
	});	   
	//标注选择
	$('.select-style').on('click', function(){
		if ($('.mark-list > li').length > 0) {
			alert("您已经标注，请勿重复操作。");	
			return false;
		}
		M.addMarker(8);		
	});
	//标注删除
	$('.mark-list').on('click', '.mark-delete', function(){
		M.removeMarker($(this).parents('li').index());
		$(this).parents('li').remove();
	});
	//聚焦标注
	$('.mark-list').on('focus', 'li', function(){
		var index = $(this).index();
		M.locateMarkerCenter(index);
	});
	
	$('.mark-list').on('focus', '.input[type="text"]', function(){
		var title  = $(this).parents('.mark-info').find('.mark-title').val();
		var remark = $(this).parents('.mark-info').find('.mark-remark').val();
		var index  = $(this).parents('li').index();
		M.createInfoWnd(index, title, remark);
	});
;(function (window, undefined){
	/**
		Tool: 工具构造函数
	*/
	function Tool(){}

	/*
		合并对象
	*/
	Tool.prototype.extend = function (){
		var args = arguments,
			argsLen = args.length,
			target = args[0],
			// 是否深度合并
			deep = args[1],
			callee = args.callee;
		if(argsLen < 2){
			return;
		}
		if(({}).toString.call(deep) === "[object Boolean]" && deep){
			for(var i = 1; i < argsLen; i++){
				var obj = args[i];
				for(var attr in obj){
					var tempObj = obj[attr];
					if(obj.hasOwnProperty(attr)){
						if(({}).toString.call(tempObj) === "[object Object]" || (typeof tempObj != "string" && tempObj.length && tempObj[tempObj.length - 1])){
							callee(target[attr], deep, tempObj);
						}else{
							target[attr] = tempObj;
						}
					}
				}
			}
			return target;
		}else{
			// 如果不需要深度合并则直接遍历需要合并的对象
			for(var i = 1; i < argsLen; i++){
				var obj = args[i];
				for(var attr in obj){
					if(obj.hasOwnProperty(attr)){
						target[attr] = obj[attr];
					}
				}
			}			
			return target;
		}
	}
	/**
		获取指定元素距浏览器最顶端、最左端的距离
	*/
	Tool.prototype.position = function(ele){
		if(!ele || !ele.nodeName){
			return {};
		}
		var offsetTop = ele.offsetTop,
			offsetLeft = ele.offsetLeft,
			offsetParent = ele.offsetParent,
			obj = {};
		while(offsetParent != null){
			offsetTop += offsetParent.offsetTop;
			offsetLeft += offsetParent.offsetLeft;
			offsetParent = offsetParent.offsetParent;
		}
		return {
			top: offsetTop,
			left: offsetLeft
		};
	}
	/**
		获取元素宽度
	*/
	Tool.prototype.getWidth = function(ele){
		if(!ele || !ele.nodeName){
			return 0;
		}
		return ele.offsetWidth;
	}
	/**
		获取元素高度
	*/
	Tool.prototype.getHeight = function(ele){
		if(!ele || !ele.nodeName){
			return 0;
		}
		return ele.offsetHeight;
	}
	/**
		获取或设置样式
	*/
	Tool.prototype.css = function (ele,attr,val){
		if(!ele || !ele.nodeName){
			return;
		}
		attr = attr.replace(/\-(\w{1})/, function (m, $1){
			return $1.toUpperCase();
		});
		// 获取css属性值
		if(typeof val === "undefined"){
			var cssVal;
			if(window.getComputedStyle){
				cssVal = window.getComputedStyle(ele, null)[attr];
			}else if(ele.currentStyle){
				cssVal = ele.currentStyle[attr];
			}
			if(cssVal && !/\%/g.test(cssVal)){
				var tempVal = Number(cssVal);
				if(!isNaN(tempVal)){
					cssVal = tempVal;
				}
			}
			return cssVal;
		}
		// 设置css属性
		var ignoreAttrs = {
			"zIndex": 1,
			"opacity": 1
		}
		if(typeof val === "number" && !(attr in ignoreAttrs)){
			val = val + "px";
		}
		ele.style[attr] = val;
		return ele;
	}

	/**
		生成随机数
	*/
	Tool.prototype.random = function (min, max){
		switch(arguments.length){ 
	        case 1: 
	            return parseInt(Math.random() * min + 1, 10); 
	        break; 
	        case 2: 
	            return parseInt(Math.random() * (max - min + 1) + min, 10); 
	        break; 
	        default: 
	            return 0; 
	        break; 
	    } 
	}
	window.tool = new Tool();
})(window, undefined);
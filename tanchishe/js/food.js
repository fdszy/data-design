;(function (window, undefined){
	/**
		Food: 食物构造函数
	*/
	function Food(parent, options){
		if(!parent || !parent.nodeName){
			throw "element is required";
		};
		this.options = {
			width: 20,
			height: 20,
			x: 0,
			y: 0,
			className: "",
			name: "",
			text: "",
			backgroundColor: ""
		};
		
		this.colors = ["#FF8C00", "#FF83FA", "#9A32CD", "#999999", "#9932CC", "#98FB98", "#FF3030", "#FF1493", "#FF00FF", "#FF0000", "#98F5FF", "#96CDCD", "#949494", "#9400D3", "#9370DB", "#FF4500", "#FF4040", "#FF3E96", "#FF34B3", "#FF82AB", "#FF8247", "#FF7F50", "#FF7F24", "#FF7F00", "#FF7256"];
		tool.extend(this.options, true, options || {});
		this.options.className += " food";
		this.parent = parent;
		this.name = "";

		this._init();
	}
	/**
		初始化食物对象
	*/
	Food.prototype._init = function (){
		var _ele = document.createElement("div");
		if(!this.options.backgroundColor){
			this.options.backgroundColor = this.colors[Math.floor(Math.random() * this.colors.length)];
		}
		if(!this.options.name){
			this.name = this.options.name = "food_" + Math.random().toString(36).substring(2, 8);
		}else{
			this.name = this.options.name;
		}
		this.x = this.options.x;
		this.y = this.options.y;
		tool.css(_ele, "width", this.options.width);
		tool.css(_ele, "height", this.options.height);
		tool.css(_ele, "position", "absolute");
		tool.css(_ele, "left", this.x);
		tool.css(_ele, "top", this.y);
		tool.css(_ele, "backgroundColor", this.options.backgroundColor);
		_ele.innerHTML = this.options.text;

		_ele.className = this.options.className;
		this.ele = _ele;
		this.parent.appendChild(this.ele);
	}
	/**
		设置食物的宽度
	*/
	Food.prototype.setWidth = function (w){
		if(typeof w === "undefined"){
			return;
		}
		tool.css(this.ele, "width", w);
		this.options.width = w;
		return this;
	}
	/**
		设置食物的高度
	*/
	Food.prototype.setHeight = function (h){
		if(typeof h === "undefined"){
			return;
		}
		tool.css(this.ele, "height", h);
		this.options.height = h;
		return this;
	}
	/**
		设置食物的位置
	*/
	Food.prototype.setPosition = function (x, y){
		if(typeof x !== "undefined"){
			x = Number(x);
			this.x = x;
			tool.css(this.ele, "left", x);
		}
		if(typeof y !== "undefined"){
			y = Number(y);
			this.y = y;
			tool.css(this.ele, "top", y);
		}
		return this;
	}

	window.Food = Food;
})(window, undefined);
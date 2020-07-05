;(function (window, undefined){
	/**
		贪吃蛇游戏构造函数
	*/
	function SnakeGame(ele, options){
		if(!ele || !ele.nodeName){
			throw "element is required";
		};

		this._init(ele, options || {});
	}
		// 存储计时器
	var timer;
	/**
		贪吃蛇游戏初始化函数
	*/
	SnakeGame.prototype._init = function (ele, options){
		var that = this;
		this.ele = ele;
		this.options = {
			// 游戏初始化后的回调函数
			init: function (){},
			// 贪吃蛇吃到食物后的回调函数
			eated: function (){},
			// 游戏结束时的回调函数
			onDie: function (){},
			// 游戏开始时的回调函数
			onStart: function (){},
			// 游戏暂停后的回调函数
			onPaused: function (){},
			// 游戏继续时的回调回调
			onContinue: function (){},
			// 蛇移动的速度的级别
			speed: "slow",
			// 游戏速度时间
			speedTime: {
				"slow": 600,
				"medium": 350,
				"fast": 200
			},
			// 贪吃蛇宽度
			width: 20,
			height: 20,
			// 贪吃蛇蛇头颜色
			snakeHeadColor: "",
			// 蛇默认移动的方向
			direction: "right"
		};

		tool.extend(this.options, true, options);

		// 蛇是否死亡
		this._isDie = false;
		// 判断键盘事件是否绑定
		this._eventBinded = false;

		this.eleWidth = tool.getWidth(this.ele);
		this.eleHeight = tool.getHeight(this.ele);
		// 当前蛇移动的方向
		this.direction = this.options.direction;
		this.gameRuning = false;
		// 游戏速度时间
		this.speedTime = this.options.speedTime;

		if(tool.css(this.ele, "position") === "static"){
			tool.css(this.ele, "position", "relative");
		}

		// 创建蛇
		this.snake = new Snake(this.ele, {
			width: this.options.width,
			height: this.options.height,
			// 贪吃蛇蛇头颜色
			snakeHeadColor: this.options.snakeHeadColor,
			// 蛇默认移动的方向
			direction: this.options.direction,
			eated: function (){
				var position = that.randomPosition();
				this.addFood(new Food(that.ele, {
					x: position.left,
					y: position.top
				}));
				
				that.options.eated && (typeof that.options.eated == "function") && that.options.eated.call(that);
			},
			onDie: function (){
				clearInterval(timer);
				that.options.onDie && (typeof that.options.onDie == "function") && that.options.onDie.call(that);
			}
		});

		// 添加食物
		var position = this.randomPosition();
		this.snake.addFood(new Food(this.ele, {
			x: position.left,
			y: position.top
		}));
		

		this.options.init && (typeof this.options.init == "function") && this.options.init.call(this);
	}

	/**
		开始游戏
	*/
	SnakeGame.prototype.start = function (){
		var that = this;
		if(this.gameRuning){
			return this;
		}
		clearInterval(timer);
		timer = setInterval(function (){
			that.snake.move(that.direction);
		}, this.speedTime[this.options.speed]);

		this.gameRuning = true;
		this._bindEvent();
		this.options.onStart && (typeof this.options.onStart == "function") && this.options.onStart.call(this);
		return this;
	}

	/**
		暂停游戏
	*/
	SnakeGame.prototype.pause = function (){
		var that = this;
		clearInterval(timer);

		this.gameRuning = false;
		this.options.onPaused && (typeof this.options.onPaused == "function") && this.options.onPaused.call(this);
		return this;
	}

	/**
		继续游戏
	*/
	SnakeGame.prototype.continueGame = function (){
		var that = this;
		if(this.gameRuning){
			return this;
		}
		clearInterval(timer);
		timer = setInterval(function (){
			that.snake.move(that.direction);
		}, this.speedTime[this.options.speed]);

		this.gameRuning = true;
		this.options.onContinue && (typeof this.options.onContinue == "function") && this.options.onContinue.call(this);
		return this;
	}

	/**
		获取蛇吃到的食物的个数
	*/
	SnakeGame.prototype.getCount = function (){
		return this.snake.count;
	}

	/**
		改变速度
	*/
	SnakeGame.prototype.changeSpeed = function (speed){
		if(!(speed in this.speedTime)){
			return this;
		}
		var that = this;
		
		this.options.speed = speed;
		if(this.gameRuning){
			clearInterval(timer);
			timer = setInterval(function (){
				that.snake.move(that.direction);
			}, this.speedTime[this.options.speed]);
		}		

		return this;
	}

	/**
		绑定键盘事件，可以使用方向键来控制
	*/
	SnakeGame.prototype._bindEvent = function (){
		var that = this;
		if(that._eventBinded){
			return this;
		}
		if(document.addEventListener){
			document.addEventListener("keydown", function (e){
				e = e || window.event;
				if(!that.gameRuning){
					return;
				}
				switch(e.keyCode){
					case 38:
						// 上
						// 如果当前方向为向下，用户直接按上方向键则不向上移动
						if(that.direction == "bottom"){
							return;
						}
						that.direction = "top";
						break;
					case 40:
						// 下
						if(that.direction == "top"){
							return;
						}
						that.direction = "bottom";
						break;
					case 37:
						// 左
						if(that.direction == "right"){
							return;
						}
						that.direction = "left";
						break;
					case 39:
						// 右
						if(that.direction == "left"){
							return;
						}
						that.direction = "right";
						break;
				}

				if(e.keyCode >= 38 && e.keyCode <= 40){
					if(e.preventDefault){
						e.preventDefault();	
					}else{
						e.returnValue = false;
					}
					return false;
				}					
			}, false);
		}else{
			document.attachEvent("onkeydown", function (e){
				e = e || window.event;
				switch(e.keyCode){
					case 38:
						// 上
						// 如果当前方向为向下，用户直接按上方向键则不向上移动
						if(that.direction == "bottom"){
							return;
						}
						that.direction = "top";
						break;
					case 40:
						// 下
						if(that.direction == "top"){
							return;
						}
						that.direction = "bottom";
						break;
					case 37:
						// 左
						if(that.direction == "right"){
							return;
						}
						that.direction = "left";
						break;
					case 39:
						// 右
						if(that.direction == "left"){
							return;
						}
						that.direction = "right";
						break;
				}

				if(e.keyCode >= 38 && e.keyCode <= 40){
					if(e.preventDefault){
						e.preventDefault();	
					}else{
						e.returnValue = false;
					}
					return false;
				}					
			}, false);
			that._eventBinded = true;
		}
		return this;
	}

	/**
		生成随机位置
	*/
	SnakeGame.prototype.randomPosition = function(){
		var obj = {},
			/* 根据蛇每一节的宽度计算出整个盒子可以放多少节，以避免蛇在移动时蛇头与食物位置不能重合的情况
				这样一来蛇始终都可以吃到食物
			*/
			xgrid = Math.floor((this.eleWidth - this.options.width * 2) / this.options.width),
			ygrid = Math.floor((this.eleHeight - this.options.height * 2) / this.options.height),
			randomx = tool.random(1, xgrid),
			randomy = tool.random(1, ygrid);

		obj.left = randomx * this.options.width;
		obj.top = randomy * this.options.height;
		return obj;
	}

	window.SnakeGame = SnakeGame;
})(window, undefined);
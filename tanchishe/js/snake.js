;(function (window, undefined){
	/**
		贪吃蛇构造函数
	*/
	function Snake(ele, options){
		if(!ele || !ele.nodeName){
			throw "element is required";
		};

		this._init(ele, options || {});
	}

	/**
		贪吃蛇初始化函数
	*/
	Snake.prototype._init = function (ele, options){
		this.ele = ele;
		this.options = {
			// 贪吃蛇初始化后的回调函数
			init: function (){},
			// 贪吃蛇吃到食物后的回调函数
			eated: function (){},
			// 蛇死亡时的回调函数
			onDie: function (){},
			// 贪吃蛇宽度
			width: 20,
			height: 20,
			// 贪吃蛇蛇头颜色
			snakeHeadColor: "",
			// 蛇默认移动的方向
			direction: "right"
		}

		tool.extend(this.options, true, options);

		// 吃到的食物的数量
		this.count = 0;
		// 贪吃蛇蛇头+蛇身
		this.snake = [];
		// 蛇将要吃的食物
		this._food;
		// 当前蛇移动的方向
		this._direction = this.options.direction;
		// 蛇是否死亡
		this._isDie = false;

		this.eleWidth = tool.getWidth(this.ele);
		this.eleHeight = tool.getHeight(this.ele);

		if(tool.css(this.ele, "position") === "static"){
			tool.css(this.ele, "position", "relative");
		}
		var snakeHead = new Food(this.ele ,{
			width: this.options.width,
			height: this.options.height,
			text:"S",
			name: "snakeHead",
			x: 0,
			y: 0,
			backgroundColor: this.options.snakeHeadColor || "#f60"
		});

		tool.css(snakeHead.ele, "fontSize", 12);
		tool.css(snakeHead.ele, "color", "#fff");
		tool.css(snakeHead.ele, "textAlign", "center");
		tool.css(snakeHead.ele, "zIndex", "100");
		tool.css(snakeHead.ele, "lineHeight", this.options.height);
		
		// 添加蛇头
		this.snake.push(snakeHead);

		this.options.init && (typeof this.options.init == "function") && this.options.init.call(this);
	}

	/**
		蛇移动
	*/
	Snake.prototype.move = function(direction){
		if(typeof direction === "undefined"){
			direction = "left";
		}
		var snakes = this.snake,
			i = 0,
			that = this,
			width = this.options.width,
			height = this.options.height,
			// 存储位置
			positions = [],
			len = snakes.length;
		switch(direction){
			case "left":
			case 0:
				// 如果在往左移动前是向右移动,则需把蛇头和蛇尾位置调换下
				if(that._direction == "right"){
					for(var j = len - 1; j >= 0; j --){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					for(; i < len; i++){
						var snake = snakes[i];
						snake.setPosition(positions[i].x - width, positions[i].y);
					}
				}else{
					for(var j = 0; j < len; j ++){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					snakes[0].setPosition(snakes[0].x - width, snakes[0].y);
					for(i = 1; i < len; i++){
						var snake = snakes[i];
						snake.setPosition(positions[i - 1].x, positions[i - 1].y);	
					}
				}
				this._direction = "left";
				break;
			case "right":
			case 1:
				// 如果在往右移动前是向左移动,则需把蛇头和蛇尾位置调换下
				if(that._direction == "left"){
					for(var j = len - 1; j >= 0; j --){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					for(; i < len; i++){
						var snake = snakes[i];
						snake.setPosition(positions[i].x + width, positions[i].y);
					}
				}else{
					for(var j = 0; j < len; j ++){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					snakes[0].setPosition(snakes[0].x + width, snakes[0].y);
					for(i = 1; i < len; i++){
						var snake = snakes[i];
						snake.setPosition(positions[i - 1].x, positions[i - 1].y);	
					}
				}
				this._direction = "right";
				break;
			case "top":
			case 2:
				if(that._direction == "bottom"){
					for(var j = len - 1; j >= 0; j --){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					
					for(; i < len; i++){
						var snake = snakes[i];
						snake.setPosition(positions[i].x, positions[i].y - height);	
					}
				}else{
					for(var j = 0; j < len; j ++){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}

					snakes[0].setPosition(snakes[0].x, snakes[0].y - height);
					for(i = 1; i < len; i++){
						var snake = snakes[i];

						snake.setPosition(positions[i - 1].x, positions[i - 1].y);
					}
				}
				this._direction = "top";
				break;
			case "bottom":
			case 3:
				if(that._direction == "top"){
					for(var j = len - 1; j >= 0; j --){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					for(; i < len; i++){
						var snake = snakes[i];
						snake.setPosition(positions[i].x, positions[i].y - height);	
					}
				}else{
					for(var j = 0; j < len; j ++){
						positions.push({
							x: snakes[j].x,
							y: snakes[j].y
						});
					}
					
					snakes[0].setPosition(snakes[0].x, snakes[0].y + height);
					for(i = 1; i < len; i++){
						var snake = snakes[i];

						snake.setPosition(positions[i - 1].x, positions[i - 1].y);
					}
				}
				this._direction = "bottom";
				break;
		}
		positions = null;
		this.eat();
		this.isDie();
		return this;
	}

	/**
		添加食物
	*/
	Snake.prototype.addFood = function (food){
		if(!food || food.constructor !== Food){
			return;
		}
		this._food = food;
		return this;
	}

	/**
		蛇吃食物
	*/
	Snake.prototype.eat = function (){
		var that = this,
			snakeHead = this.snake[0];

		if(snakeHead.x == this._food.x && snakeHead.y == this._food.y){
			// 将吃到的食物添加到蛇身中去
			this.snake.push(this._food);
			// 获取刚添加进去的那一节身体
			var snakeLen = this.snake.length,
				lastBody = this.snake[snakeLen - 1],
				width = this.options.width,
				height = this.options.height;
				
			switch(this._direction){
				case "left":
					lastBody.setPosition(this.snake[snakeLen - 2].x + width, this.snake[snakeLen - 2].y);
					break;
				case "right":
					lastBody.setPosition(this.snake[snakeLen - 2].x - width, this.snake[snakeLen - 2].y);
					break;
				case "top":
					lastBody.setPosition(this.snake[snakeLen - 2].x, this.snake[snakeLen - 2].y + height);
					break;
				case "bottom":
					lastBody.setPosition(this.snake[snakeLen - 2].x, this.snake[snakeLen - 2].y - height);
					break;
			}

			this._food = {};
			this.count++;
			this.options.eated && (({}).toString.call(this.options.eated) == "[object Function]") && this.options.eated.call(this);
		}
		return this;
	}

	/**
		判断蛇是否死亡
	*/
	Snake.prototype.isDie = function (){
		var that = this,
			snakeHead = this.snake[0];
		if(snakeHead.x < 0 || snakeHead.x > this.eleWidth || snakeHead.y < 0 || snakeHead.y > this.eleHeight){
			this._isDie = true;
			this.options.onDie && (({}).toString.call(this.options.onDie) == "[object Function]") && this.options.onDie.call(this);
		}
		return this;

	}

	window.Snake = Snake;
})(window, undefined);
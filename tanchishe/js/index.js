;(function (window, undefined){
	var snakeBox = document.getElementById("snake_box"),
		gradeEle = document.getElementById("grade"),
		speedSelect = document.getElementById("speed_select"),
		startBtn = document.getElementById("start_btn"),
		pauseBtn = document.getElementById("pause_btn"),
		continueBtn = document.getElementById("continue_btn");

	var snakeGame = new SnakeGame(snakeBox, {
		speed: speedSelect.value,
		eated: function(){
			gradeEle.innerHTML = this.getCount();
		},
		onDie: function (){
			alert("Game Over!");
		}
	});

	startBtn.onclick = function (){
		if(!this.started){
			snakeGame.start();
			this.started = true;
		}
	}
	pauseBtn.onclick = function (){
		snakeGame.pause();
	}
	continueBtn.onclick = function (){
		snakeGame.continueGame();
	}
	speedSelect.onchange = function (){
		console.log(this.value);
		snakeGame.changeSpeed(this.value);
	}
})(window, undefined);
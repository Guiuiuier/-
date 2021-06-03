

! function($) {

	"use strict";

	var Typed = function(el, options) {

		// 	选择用于操作文本的元素
		this.el = $(el);

		// options
		this.options = $.extend({}, $.fn.typed.defaults, options);

		// attribute to type into
		this.isInput = this.el.is('input');
		this.attr = this.options.attr;

		// 显示光标 cursor
		this.showCursor = this.isInput ? false : this.options.showCursor;

		// 元素的文本内容
		this.elContent = this.attr ? this.el.attr(this.attr) : this.el.text();

		// html或纯文本
		this.contentType = this.options.contentType;

		// 打字速度
		this.typeSpeed = this.options.typeSpeed;

		// 在开始输入之前添加一个延迟
		this.startDelay = this.options.startDelay;

		// 回退的速度
		this.backSpeed = this.options.backSpeed;

		// 回退前需要等待的时间
		this.backDelay = this.options.backDelay;

		// div包含字符串
		this.stringsElement = this.options.stringsElement;

		// 文本输入字符串
		this.strings = this.options.strings;

		// 当前字符串的字符号位置
		this.strPos = 0;

		// current array position
		this.arrayPos = 0;

					//数字来停止后退。
			//默认值为0，可以根据字符的数量进行更改
		this.stopNum = 0;

		// Looping logic
		this.loop = this.options.loop;
		this.loopCount = this.options.loopCount;
		this.curLoop = 0;

		// for stopping
		this.stop = false;

		// custom cursor
		this.cursorChar = this.options.cursorChar;

		// shuffle the strings
		this.shuffle = this.options.shuffle;
		// 字符串的顺序
		this.sequence = [];

		// 万事俱备；一切正常；各系统准备工作就绪
		this.build();
	};

	Typed.prototype = {

		constructor: Typed,

		init: function() {
			//开始循环w/第一个当前字符串(全局self.string)
//在此之后，每次都会将当前字符串作为参数传递
			var self = this;
			self.timeout = setTimeout(function() {
				for (var i=0;i<self.strings.length;++i) self.sequence[i]=i;

				// 如果为真，则洗牌数组
				if(self.shuffle) self.sequence = self.shuffleArray(self.sequence);

				// Start typing
				self.typewrite(self.strings[self.sequence[self.arrayPos]], self.strPos);
			}, self.startDelay);
		},

		build: function() {
			var self = this;
			// 插入光标
			if (this.showCursor === true) {
				this.cursor = $("<span class=\"typed-cursor\">" + this.cursorChar + "</span>");
				this.el.after(this.cursor);
			}
			if (this.stringsElement) {
				this.strings = [];
				this.stringsElement.hide();
				console.log(this.stringsElement.children());
				var strings = this.stringsElement.children();
				$.each(strings, function(key, value){
					self.strings.push($(value).html());
				});
			}
			this.init();
		},

		// 将当前字符串状态传递给每个函数，每次调用键入1个字符
		typewrite: function(curString, curStrPos) {
			// exit when stopped
			if (this.stop === true) {
				return;
			}

			
			// 可以设置打字的速度
			var humanize = Math.round(Math.random() * (150 - 30)) + this.typeSpeed;
			var self = this;

			// ------------- optional ------------- //
			//后退某个字符串的速度更快
			// ------------------------------------ //
			// if (self.arrayPos == 1){
			//  self.backDelay = 50;
			// }
			// else{ self.backDelay = 500; }

			// 在超时中包含打字功能，人性化延时
			self.timeout = setTimeout(function() {
								//在暂停值之前检查转义字符
					//格式:\^\d+ ..如:1000年^ . .应该能用^^来打印^
					// single ^从字符串中删除
				var charPause = 0;
				var substr = curString.substr(curStrPos);
				if (substr.charAt(0) === '^') {
					var skip = 1; // skip atleast 1
					if (/^\^\d+/.test(substr)) {
						substr = /\d+/.exec(substr)[0];
						skip += substr.length;
						charPause = parseInt(substr);
					}

					// 去掉转义字符和暂停值，这样就不会打印它们
					curString = curString.substring(0, curStrPos) + curString.substring(curStrPos + skip);
				}

				if (self.contentType === 'html') {
					// 键入时跳过html标记
					var curChar = curString.substr(curStrPos).charAt(0)
					if (curChar === '<' || curChar === '&') {
						var tag = '';
						var endTag = '';
						if (curChar === '<') {
							endTag = '>'
						}
						else {
							endTag = ';'
						}
						while (curString.substr(curStrPos + 1).charAt(0) !== endTag) {
							tag += curString.substr(curStrPos).charAt(0);
							curStrPos++;
							if (curStrPos + 1 > curString.length) { break; }
						}
						curStrPos++;
						tag += endTag;
					}
				}

				// 字符后的任何暂停的超时
				self.timeout = setTimeout(function() {
					if (curStrPos === curString.length) {
						// 触发回调函数
						self.options.onStringTyped(self.arrayPos);

						//这是最后一个字符串
						if (self.arrayPos === self.strings.length - 1) {
							// 在最后键入的字符串上发生的动画
							self.options.callback();

							self.curLoop++;

							// quit if we wont loop back
							if (self.loop === false || self.curLoop === self.loopCount)
								return;
						}

						self.timeout = setTimeout(function() {
							self.backspace(curString, curStrPos);
						}, self.backDelay);

					} else {

						/* 如果适用，在函数之前调用 */
						if (curStrPos === 0) {
							self.options.preStringTyped(self.arrayPos);
						}

						// 开始在现有字符串中输入每个新字符
						// curString: arg, self.el.html: original text inside element
						var nextString = curString.substr(0, curStrPos + 1);
						if (self.attr) {
							self.el.attr(self.attr, nextString);
						} else {
							if (self.isInput) {
								self.el.val(nextString);
							} else if (self.contentType === 'html') {
								self.el.html(nextString);
							} else {
								self.el.text(nextString);
							}
						}

						// 一个接一个地添加字符
						curStrPos++;
						// 循环函数
						self.typewrite(curString, curStrPos);
					}
					// 字符暂停结束
				}, charPause);

				// humanized value for typing
			}, humanize);

		},

		backspace: function(curString, curStrPos) {
			// exit when stopped
			if (this.stop === true) {
				return;
			}

			//键入期间更改setTimeout值
			// 不能是全局的，因为每次执行循环时都会改变数字
			var humanize = Math.round(Math.random() * (100 - 30)) + this.backSpeed;
			var self = this;

			self.timeout = setTimeout(function() {

				

				if (self.contentType === 'html') {
					// 后退行距时跳过html标记
					if (curString.substr(curStrPos).charAt(0) === '>') {
						var tag = '';
						while (curString.substr(curStrPos - 1).charAt(0) !== '<') {
							tag -= curString.substr(curStrPos).charAt(0);
							curStrPos--;
							if (curStrPos < 0) { break; }
						}
						curStrPos--;
						tag += '<';
					}
				}

				//  //
				// 用基本文本+键入字符替换文本
				var nextString = curString.substr(0, curStrPos);
				if (self.attr) {
					self.el.attr(self.attr, nextString);
				} else {
					if (self.isInput) {
						self.el.val(nextString);
					} else if (self.contentType === 'html') {
						self.el.html(nextString);
					} else {
						self.el.text(nextString);
					}
				}

				// if the number (id of character in current string) is
				// less than the stop number, keep going
				if (curStrPos > self.stopNum) {
					// subtract characters one by one
					curStrPos--;
					// loop the function
					self.backspace(curString, curStrPos);
				}
				// if the stop number has been reached, increase
				// array position to next string
				else if (curStrPos <= self.stopNum) {
					self.arrayPos++;

					if (self.arrayPos === self.strings.length) {
						self.arrayPos = 0;

						// Shuffle sequence again
						if(self.shuffle) self.sequence = self.shuffleArray(self.sequence);

						self.init();
					} else
						self.typewrite(self.strings[self.sequence[self.arrayPos]], curStrPos);
				}

				// humanized value for typing
			}, humanize);

		},
	
			// 		*打乱给定数组中的数字。
			// * @param {Array}数组
			// * @returns数组{}
			// * /
		shuffleArray: function(array) {
			var tmp, current, top = array.length;
			if(top) while(--top) {
				current = Math.floor(Math.random() * (top + 1));
				tmp = array[current];
				array[current] = array[top];
				array[top] = tmp;
			}
			return array;
		},

		 // Start & Stop currently not working

		 // , stop: function() {
	  //   var self = this;

		 //    self.stop = true;
		 //     clearInterval(self.timeout);
		 // }

		// , start: function() {
		//     var self = this;
		//     if(self.stop === false)
		//        return;

		//     this.stop = false;
		//     this.init();
		// }

		// Reset and rebuild the element
		reset: function() {
			var self = this;
			clearInterval(self.timeout);
			var id = this.el.attr('id');
			this.el.empty();
			if (typeof this.cursor !== 'undefined') {
        this.cursor.remove();
      }
			this.strPos = 0;
			this.arrayPos = 0;
			this.curLoop = 0;
			// Send the callback
			this.options.resetCallback();
		}

	};

	$.fn.typed = function(option) {
		return this.each(function() {
			var $this = $(this),
				data = $this.data('typed'),
				options = typeof option == 'object' && option;
			if (data) { data.reset(); }
			$this.data('typed', (data = new Typed(this, options)));
			if (typeof option == 'string') data[option]();
		});
	};

	$.fn.typed.defaults = {
		strings: ["这些事默认值", "你可以自己修改", ],
		stringsElement: null,
		// 打字速度
		typeSpeed:0,
		// 开始打字前的时间
		startDelay:0,
		// 回退的速度
		backSpeed: 100,
		// 转换字的字符串
		shuffle: false,
		// 时间回退
		backDelay: 100,
		// loop
		loop: false,
		// false = infinite
		loopCount: false,
		// 显示光标
		showCursor: true,
		// 字符指针
		cursorChar: "|",
		// 属性到类型(null == text)
		attr: null,
		// html或文本
		contentType: 'html',
		//完成后调用回调函数
		callback: function() {},
		// 在每个字符串之前启动回调函数
		preStringTyped: function() {},
		//每个类型字符串的回调
		onStringTyped: function() {},
		// 回调的重置
		resetCallback: function() {}
	};


}(window.jQuery);
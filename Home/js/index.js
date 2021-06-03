//球的个数设置 大小
var BALL_COUNT=[5,10];//最大十个最小五个
var BALL_SIZE=[20,30];
var BALL_COLORS=[
  '#5E9FA3',
  '#FAB87F',
  '#F87E7B',
  '#B05574',
];
var BALL_SPEED=[0.5,1.25];
var BALL_PUSH=1;
var BALL_ACCURACY=0.25; // %
var PLAYER_SPEED=0.5;
var SMOKE_COUNT=[3,5];
var SMOKE_MULTIPLIER=0.2;
var SMOKE_SPEED=[5,10];
var SMOKE_SIZE=[19,34];
var SMOKE_FRICTION=0.92;
var SMOKE_FADE_SPEED=0.035;
var SMOKE_SPREAD=0.45;
var SMOKE_TIMER_LIMIT=10;
var player;
var balls=[];
var smoke=[];
var mouse={
  x:window.innerWidth/2,
  y:window.innerHeight/2
}

// 创建一个球
function createBall() {
  var el,obj,x,y,size,color;
  var accuracy=getRandom(-BALL_ACCURACY*100,BALL_ACCURACY*100)/100;
  
  // 创建元素
  el=$('<div class="ball"></div>');
  
  // 创建对象
  obj={
    el:el,
    x:getRandom(0,window.innerWidth),
    y:getRandom(0,window.innerHeight),
    size:getRandom(BALL_SIZE[0],BALL_SIZE[1]),
    color:BALL_COLORS[Math.floor(
      getRandom(0,BALL_COLORS.length)
    )],
    xvel:0,
    yvel:0,
    speed:getRandom(
      BALL_SPEED[0]*100,
      BALL_SPEED[1]*100
    )/100,
    smokeTimer:0,
    misAim:accuracy
  }
  
  // 风格的元素
  el.css({
    left:obj.x,
    top:obj.y,
    width:obj.size,
    height:obj.size,
    background:obj.color,
  })
  
  // 添加到球的列表中
  balls.push(obj);
  
  // Injection
  $('body').append(el);
}

// 创建球
var count=getRandom(BALL_COUNT[0],BALL_COUNT[1]);
for (var i=0;i<count;i++) {
  createBall();
}

// 球更新
function updateBalls() {
  for (var i=0;i<balls.length;i++) {
    var v=balls[i];
    var angle=Math.atan2((player.y-v.y),(player.x-v.x));
    
    // Following
    v.x+=v.xvel;
    v.y+=v.yvel;
    v.xvel+=Math.cos(angle+v.misAim)*v.speed;
    v.yvel+=Math.sin(angle+v.misAim)*v.speed;
    v.xvel*=0.9;
    v.yvel*=0.9;
    
    // Limits how much smoke can be spawned
    v.smokeTimer++;
  
    // Collision w/ other balls
    for (var ia=0;ia<balls.length;ia++) {
      var va=balls[ia];
      var collisionDistance=va.size/2+v.size/2;
      var distance=getDistance(v.x,v.y,va.x,va.y);
      
      // If it's not the same ball as the upper-loop
      if (ia!==i) {
        
        // If the distance from the original ball is less
        // than both of the radius' combined.
        if (distance<collisionDistance) {
          var angle=Math.atan2((va.y-v.y),(va.x-v.x));
          v.x=va.x+Math.cos(angle+Math.PI)*collisionDistance;
          v.y=va.y+Math.sin(angle+Math.PI)*collisionDistance;
        }
      }
    }
    
    // Collision w/ player
    var collisionDistance=v.size/2+player.size/2;
    var distance=getDistance(v.x,v.y,player.x,player.y);
    if (distance<collisionDistance) {
      var angle=Math.atan2((v.y-player.y),(v.x-player.x));
      
      // Resolve the collision
      player.x=v.x+Math.cos(angle+Math.PI)*collisionDistance;
      player.y=v.y+Math.sin(angle+Math.PI)*collisionDistance;
      v.xvel*=0.5;
      v.yvel*=0.5;
      
      // Collision smoke particle
      if (v.smokeTimer>=SMOKE_TIMER_LIMIT) {
        createSmoke(
          v.x+Math.cos(angle+Math.PI)*v.size/2,
          v.y+Math.sin(angle+Math.PI)*v.size/2,
          angle+Math.PI,
          (v.xvel+v.yvel)
        )
        v.smokeTimer=0;
      }
    }
    
    // Boundaries
    if (v.x-v.size/2<0) {
      v.x=v.size/2+1;
    } else if (v.x+v.size/2 >window.innerWidth) {
      v.x=window.innerWidth-v.size/2-1;
    }
    if (v.y-v.size/2<0) {
      v.y=v.size/2+1;
    } else if (v.y+v.size/2>window.innerHeight) {
      v.y=window.innerHeight-v.size/2-1;
    }
    
    // Style the element
    v.el.css({
      left:v.x,
      top:v.y      
    })
  }
}

// Create the player
function createPlayer() {
  player={
    el:$('.face'),
    x:window.innerWidth/2,
    y:window.innerHeight/2,
    xvel:0,
    yvel:0,
    speed:PLAYER_SPEED,
    scaleX:1,
  }
  player.size=player.el.css('width');
  player.size=player.size.substring(0,2);
}
createPlayer();

// Update the player
function updatePlayer() {
  var eyeDistance=5;
  var angle=Math.atan2((mouse.y-player.y),(mouse.x-player.x));

  // Movement  
  player.x+=player.xvel;
  player.y+=player.yvel;
  player.xvel+=Math.cos(angle)*player.speed;
  player.yvel+=Math.sin(angle)*player.speed;
  player.xvel*=0.99;
  player.yvel*=0.99;
  
  // Boundaries
  if (player.x-player.size/2<0) {
    player.x=player.size/2+1;
    player.xvel*=0.5;
    createSmoke(player.x-player.size/2,player.y,0,player.xvel);
  } else if (player.x+player.size/2>window.innerWidth) {
    player.x=window.innerWidth-player.size/2-1;
    player.xvel*=-0.5;
    createSmoke(player.x+player.size/2,player.y,Math.PI,player.xvel);
  }
  if (player.y-player.size/2<0) {
    player.y=player.size/2+1;
    player.yvel*=-0.5;
    createSmoke(player.x,player.y-player.size/2,Math.PI/2,player.yvel);
  } else if (player.y+player.size/2>window.innerHeight) {
    player.y=window.innerHeight-player.size/2-1;
    player.yvel*=-0.5;
    createSmoke(player.x,player.y+player.size/2,-Math.PI/2,player.yvel);
  }
  
  // Facing the mouse
  if (mouse.x>player.x) {
    player.scaleX=1;
  } else {
    player.scaleX=-1;
  }
  
  // Looking at the mouse
  var eyes=$('.eye');
  var eyeX=Math.cos(angle)*eyeDistance;
  var eyeY=Math.sin(angle)*eyeDistance;
  var multiplier=(mouse.x<player.x) ? -1 : 1;
  eyes.css('transform',
    `translateX(${eyeX*multiplier}px) translateY(${eyeY}px)`
  )
  
  // Styles
  player.el.css({
    left:player.x,
    top:player.y,
    transform:`
      translateX(-50%) translateY(-50%) scaleX(${player.scaleX})
    `
  })
}

// Create a smoke particle
function createSmoke(x,y,angle,speed) {
  
  // Create the individual smoke clouds
  var createCloud=function(x,y,angle,speed) {    
    // The element
    var el=$("<div class='smoke'></div>");
    
    // Variables
    var vel=SMOKE_MULTIPLIER*Math.abs(speed);
    var size=getRandom(SMOKE_SIZE[0]*100,SMOKE_SIZE[1]*100)/100*vel;
    var speed=getRandom(SMOKE_SPEED[0],SMOKE_SPEED[1])*vel
    var dir=angle+getRandom(-SMOKE_SPREAD*1000,SMOKE_SPREAD*1000)/1000;
    
    
    // Styles
    el.css({
      left:x,
      top:y,
      width:size,
      height:size
    })
    
    // Object
    smoke.push({
      el:el,
      x:x,
      y:y,
      vel:speed,
      dir:dir,
      size:size,
      alpha:1
    })
    
    // 注射
    $('body').append(el);
  }
  
  // 产生的烟雾
  var count=getRandom(SMOKE_COUNT[0],SMOKE_COUNT[1]);
  for (var i=0;i<count;i++) {
    createCloud(x,y,angle,speed);
  }
}


// 更新烟雾粒子
function updateSmoke() {
  for (var i=0;i<smoke.length;i++) {
    var v=smoke[i];
    
    // 运动
    v.x+=Math.cos(v.dir)*v.vel;
    v.y+=Math.sin(v.dir)*v.vel;
    v.vel*=SMOKE_FRICTION;
    
    // 衰退
    v.alpha-=SMOKE_FADE_SPEED;    
    
    // 样式
    v.el.css({
      left:v.x,
      top:v.y,
      width:v.size,
      height:v.size,
      opacity:v.alpha
    })
    
    // 消除
    if (v.alpha<=0) {
      v.el.remove();
      smoke.splice(i, 1);
    }
  }
}

// 跟踪鼠标位置
$(window).on('mousemove',function(e) {
  mouse.x=e.pageX;
  mouse.y=e.pageY;
})

// 上更新功能
function update() {
  updateBalls();
  updatePlayer();
  updateSmoke();
  window.requestAnimationFrame(update);
}
update();

// 得到一个随机数
function getRandom(min, max) {
  return Math.random() * (max - min) + min;
}

// 得到两点之间的距离
function getDistance(x1,y1,x2,y2) {
  var a = x1 - x2
  var b = y1 - y2

  return Math.sqrt( a*a + b*b );
}
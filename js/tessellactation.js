(function() {

  var top, width, height, largeHeader, canvas, ctx, points, mouse = true;
  var animateHeader = true;

  // Main
  initHeader();
  initAnimation();
  addListeners();

  function initHeader() {
    largeHeader = document.getElementById('about');
    canvas = document.getElementById('tessellactation');

    height = largeHeader.clientHeight;
    width = window.innerWidth;

    mouse = {x: 48 + canvas.offsetLeft, y: 48 + canvas.offsetTop};

    canvas.width = width;
    canvas.height = height;

    ctx = canvas.getContext('2d');

    var pos = {x: canvas.width / 2, y: 0};
    var logo = new Circle(pos,10.0,'rgba(255,255,255,0.5)');
    logo.draw();

    // create points
    points = [];
    for(var x = 0; x < width; x = x + width/20) {
      for(var y = 0; y < height; y = y + height/20) {
        var px = x + Math.random()*width/20;
        var py = y + Math.random()*height/20;
        var p = {x: px, originX: px, y: py, originY: py };
        points.push(p);
      }
    }

    // for each point find the 3 closest points
    for(var i = 0; i < points.length; i++) {
      var closest = [];
      var p1 = points[i];
      for(var j = 0; j < points.length; j++) {
        var p2 = points[j]
          if(!(p1 == p2)) {
            var placed = false;
            for(var k = 0; k < 3; k++) {
              if(!placed) {
                if(closest[k] == undefined) {
                  closest[k] = p2;
                  placed = true;
                }
              }
            }

            for(var k = 0; k < 3; k++) {
              if(!placed) {
                if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                  closest[k] = p2;
                  placed = true;
                }
              }
            }
          }
      }
      p1.closest = closest;
    }

    // assign a circle to each point
    for(var i in points) {
      var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
      points[i].circle = c;
    }
  }

  // Event handling
  function addListeners() {
    if(!('ontouchstart' in window)) {
      window.addEventListener('mousemove', mouseMove);
    }
    window.addEventListener('scroll', scrollCheck);
    window.addEventListener('resize', resize);
  }

  function mouseMove(e) {
    var posx = posy = 0;
    if (e.pageX || e.pageY) {
      posx = e.pageX;
      posy = e.pageY;
    }
    else if (e.clientX || e.clientY)    {
      posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
      posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
    }
    mouse.x = posx;
    mouse.y = posy;
  }

  function scrollCheck() {
    if(document.body.scrollTop > height) animateHeader = false;
    else animateHeader = true;
  }

  function resize() {
    height = largeHeader.clientHeight;
    width = window.innerWidth;

    canvas.height = height;
    canvas.width = width;
  }

  // animation
  function initAnimation() {
    animate();
    for(var i in points) {
      shiftPoint(points[i]);
    }
  }

  function animate() {
    if(animateHeader) {
      ctx.clearRect(0,0,width,height);

      var pos = {x: width / 2, y: height / 2};
      Circle(pos, 100.0, 'rgba(255,255,255,0.5)');

      var target = {x: mouse.x - canvas.offsetLeft, y: mouse.y - canvas.offsetTop};

      for(var i in points) {
        // detect points in range
        if(Math.abs(getDistance(target, points[i])) < 4000) {
          points[i].active = 0.2;
          points[i].circle.active = 0.4;
        } else if(Math.abs(getDistance(target, points[i])) < 20000) {
          points[i].active = 0.1;
          points[i].circle.active = 0.2;
        } else if(Math.abs(getDistance(target, points[i])) < 40000) {
          points[i].active = 0.025;
          points[i].circle.active = 0.05;
        } else {
          points[i].active = 0;
          points[i].circle.active = 0;
        }

        drawLines(points[i]);
        points[i].circle.draw();
      }
    }
    requestAnimationFrame(animate);
  }

  function shiftPoint(p) {
    TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
          y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
          onComplete: function() {
          shiftPoint(p);
        }});
  }

  // Canvas manipulation
  function drawLines(p) {
    if(!p.active) return;
    for(var i in p.closest) {
      ctx.beginPath();
      ctx.moveTo(p.x, p.y);
      ctx.lineTo(p.closest[i].x, p.closest[i].y);
      ctx.strokeStyle = 'rgba(198,33,89,'+ p.active+')';
      ctx.stroke();
    }
  }

  function Circle(pos,rad,color) {
    var _this = this;

    // constructor
    (function() {
      _this.pos = pos || null;
      _this.radius = rad || null;
      _this.color = color || null;
    })();

    this.draw = function() {
      if(!_this.active) return;
      ctx.beginPath();
      ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
      ctx.fillStyle = 'rgba(255,255,255,'+ _this.active+')';
      ctx.fill();
    };
  }

  // Util
  function getDistance(p1, p2) {
    return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
  }

})();
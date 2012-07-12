/**
 *	@author Jannis Bloemendal
 * */

function arrayShuffle(){
  var tmp, rand;
  for(var i =0; i < this.length; i++){
    rand = Math.floor(Math.random() * this.length);
    tmp = this[i]; 
    this[i] = this[rand]; 
    this[rand] =tmp;
  }
}

Array.prototype.shuffle =arrayShuffle;

var C = function (n) { return document.createElement(n); };
var E = function (id) { return document.getElementById(id); };
var T = function (str) { return document.createTextNode(str); };
var rm = function (o) { while (o != null && o.firstChild != null) o.removeChild(o.firstChild); };
var m = new Metrics();

function getNumber(str) {
	var IdGetter = /^(\d+)/;
	IdGetter.exec(str);
	return parseInt(RegExp.$1);
};

function KdNode(x, y, obj) {
	this.leftChild = null;
	this.rightChild = null;
	this.x = x; 
	this.y = y;
	this.value = obj;
	var that = this;
};

function KdTree() {
	this.root = null;
	this.d = 0;
	this.size = 0;
	this.tmp = new Array();
	var that = this;

	this.add = function(x, y, obj) {
		var n = new KdNode(x, y, obj);
		if (that.root == null) {
			that.root = n;
			return;
		}
		var p = null;
		var tmp = that.root;
		var left = null;
		var d = 0;
		while (tmp != null) {
			p = tmp;
			if (d % 2 == 0) {
				left = (tmp.x > x);
				if (left) tmp = tmp.leftChild; else tmp = tmp.rightChild;
			} else {
				left = (tmp.y > y);
				if (left) tmp = tmp.leftChild; else tmp = tmp.rightChild;
			}
			d++;
		}
		if (left) p.leftChild = n; else p.rightChild = n;
	};

	this.getIntersection = function(x1, y1, x2, y2, cb) {
		that.getInter(that.root, 0, x1, y1, x2, y2, cb);
	};

	this.getInter = function(node, d, x1, y1, x2, y2, cb) {
		if (!node)
			return;
		if (d % 2 == 0) {
			if (x1 <= node.x && node.x < x2) {
				if (y1 <= node.y && node.y < y2) 
					cb(node);
				that.getInter(node.leftChild, d+1, x1, y1, x2, y2, cb);
				that.getInter(node.rightChild, d+1, x1, y1, x2, y2, cb);
			} else if (x2 < node.x) {
				that.getInter(node.leftChild, d+1, x1, y1, x2, y2, cb);
			} else {
				that.getInter(node.rightChild, d+1, x1, y1, x2, y2, cb);
			}
		} else {
			if (y1 <= node.y && node.y < y2) {
				if (x1 <= node.x && node.x < x2) 
					cb(node);
				that.getInter(node.leftChild, d+1, x1, y1, x2, y2, cb);
				that.getInter(node.rightChild, d+1, x1, y1, x2, y2, cb);
			} else if (y2 < node.y) {
				that.getInter(node.leftChild, d+1, x1, y1, x2, y2, cb);
			} else {
				that.getInter(node.rightChild, d+1, x1, y1, x2, y2, cb);
			}
		}
	};
};


function Metrics() {
	this.dbg = true;
	this.id = 0;
	var that = this;

	this.getMousePosition = function(e) {
		var pos_x, pos_y, pointer_x, pointer_y;
		if (!e) e = window.event;
		var scroll = this.getScrollXY();

		if (e.clientY) pointer_y = e.clientY; else pointer_y = e.screenY;
		pos_y = pointer_y + scroll[1];

		if (e.clientX) pointer_x = e.clientX; else pointer_x = e.screenX;
		pos_x = pointer_x + scroll[0];
		
		return [pos_x, pos_y];
	};

	this.getScrollXY = function() {
		var scrOfX = 0, scrOfY = 0;

		if( typeof( window.pageYOffset ) == 'number' ) {
			//Netscape compliant
			scrOfY = window.pageYOffset;
			scrOfX = window.pageXOffset;
		} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
			//DOM compliant
			scrOfY = document.body.scrollTop;
			scrOfX = document.body.scrollLeft;
		} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
			//IE6 standards compliant mode
			scrOfY = document.documentElement.scrollTop;
			scrOfX = document.documentElement.scrollLeft;
		}
		
		return [ scrOfX, scrOfY ];
	};

	this.getPosition = function(obj) {
		var tmp = obj;
		var lPos = 0;
		var oPos = 0;
		if (tmp.offsetParent) {
			while (tmp.offsetParent) {
				lPos += tmp.offsetLeft;
				oPos += tmp.offsetTop;
				tmp = tmp.offsetParent;
			}
		} else if (tmp.x) {
			lPos += tmp.x;
			oPos += tmp.y;
		}
		return [lPos, oPos];
	};
};

function FishEye(id, className, width) {
	this.id = id;
	this.className = className;
	this.radius = 100;
	this.radiusPow = 10000;
	this.fontZoom = 10;
	this.tags = new Array();
	this.dbg = true;
	this.width = width;
	this.prevDecoration;
	this.calcT = 0;
	this.styleT = 0;
	this.eventQueue = new Array();
	this.clearEventQueue = new Array();
	this.rendering = false;
	this.kdTree = new KdTree();
	this.pi2 = Math.PI/2;
	this.pi4 = Math.PI/4;
	this.bb = null;
	var that = this;
	
	this.zoom = function(mPos) {
		var spot = new Spot(mPos[0], mPos[1], that.radius);
		var cb = function(node) {
			if (!node.value)
				return;
			var t = node.value;
			if (t.isOwn)
				return;
			var tc = t.center;
			var d = Math.pow(tc[0]-mPos[0],2) + Math.pow(tc[1]-mPos[1],2);
			if (d > that.radiusPow) {
				t.obj.style.fontSize = t.fontSize+"pt";
				t.obj.style.opacity = 1;
			} else {
				var f1 = d/that.radiusPow;
				var f2 = Math.sin(that.pi2 + that.pi2 * f1);
				var fSize = t.fontSize+Math.round(f2*that.fontZoom);
				t.obj.style.fontSize = fSize+"pt";
				t.obj.style.opacity  = 0.5+f2/2;
			}
		};
		that.kdTree.getIntersection(mPos[0]-that.radius-100, mPos[1]-that.radius-100, mPos[0]+that.radius+100, mPos[1]+that.radius+100, cb);
	};
	
	this.add = function() {
		var tc = E(that.id);
		if (tc == null)
			return;

		var jd = new JDOM();
		var as = jd.getElementsByClass(that.className, tc);
		as.shuffle();

		tc.style.display = "none";

		var spans = new Array();
		var i_l = as.length;
		for (var i=0; i<i_l; i++) {
			if (!as[i].firstChild)
				continue;
			that.prevDecoration = as[i].style.textDecoration;
			var words = this.splitString(as[i].firstChild.nodeValue);
			rm(as[i]);
			var j_l = words.length;
			for (var j=0; j<j_l; j++) {
				var span = C("span");
				span.appendChild(T(words[j]));
				span.id = as[i].id+"_"+j;
				span.style.fontSize = as[i].style.fontSize;
				span.style.display  = as[i].style.display;
				span.style.cursor = "pointer";
				that.prevDecoration  = as[i].style.textDecoration;
				as[i].style.textDecoration = "none";
				as[i].appendChild(span);
				spans.push(span);
			}
		}

		tc.style.display = "block";
		
		// change position to absolute
		var xMin, xMax, yMin, yMax;
		var s_l = spans.length;
		for (var i=0; i<s_l; i++) {
			var p1 = m.getPosition(spans[i]);
			var t = new Tag(spans[i], p1[0], p1[1]);
			if (t.isOwn)
				continue;
			var c = t.coordinates;
			if (i==0) { xMin = c[0]; yMin = c[1]; xMax = c[2]; yMax = c[3]; }
			if (c[0] < xMin) xMin = c[0];
			if (c[1] < yMin) yMin = c[1];
			if (c[2] > xMax) xMax = c[2];
			if (c[3] > yMax) yMax = c[3];
			that.tags.push(t);
			that.kdTree.add(p1[0], p1[1], t);
			spans[i].style.left=p1[0]+"px";
			spans[i].style.top=p1[1]+"px";
		}

		for (var i=0; i<s_l; i++) {	
			spans[i].style.position="absolute";
			spans[i].style.zIndex="3";
		}

		// prevent parent div from collapsing
		that.bb = [xMin, yMin, xMax, yMax];
		tc.style.height = (yMax - yMin)+"px";
		tc.style.width = (xMax - xMin)+"px";

		tc.onmousemove = function(e) { if (that.rendering) return; var p=m.getMousePosition(e); that.eventQueue.push(p); window.setTimeout(that.handleEvent, 40); that.rendering = true; };
		tc.onmouseout = function (e) { var p=m.getMousePosition(e); that.clearEventQueue.push(p); window.setTimeout(that.clear, 100); };
	};

	this.handleEvent = function() {
		var p = that.eventQueue.shift();
		that.zoom(p);
		that.rendering = false;
	};

	this.remove = function() {
		var tc = E(that.id);
		if (tc == null)
			return;
		tc.onmousemove = function() {};
		tc.onmouseout = function() {};
		var jd = new JDOM();
		var as = jd.getElementsByClass(that.className, tc);
		for (var i=0; i<as.length; i++) {
			var spans = as[i].getElementsByTagName("span");
			var text = "";
			for (var j=0; j<spans.length; j++) 
				text += spans[j].firstChild.nodeValue;
			rm(as[i]);
			as[i].appendChild(T(text));
			as[i].style.textDecoration = that.prevDecoration;
		}
		that.tags = new Array();
		tc.style.width = that.width+"px";
	};

	this.clear = function() {
		var mPos = that.clearEventQueue.shift();
		if (that.bb[0] < mPos[0] && mPos[0] < that.bb[2] && that.bb[1] < mPos[1] && mPos[1] < that.bb[3]) 
			return;
		var t_l = that.tags.length;
		for (var i=0; i<t_l; i++) {
			var t = that.tags[i];
			if (!t.obj)
				continue;
			t.obj.style.fontSize = t.fontSize+"pt";
			t.obj.style.opacity = 1;
		}
	};

	this.setRadius = function(r) {
		that.radius = r;
		that.radiusPow = r*r;
	};

	this.getRadius = function() {
		return that.radius;
	};

	this.setZoom = function(z) {
		that.fontZoom = z;
	};

	this.getZoom = function() {
		return that.fontZoom;
	};

	this.getWidth = function() {
		return that.width;
	};

	this.splitString = function(str) {
		if (!str)
			return new Array();
		split = str.match(/[^\s-&]+[-]?\s*/gi); 
		if (!split)
			return new Array();
		return split;
	};
	
	that.add();
};

function Spot(x, y, radius) {
	this.x = x;
	this.y = y;
	this.radius = radius
	this.radiusPow = radius*radius;
	var that = this;
};

function Tag(obj, x, y) {
	this.obj = obj;
	this.x = x;
	this.y = y;
	this.width = obj.offsetWidth;
	this.height = obj.offsetHeight;
	this.fontSize = getNumber(obj.style.fontSize);
	this.coordinates = [this.x, this.y, this.x+this.width, this.y+this.height];
	this.center = [this.x+Math.round(this.width/2), this.y+Math.round(this.height/2)];
	this.isOwn = (this.obj && this.obj.style.display == 'none')? true : false;
	var that = this;
	
	this.getId = function() {
		return that.obj.id;
	};
};

function JDOM() {
	this.tmp = new Array();
	this.dbg = true;
	var that = this;

	this.getElementsByClassR = function(n, className) {
		if (n == null || className == null)
			return;
		if (n.className != null && n.className == className)
			that.tmp.push(n);
		for (var i=0, len = n.childNodes.length; i<len; i++) 
			that.getElementsByClassR(n.childNodes[i], className);
	};

	this.getElementsByClass = function(className, n) {
		that.tmp = new Array();	
		that.getElementsByClassR(n, className);
		return that.tmp;
	};
};


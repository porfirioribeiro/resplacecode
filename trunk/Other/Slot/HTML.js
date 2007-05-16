/**
 * @author Porfirio
 */
var HTML={};
HTML.Event= {
	key:{
		BACKSPACE: 8,
		TAB:       9,
		RETURN:   13,
		ESC:      27,
		LEFT:     37,
		UP:       38,
		RIGHT:    39,
		DOWN:     40,
		DELETE:   46,
		HOME:     36,
		END:      35,
		PAGEUP:   33,
		PAGEDOWN: 34
	},
	element: function() {
		return this.target || this.srcElement;
	},
	isLeftClick: function() {
		return (((this.which) && (this.which == 1)) || ((this.button) && (this.button == 1)));
	},
	getX: function() {
		return this.pageX || (this.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
	},
	getY: function() {
		return this.pageY || (this.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
	},
	stop: function() {
		if (this.preventDefault) {
			this.preventDefault();
			this.stopPropagation();
		} else {
			this.returnValue = false;
			this.cancelBubble = true;
		}
	}
};
HTML.Interface={
	_HTML_Interface:true,
	add:function(el){
		this.appendChild(el);
	},
	addEvent:function(ev,method){
		window.addEventTo(this,ev,method);
	},
	getText:function(){
		return this.innerHTML;
	},
	setText:function(text){
		this.innerHTML=text;
	},
	getX:function(){
		return this.style.left.toInt();
	},
	getY:function(){
		return this.style.top.toInt();
	},
	setX:function(x){
		this.style.left=x+"px";
	},
	setY:function(y){
		this.style.top=y+"px";
	},
	getWidth:function(){
		this.style.width.toInt();
	},
	getHeight:function(){
		this.style.height.toInt();
	},
	setWidth:function(width){
		this.style.width=width+"px";
	},
	setHeight:function(height){
		this.style.height=height+"px";
	},
	isVisible:function(){
		return (this.style.display!="none");
	},
	setVisible:function(visible){
		this.style.display=(visible)?"block":"none";
	},
	toogle:function(){
		this.setVisible(!this.isVisible());
	},
	getOpacity:function(){
		return isDef(this.opacity)?this.opacity:1;
	},
	setOpacity:function(opacity){
		this.opacity=Math.roundN(opacity,3);
		if (this.style.filter!==undefined) {
			this.style.filter = 'Alpha(opacity='+(this.opacity*100)+')';
			if (this.style.height===""){//IE7 Hack, DAMN IE
				this.style.height="1%";
			}
		}else if (this.style.opacity!==undefined){
			this.style.opacity=this.opacity;
		}else if (this.style.MozOpacity!==undefined){
			this.style.MozOpacity=this.opacity;
		}else if (this.style.KhtmlOpacity!==undefined){
			this.style.KhtmlOpacity=this.opacity;
		}
	},
	fading:false,
	onFadeFinish:function(){},
	fadeTo:function(to,speed){
		if (isDef(this._fadeInterval)){return;}
		if (to==this.getOpacity()){return;}
		speed=nDef(speed)?1:speed;
		var _el=this;
		var up=this.opacity<to;
		this.onFadeFinish=Function.empty;
		this._fadeInterval=setInterval(function(){				
			function _clearFade(){
				clearInterval(_el._fadeInterval);	
				_el._fadeInterval=undefined;	
				_el.fading=false;	
				_el.onFadeFinish();				
			}
			if (up && _el.getOpacity()<=to){
				_el.setOpacity(_el.getOpacity()+0.1,2);
				_el.fading=true;
			}else if (!up && _el.getOpacity()>=to){
				_el.setOpacity(_el.getOpacity()-0.1,2);
				_el.fading=true;
			}else{
				_clearFade();		
			}
			if (_el.getOpacity()===0 || _el.getOpacity()==1 || _el.getOpacity()==to){
				_clearFade();
			}
		},speed);
	},
	fadeAfterFade:function(to,speed){
		if (this.fading){
			this.onFadeFinish=function(){
				this.fadeTo(to,speed);
			};
		}else{
			this.fadeTo(to,speed);
		}		
	},
	fadeIn:function(speed){
		this.fadeTo(1,speed);
	},
	fadeOut:function(speed){
		this.fadeTo(0,speed);
	}
};
/**
 * Creates a new Div element
 * @id HTML.Div
 * @extends {HTML.Interface}
 */
HTML.Div=Class({
	Implements:HTML.Interface,
	_creator:function(){
		return document.createElement("div");
	},
	Constructor:function(){

	}
});
HTML.Body={
	
};
HTML.fromId=function(id){
	if (Class.is(id) && id._HTML_Interface){return id;}	
	var _K=Class({
		Implements:HTML.Interface,
		_creator:function(){
			return (Object.is(id))?id:document.getElementById(id);
		},
		Constructor:function(){
	
		}
	});
	return new _K();
};
$ID=HTML.fromId;
$E=function(event){
	return Class.extend((event || window.event),HTML.Event);
};

window.addEventTo=function(_EL,ev,method){
	var __listener=function(event){
		method.call(_EL,Class.extend((event || window.event),HTML.Event));		
	};
	if (_EL.addEventListener){
		_EL.addEventListener(ev,__listener,false);
	}else if (_EL.attachEvent){
		_EL.attachEvent("on"+ev,__listener);
	}
};
window.addEvent=function(ev,method){
	this.addEventTo(this,ev,method);
};
window.addOnLoad=function(method){
	this.addEvent("load",method);
};
document.addEvent=function(ev,method){
	addEventTo(this,ev,method);
};
$Body={
	addLater:[],
	_interval:null,
	_runtime:function(){
		if (document.body){
			clearInterval($Body._interval);
			for (var i=0;i<$Body.addLater.length;i++){
				document.body.appendChild($Body.addLater[i]);
			}
		}
	},
	add:function(el){
		if (document.body){
			document.body.appendChild(el);
		}else{
			this.addLater.push(el);
			if (!this._interval){
				this._interval=setInterval(this._runtime,10);
			}
		}
	}
};
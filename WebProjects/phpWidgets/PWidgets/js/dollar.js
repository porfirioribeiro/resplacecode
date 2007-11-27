/**
 * @author Porfirio
 */
/**
 * 
 * @param {Object} element
 * @param {HTMLElement} parent
 * @return {HTMLElement}
 */
function $(element,parent){
	if (!parent){
		parent=document;
	}
	if (String.is(element)){
		element=parent.getElementById(element);
	}
	return HTMLElement.extend(element);
}
/**
 *
 * @param {String} selector
 * @param {HTMLElement} parent
 * @return {Array}
 */
function $$(selector,parent){
	return $.getElementsBySelector(selector,parent);
}
//Get DOM elements based on the given CSS Selector - V 1.00.A Beta
//http://www.openjs.com/scripts/dom/css_selector/
/**
 * 
 * @param {String} all_selectors
 * @param {HTMLElement} parent
 * @return {Array}
 */
$.getElementsBySelector=function(all_selectors,parent){
    var selected = [];
	parent=(parent)?parent:document;
    if (!document.getElementsByTagName) {
        return selected;
    }
    all_selectors = all_selectors.replace(/\s*([^\w])\s*/g, "$1");//Remove the 'beutification' spaces
    var selectors = all_selectors.split(",");
    var getElements = function(context, tag){
        if (!tag) {
            tag = '*';
        }
        var found = [];
        for (var a = 0; a < context.length; a++) {
            var con = context[a];
            var eles;
            if (tag == '*') {
                eles = con.all ? con.all : con.getElementsByTagName("*");
            }
            else {
                eles = con.getElementsByTagName(tag);
            }
            for (var b = 0, leng = eles.length; b < leng; b++) {
                found.push(eles[b]);
            }
        }
        return found;
    };    
    for (var i = 0; i < selectors.length; i++) {
        selector = selectors[i];
        var context = [parent];
        var inheriters = selector.split(" ");       
        for (var j = 0; j < inheriters.length; j++) {
            element = inheriters[j];
            //This part is to make sure that it is not part of a CSS3 Selector
            var left_bracket = element.indexOf("[");
            var right_bracket = element.indexOf("]");
            var pos = element.indexOf("#");//ID
            if (pos + 1 && !(pos > left_bracket && pos < right_bracket)) {
                var parts = element.split("#");
                var tag = parts[0];
                var id = parts[1];
                var ele = parent.getElementById(id);
                if (!ele || (tag && ele.nodeName.toLowerCase() != tag)) { //Specified element not found
                    continue;
                }
                context = [ele];
                continue;
            }           
            pos = element.indexOf(".");//Class
            if (pos + 1 && !(pos > left_bracket && pos < right_bracket)) {
                parts = element.split('.');
                tag = parts[0];
                var class_name = parts[1];
                
                var found = getElements(context, tag);
                context = [];
                for (var l = 0; l < found.length; l++) {
                    fnd = found[l];
                    if (fnd.className && fnd.className.match(new RegExp('(^|\s)' + class_name + '(\s|$)'))) {
                        context.push(fnd);
                    }
                }
                continue;
            }
            if (element.indexOf('[') + 1) {
                if (element.match(/^(\w*)\[(\w+)([=~\|\^\$\*]?)=?['"]?([^\]'"]*)['"]?\]$/)) {
                    tag = RegExp.$1;
                    attr = RegExp.$2;
                    var operator = RegExp.$3;
                    var value = RegExp.$4;
                }
                found = getElements(context, tag);
                context = [];
                for (l = 0; l < found.length; l++) {
                    fnd = found[l];
                    if (operator == '=' && fnd.getAttribute(attr) != value) {
                        continue;
                    }
                    if (operator == '~' && !fnd.getAttribute(attr).match(new RegExp('(^|\\s)' + value + '(\\s|$)'))) {
                        continue;
                    }
                    if (operator == '|' && !fnd.getAttribute(attr).match(new RegExp('^' + value + '-?'))) {
                        continue;
                    }
                    if (operator == '^' && fnd.getAttribute(attr).indexOf(value) !== 0) {
                        continue;
                    }
                    if (operator == '$' && fnd.getAttribute(attr).lastIndexOf(value) != (fnd.getAttribute(attr).length - value.length)) {
                        continue;
                    }
                    if (operator == '*' && !(fnd.getAttribute(attr).indexOf(value) + 1)) {
                        continue;
                    }
                    else 
                        if (!fnd.getAttribute(attr)) {
                            continue;
                        }
                    context.push(fnd);
                }
                
                continue;
            }           
            found = getElements(context, element);
            context = found;
        }
		selected=selected.concat(context.map(HTMLElement.extend));
    }
	
    return ElementList.extend(selected);
};

$.extendObj = function(dst, src){
    for (i in src) {
        dst[i] = src[i];
    }
    return dst;
};

$.nlMethods=[];

/**
 * Creates a thread, optionaly you can specify the function to run
 * @param {Object} [options]
 * @param {Function} [runFn]
 */
$.Thread = function(options,runFn){
    if (Function.is(options)) {
        this.run = options;
    }else if (Function.is(runFn)) {
        this.run = runFn;
		if (Object.is(options)){
			$.extendObj(this,options);
		}
    }
};
$.Thread.prototype._interval = null;
$.Thread.prototype.interval = 0;
$.Thread.prototype.periodical = false;
$.Thread.prototype.timesExecuted=0;
$.Thread.prototype.timesToExecute=-1;
$.Thread.prototype.isWorking=false;
$.Thread.prototype.isPaused=false;
/**
 * Starts the Thread<br>
 * #start(); Starts the Thread now<br>
 * #start(10); Starts the Thread in 10 milseconds<br>
 * #start(10,true); Executes the Thread all 10 mileseconds until you #stop(); it
 * @param {Number} [interval] The milliseconds to wait to execute it, default=0 Execute now
 * @param {Boolean} [periodical] If true the Thread will be executed repeat with the interval
 * @param {Number} [timesToExecute] times to execute the periodical
 */
$.Thread.prototype.start = function(interval, periodical, timesToExecute){
	this.stop();//just for dont have multiple instances
	if (Number.is(interval)){
		this.interval=interval;
	}
	if (Boolean.is(periodical)){
		this.periodical=periodical;
	}
	if (Number.is(timesToExecute)){
		this.timesToExecute=timesToExecute;
	}
    this.timesExecuted=0;
	this.isWorking=true;
	this.isPaused=false;
    var _thread = this;
    this.callback = function(){
		if (_thread.timesExecuted==_thread.timesToExecute){
			_thread.stop();
			return;
		}
		_thread.timesExecuted++;
        _thread.run();
    };
    this._interval = (this.periodical) ? setInterval(this.callback, this.interval) : setTimeout(this.callback, this.interval);
};
/**
 * Stop the Thread
 */
$.Thread.prototype.stop = function(){
	this.isWorking=false;
    if (this.periodical) {
        clearInterval(this._interval);
    }
    else {
        clearTimeout(this._interval);
    }
};
/**
 * Pauses or unpauses the thread ( only for periodical threads )<br>
 * If you want to specify if you want to pause or unpause istehead of toggle set it on paramater<br>
 * It starts the thread if its not running <br>
 * pause(); //Toggles from pause to unpaused
 * pause(1); //Pause the thread
 * pause(0); //Unpause the thread
 * @param {Boolean} [pause]
 */
$.Thread.prototype.pause=function(pause){
	if (!this.periodical){
		return;
	}
	this.isPaused=(this.isPaused)?false:true;
	if (Boolean.is(pause)){
		this.isPaused=pause;
	}		
	if (this.isWorking){
		if (this.isPaused){
			clearInterval(this._interval);
		}else{
			this._interval=setInterval(this.callback, this.interval);
		}		
	}else{
		this.start();
	}
};
/**
 * This is the function to be runed
 * This function is abstract, it doesnt do nothing, and will be overiten
 */
$.Thread.prototype.run = function(){
};

$.Effect = function(fn, options){
	if (!this.isEventable){
		$.Eventable($.Effect);
	}
    var self = this;
	if (Function.is(fn)){
		this.subjects=[fn];
	}
	if (Array.is(fn)){
		this.subjects=fn;
	}
	if (!options){options={};}
    this.duration = (options.duration !== undefined) ? options.duration : 1000;
	this.thisObject= (options.thisObject !== undefined) ? options.thisObject : {};
	this.state = (options.from !== undefined) ? options.from : 0;
	this.target = (options.to !== undefined) ? options.to : 1;
	if (fn.adapt){
		fn.adapt.apply(this,[this.thisObject]);
	}
	if (this.state>this.target){
		this.reversing=true;
	}
    this.onComplete = (options.onComplete !== undefined) ? options.onComplete : function(){};
    this.onStep = (options.onStep !== undefined) ? options.onStep : function(){};
    this.interval = this.duration / 100;
    this.thread = new $.Thread({
		periodical: true,
		interval: self.interval,
		timesToExecute: 100
	}, function(){
		self.onTimer.apply(self,arguments);
	});

};
$.Effect.prototype.firstRun=true;
$.Effect.prototype.thread=null;
$.Effect.prototype.subjects=[];
$.Effect.prototype.target=1;
$.Effect.prototype.state=0;
$.Effect.prototype.reversing=false;

$.Effect.prototype.play=function(){
	this.seek(0,1);
};

$.Effect.prototype.reverse=function(){
	this.seek(1,0);
};

$.Effect.prototype.stop=function(){
	
};

$.Effect.prototype.pause=function(){
	
};

$.Effect.prototype.toggle=function(){
	if (this.firstRun){
		this.seekTo(this.target);
		this.firstRun=false;
	}else{
		this.seekTo(1 - this.target);
	}
};

$.Effect.prototype.seekTo=function(to){
	this.seek(this.state,to);
};

$.Effect.prototype.seek=function(from, to){
	this.target = Math.max(0, Math.min(1, to));
	this.state = Math.max(0, Math.min(1, from));	
	this.reversing=(this.state>this.target);
	this.thread.start();	
};

$.Effect.prototype.jumpTo=function(to){
	this.state=to;
	this.update();
};

$.Effect.prototype.update=function(){
	this.subjects.forEach(function(f){
		f.apply(this.thisObject,[this.state]);
	},this);
};

$.Effect.prototype.onTimer=function(){
	this.state=this.thread.timesExecuted/100;
	if (this.reversing){
		this.state=1-this.state;
	}
	this.update();
	this.onStep(this.state);
	if (this.state==this.target){
		this.thread.stop();
		this.onComplete();
	}
};
/**
 * Transforms any iterable to an array
 * @param {Object} it
 * @return {Array}
 */
function $A(it) {
  	if (!it){return [];}
	var result=[];
	for (var i=0;i<it.length;i++){
		result.push(it[i]);
	}
	return result;
}
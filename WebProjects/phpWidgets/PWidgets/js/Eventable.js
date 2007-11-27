/**
 * @author Porfirio
 */

//This class is just on start!!
$.Eventable = function(object,self){
	if (typeof(object) == "function"  && !self){
		object=object.prototype;
	}else if (typeof(object)=="object"){
	}else{
		throw TypeError();
	}
	object.isEventable=true;
	return $.extendObj(object,$.Eventable.prototype);
};

$.Eventable.prototype.eventObject={};

$.Eventable.prototype.fireEvent=function(event){
	var self;
	var args=$A(arguments);
	args.shift();
	if (Array.is(this.eventObject[event])) {
		this.eventObject[event].forEach(function(ev){
			ev.apply(self,args);
		});
	}
	if (Function.is(this[event])){
		this[event].apply(this,args);
	}
};

$.Eventable.prototype.observeEvent=function(event,callback){
	if (!Array.is(this.eventObject[event])){
		this.eventObject[event]=[];
	}
	this.eventObject[event].push(callback);
	return callback;
};

$.Eventable.prototype.unObserveEvent=function(event, callback){
	// TODO
};

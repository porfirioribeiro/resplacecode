/**
 * @author Porfirio
 */
Function.prototype.is=function(w){
	return (w instanceof this);
};
Function.empty=function(){};
Object.is=function(w){
	return (typeof(w)=="object");
};
String.prototype.toInt=function(){
	return parseInt(this,0);
};
String.toFloat=function(){
	return parseFloat(this);
};
var nDef=function(w){
	return (typeof(w)=="undefined");
};
var isDef=function(w){
	return !nDef(w);
};
Math.roundN=function(number,n){
	var N="1";
	for (var i=1;i<=n;i++){
		N=N+""+"0";
	}
	N=N.toInt();
	return (Math.round(number*N)/N);
};
/**
 * Create a new class
 * @param {Object} ob
 * @return {Function}
 */
var Class=function(ob){
	var UID="Class"+(Math.round(Math.random()*100000));
	var newClass=function(){
		var newObj;
		if (this._creator){
			newObj=this._creator();
			Class.extend(newObj,newClass.prototype);
			this.Constructor.apply(newObj,arguments);
			return newObj;
		}else if (this.Super && this.Super._creator){
			newObj=this.Super._creator();
			Class.extend(newObj,newClass.prototype);
			this.Constructor.apply(newObj,arguments);
			return newObj;
		}
		this.Constructor.apply(this,arguments);
	};
	newClass.prototype.Constructor=function(){};
	newClass.__isClass=true;
	newClass.prototype.UID=UID;
	newClass.UID=UID;
	newClass.is=function(w){
		return (this.prototype.UID==w.UID);
	};
	newClass.prototype.Extend=function(src){
		Class.extend(this,src);
	};
	for (var i in ob){
		if (i=="Extends"){
			if (Class.is(ob[i])){
				Class.extend(newClass,ob[i]);
				Class.extend(newClass.prototype,ob[i].prototype);
				newClass.prototype.Super=ob[i].prototype.Constructor;
				Class.extend(newClass.prototype.Super,ob[i].prototype);
				delete newClass.prototype._creator;
			}
		}else if (i=="Implements"){
			if (Array.is(ob[i])){
				for (var ii=0;ii<ob[i].length;ii++){
					if (Object.is(ob[i][ii])){
						Class.extend(newClass.prototype,ob[i][ii]);
					}
				}
			}else if (Object.is(ob[i])){
				Class.extend(newClass.prototype,ob[i]);
			}
		}else if (i=="Constructor"){
			newClass.prototype.Constructor=ob[i];
		}else if (i=="_creator"){
			newClass.prototype._creator=ob[i];
		}else{
			if (Object.is(ob[i]) && Object.is(newClass[i])){
				Class.extend(newClass[i],ob[i]);
			}else{
				newClass[i]=ob[i];
			}				
		}
	}
	return newClass;
};		
/**
 * Check if the specified parameter is a class
 * @param {Object} w
 */
Class.is=function(w){
	return (Function.is(w) && w.__isClass);
};
/**
 * Used for extend objects, not class's!!
 * @param {Object} dst
 * @param {Object} src
 */
Class.extend=function(dst,src){
	for(var i in src){
		if (Object.is(src[i]) && Object.is(dst[i])){
			Class.extend(dst[i],src[i]);
		}else{
			dst[i]=src[i];
		}
	}
	return dst;
};
Class.createUID=function(prefix,n){
	if (nDef(prefix)){prefix="";}
	if (nDef(n)){n=8;}
	var N="1";
	for (var i=1;i<=n;i++){
		N=N+""+"0";
	}
	N=N.toInt();
	return ""+prefix+(Math.round(Math.random()*N));
};
/**
 * @author Porfirio
 */

var pw={};

pw.Widget=function(){};
pw.Widget.prototype._init=function(){};
/**
 * 
 * @param {String} className
 * @param {Object} element
 */
$C=function(className,element){
	var _class=window;
	className.split(".").forEach(function(w){
		_class=_class[w];
	});
	className=className.replace(/\./,"_");
	element=$(element);
	if (_class && _class.prototype){
		if (!element["__is_"+className]){
			$.extendObj(element,_class.prototype);
			if (element._init){
				element._init();
			}
			element["__is_"+className]=true;
		}	
	}
	return element;	
};

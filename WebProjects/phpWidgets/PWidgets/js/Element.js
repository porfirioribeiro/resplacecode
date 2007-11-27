/**
 * @author Porfirio
 */
//Check if we have HTMLElement
if (typeof(HTMLElement)=="undefined"){
	HTMLElement=function(){};
	//var tags=["a:Anchor"];
	HTMLSelectElement=function(){};
	HTMLInputElement=function(){};
	HTMLElement._haveToExtend=true;
}
/**
 * 
 * @param {HTMLElement} element
 */
/**
 * 
 * @param {HTMLElement} element
 * @return {HTMLElement}
 */
HTMLElement.extend=function(element){
	if (element && !element.__extended && HTMLElement._haveToExtend){		
		$.extendObj(element,HTMLElement.prototype);
		
	}    	
	return element;
};

HTMLElement.prototype.isElement=true;

/**
 * Get child elements by selector text 
 * @param {Object} selector
 * @return {Array}
 */
HTMLElement.prototype.getBySelector=function(selector){
	return $.getElementsBySelector(selector,this);
};
/**
 * Check if the element is visible
 * @return {Boolean}
 */
HTMLElement.prototype.visible=function(){
	return this.style.display!="none" && this.style.display!==null;
};
/**
 * Hide the element
 * @return {HTMLElement}
 */
HTMLElement.prototype.hide=function(){
	this.style.display="none";
	return this;
};
$.nlMethods.push("hide");
/**
 * Show the element
 * @return {HTMLElement}
 */
HTMLElement.prototype.show=function(){
	this.style.display="";
	return this;
};
$.nlMethods.push("show");
/**
 * Toggle visible or hidden on element 
 * @return {HTMLElement}
 */
HTMLElement.prototype.toggle=function(){
	this[this.visible()?"hide":"show"]();
	return this;
};
$.nlMethods.push("toggle");
/**
 * Remove the element itself
 * @return {HTMLElement}
 */
HTMLElement.prototype.remove=function(){
    this.parentNode.removeChild(this);
	return this;
};
$.nlMethods.push("remove");

HTMLElement.prototype.getText=function(){
	return (this.innerHTML)?this.innerHTML.strip():this.value;
};
HTMLElement.prototype.setText=function(text){
	if (this.value===undefined){
		this.innerHTML=text;
	}else{
		this.value=text;
	}
};
/**
 * Get the dimensions of the element as a object width,height
 */
HTMLElement.prototype.getDimensions = function(){
    if (this.visible()) {
        return {
            width: this.offsetWidth,
            height: this.offsetHeight
        };
    }
    var _orig = {
        visibility: this.style.visibility,
        display: this.style.display
    };
    
    this.style.visibility = 'hidden';
    this.style.display = 'block';
    
    var result = {
        width: this.offsetWidth,
        height: this.offsetHeight
    };
    
    this.style.display = _orig.display;
    this.style.visibility = _orig.visibility;
    
    return result;
};
/**
 * Get the position of the element as a object x,y
 */
HTMLElement.prototype.getPosition = function(){
	var visible=this.visible();
	if (!visible){
	    var _orig = {
	        visibility: this.style.visibility,
	        display: this.style.display
	    };
	    
	    this.style.visibility = 'hidden';
	    this.style.display = 'block';		
	}
    var obj = this;
    var curleft = 0;
    var curtop = 0;
    if (obj.offsetParent) {
        curleft = obj.offsetLeft;
        curtop = obj.offsetTop;
        while ((obj = obj.offsetParent)) {
            curleft += obj.offsetLeft;
            curtop += obj.offsetTop;
        }
    }
	if (!visible){
	    this.style.display = _orig.display;
	    this.style.visibility = _orig.visibility;		
	}
    return {
        x: curleft,
        y: curtop
    };
};
/**
 * Get the bounds of the element as a object x,y,width,height
 */
HTMLElement.prototype.getBounds=function(){
	return $.extendObj(this.getPosition(),this.getDimensions());
};
/**
 * Get Element Opacity
 * @return {Number}
 */
HTMLElement.prototype.getOpacity=function(){
	if (this.filters){
		try{
			return this.filters.item("Alpha").opacity/100;
		}catch(e){
			return 1;
		}		
	}else{
		return (this.style.opacity==="")?1:this.style.opacity;
	}
};
/**
 * Set's the opacity of the element
 * @param {Object} opacity
 * @return {HTMLElement}
 */
HTMLElement.prototype.setOpacity=function(opacity){
	opacity=(opacity<0)?0:((opacity>1)?1:opacity);
	this.style.opacity=opacity;
	if (this.filters){		
		if (!this.currentStyle.hasLayout) {
			this.style.zoom = 1;
		}
		try{
			this.filters.item("Alpha").opacity=opacity*100;		
		}catch(e){
			this.style.filter="Alpha(opacity= "+opacity*100+" );";
		}		
	}
};
$.nlMethods.push("setOpacity");
/**
 * Get the value of the style
 * @param {String} style
 */
HTMLElement.prototype.getStyle=function(style){
	if (style=="float" || style=="cssFloat" || style=="styleFloat"){
		return this.style.cssFloat || this.style.styleFloat;
	}
	if (style=="opacity"){
		return this.getOpacity();
	}
	return this.style[style.camelize()];
};
/**
 * Set the style of the element
 * @param {String|Object} style
 * @return {HTMLElement}
 */
HTMLElement.prototype.setStyle=function(style){
	if (String.is(style)){
		this.style.cssText+=";"+style;
		if (style.contains("opacity:")){
			this.setOpacity(style.match(/opacity:\s*(\d?\.?\d*)/)[1]);
		}
	}else if (Object.is(style)){
		for (i in style){
			if (i == "float" || i == "cssFloat" || i == "styleFloat") {
				this.style.cssFloat=style[i];
				this.style.styleFloat=style[i];
			}else if (i=="opacity"){
				this.setOpacity(style[i]);
			}else{
				this.style[i]=style[i];
			}
		}
	}
	return this;
};
$.nlMethods.push("setStyle");

HTMLElement.prototype.animate=function(){
	
};


//ElementList
ElementList=function(){};

ElementList.extend=function(list){
	$.extendObj(list,ElementList.prototype);
	$.nlMethods.forEach(function(value,key,enumerable){
		list[value]=function(){
			for (var i=0;i<list.length;i++){
				this[i][value].apply(this[i],arguments);
			}
		};
	});	   	
	return list;	
};
ElementList.prototype.makeLol=function(){
	this.forEach(function(el){
		el.innerHTML="lol";
	});
};

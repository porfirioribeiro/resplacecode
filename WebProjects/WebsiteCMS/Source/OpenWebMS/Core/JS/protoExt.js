/**
 * @extends {MouseEvent}
 * @param {MouseEvent} e
 */
function doEvent(event){
	event.element=$(event.target || event.srcElement);
	if (event.element){
		event.element.getBounds=function(parent){return CSSEditor.methods.getBounds(this,parent);};
		event.isLeftClick=(((event.which) && (event.which == 1)) || ((event.button) && (event.button == 1)));
		event.mouseX=event.pageX || (event.clientX + (event.element.ownerDocument.documentElement.scrollLeft || event.element.ownerDocument.body.scrollLeft));
		event.mouseY=event.pageY || (event.clientY + (event.element.ownerDocument.documentElement.scrollTop  || event.element.ownerDocument.body.scrollTop));	
		event.key=(event.keyCode)?event.keyCode:event.which;	
		event.keyText=String.fromCharCode(event.keyCode);
	}
	return event;
}

var MyMethods={
	toggleClasseNameWith:function(element,class1,class2){
		if (!(element = $(element))) {
			return;
		}
		element.toggleClassName(class1);
		element.toggleClassName(class2);
	},
	getBounds:function(element){
		bounds=MyMethods.findPos(element);
		bounds.width= element.offsetWidth;
		bounds.height= element.offsetHeight;
		return bounds;
	},
	setBounds:function(element,bounds){
		element=$(element);
		element.style.left=bounds.x+"px";
		element.style.top=bounds.y+"px";
		element.style.width=bounds.width+"px";
		element.style.height=bounds.height+"px";
	},
	findPos:function (obj) {
		obj=$(obj);
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
		return {
			x: curleft,
			y: curtop
		};
	},
	setOpacity_:function(element, opacity){
		element=$(element);
		if (Prototype.Browser.IE){
			element.style.filter="alpha(opacity="+opacity*100+")";
		}else{
			element.style.opacity=opacity;
		}
	}	
	
};
Element.addMethods(MyMethods);
Element.addMethods({
	toggleClasseNameWith:function(element,class1,class2){
		if (!(element = $(element))) return;
		element.toggleClassName(class1);
		element.toggleClassName(class2);
	}
});
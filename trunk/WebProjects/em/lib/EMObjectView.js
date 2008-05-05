
/**
 * @author Porfirio
 */
if (!window.EM) {
    EM = {};
}
/**
 * 
 * @param {Object} config
 * @extends {Ext.Panel}
 */
EM.ObjectView=function(config){
		//alert(config);
        // Your preprocessing here
        config.border = false;
		config.collapsible= true;
        /*config.tbar = [{
            iconCls: "x-tbar-page-first"
        }, {
            iconCls: "x-tbar-page-prev"
        }, {
            iconCls: "x-tbar-page-next"
        }, {
            iconCls: "x-tbar-page-last"
        }]*/

		if (config.em){
			if (config.em.src){
				var id="EM_ObjectView_"+config.em.src.replace(/\.\w*/,"");
				config.html="<div id='"+id+"'></div>";
				EM.ObjectView.superclass.constructor.apply(this, arguments);
				var self=this;
				this.on({
				    render:{scope:self, fn:function() {
						var img=new Image();
						img.src="emotes/"+config.em.src;
						img.onload=function(){
							var _cont=document.getElementById(id);					
							for (var i=0;i<(this.width/config.em.width);i++){
								var _d=document.createElement("div");
								_cont.appendChild(_d);		
								//console.log(_d);
								_d.style.width=config.em.width;
								_d.style.cssFloat="left";
								_d.style.height=config.em.height;
								_d.style.backgroundImage="URL("+this.src+")";
								_d.style.backgroundPosition=i*config.em.width+"px 0px";					
							}
		
						};
				    }}
				});
				return;
			}
		}
		EM.ObjectView.superclass.constructor.apply(this, arguments);
		
        
        // Your postprocessing here	
}

Ext.extend(EM.ObjectView, Ext.Panel);



/*EM.ObjectView = Ext.extend(Ext.Panel, {
    constructor: function(config){
		alert(config);
        // Your preprocessing here
        config.border = false;
        config.tbar = [{
            iconCls: "x-tbar-page-first"
        }, {
            iconCls: "x-tbar-page-prev"
        }, {
            iconCls: "x-tbar-page-next"
        }, {
            iconCls: "x-tbar-page-last"
        }]
        EM.ObjectView.superclass.constructor.apply(this, arguments);
        // Your postprocessing here
    },
    
    yourMethod: function(){
        // etc.
    }
});*/


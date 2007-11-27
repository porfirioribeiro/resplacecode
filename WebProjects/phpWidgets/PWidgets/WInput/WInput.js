pw.WInput=function(){};
pw.WInput.prototype=new pw.Widget();
pw.WInput.prototype.$super=new pw.Widget();
pw.WInput.prototype._init=function(){
	this.$super._init.call(this);
};
pw.WInput.prototype.test=function(w){
	this.$super.test.call(this,"Hello "+w,"aa");
};
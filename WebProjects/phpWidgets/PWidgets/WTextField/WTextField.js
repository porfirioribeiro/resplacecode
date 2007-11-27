/**
 * @author Porfirio
 */
pw.WTextField=function(){};
pw.WTextField.prototype=new pw.Widget();
pw.WTextField.prototype.$super=new pw.Widget();

pw.WTextField.prototype._init=function(){
	this.$super._init.call(this);
	this.label=$C("pw.WLabel",this.id+":label");
	this.input=$C("pw.WInput",this.id+":input");
};

pw.WTextField.prototype.getLabel=function(){
	return this.label.getText();
};

pw.WTextField.prototype.setLabel=function(label){
	this.label.setText(label);
};

pw.WTextField.prototype.getValue=function(){
	return this.input.getText();
};

pw.WTextField.prototype.setValue=function(label){
	this.input.setText(label);
};

pw.WTextField.prototype.getText=pw.WTextField.prototype.getValue;
pw.WTextField.prototype.setText=pw.WTextField.prototype.setValue;
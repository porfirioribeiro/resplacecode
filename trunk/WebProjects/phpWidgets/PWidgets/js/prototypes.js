/**
 * @author Porfirio
 */
Function.prototype.is = function(w){
    return (w instanceof this);
};
/**
 * Returns a new thread with this function as #run function
 * @return {$.Thread} The new Thread
 */
Function.prototype.toThread=function(){
	return new $.Thread(this);
};

Function.prototype.execLater=function(ms){
	var thread=this.toThread();
	thread.start(ms);
	return thread;
};

Function.prototype.execPeriod=function(ms){
	var thread=this.toThread();
	thread.start(ms,true);
	return thread;
};


Function.is = function(w){
    return typeof(w) == "function";
};

String.is = function(w){
    return typeof(w) == "string";
};

Number.is = function(w){
    return typeof(w) == "number";
};

Boolean.is = function(w){
	return typeof(w) == "boolean";
};

Object.isDefined = function(w){
    return typeof(w) != "undefined";
};


/**
 * Escape the string to be used on RegExp
 * @return {String}
 */
String.prototype.escape = function(){
    if (!arguments.callee.sRE) {
        var specials = ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'];
        arguments.callee.sRE = new RegExp('(\\' + specials.join('|\\') + ')', 'g');
    }
    return this.replace(arguments.callee.sRE, '\\$1');
};
/**
 * Check the string againts the passed string, optional case insensitive
 * @param {String} text
 * @param {Boolean} [i] case insencitive, default to false
 * @return {Boolean}
 */
String.prototype.equals = function(text, i){
    if (i) {
        return this.toLowerCase() == text.toLowerCase();
    }
    else {
        return this == text;
    }
};
/**
 * Check if the string contains other string
 * @param {String} what
 * @return {Boolean}
 */
String.prototype.contains = function(text){
    return this.indexOf(text) > -1;
};
/**
 * Check if the string starts with the other string
 * @param {String} text
 * @return {Boolean}
 */
String.prototype.startsWith = function(text){
    return this.indexOf(text) === 0;
};
/**
 * Check if the string ends with the other string
 * @param {String} text
 * @return {Boolean}
 */
String.prototype.endsWith = function(text){
    return this.indexOf(text) == (this.length - text.length);
};
/**
 * check if the string is empty
 * @return {Boolean}
 */
String.prototype.empty = function(){
    return this.equals("");
};
/**
 * check if the string is blank
 * @return {Boolean}
 */
String.prototype.blank = function(){
    return (/^\s*$/.test(this));
};
/**
 * Check if the string is uppercased
 * @return {Boolean}
 */
String.prototype.isUpperCase = function(){
    return this.toUpperCase() == this;
};
/**
 * Check if the string is lowercased
 * @return {Boolean}
 */
String.prototype.isLowerCase = function(){
    return this.toLowerCase() == this;
};
/**
 * Make the first letter uppercase
 */
String.prototype.capitalize = function(){
    return this.charAt(0).toUpperCase() + this.substring(1).toLowerCase();
};
/**
 * Converts a css style to its Javascript name eg.: border-left-color to borderLeftColor
 */
String.prototype.camelize = function(){
    var arr = this.split("-");
    for (i = 1; i < arr.length; i++) {
        arr[i] = arr[i].capitalize();
    }
    return arr.join("");
};

String.prototype.uncamelize = function(){
    var arr = this.split("");
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].isUpperCase()) {
            arr[i] = "-" + arr[i].toLowerCase();
        }
    }
    return arr.join("");
};

String.prototype.strip = function(){
	return this.replace(/^\s+/, '').replace(/\s+$/, '');
};
//Array
/**
 * Returns the first index number at which the specified
 * element can be found in the array. Returns -1 if the
 * element is not present.
 * @param {Object} searchElement
 * @param {Number} fromIndex
 */
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(searchElement, fromIndex){
        fromIndex = (fromIndex) ? fromIndex : 0;
        for (var i = fromIndex; i < this.length; i++) {
            if (this[i] == searchElement) {
                return i;
            }
        }
        return -1;
    };
}
/**
 * Searches an array backwards starting from
 * fromIndex and returns the last index number at
 * which the specified element can be found in the
 * array. Returns -1 if the element is not present.
 * @param {Object} searchElement
 * @param {Number} fromIndex
 */
if (!Array.prototype.lastIndexOf) {
    Array.prototype.lastIndexOf = function(searchElement, fromIndex){
        fromIndex = isNaN(fromIndex) ? this.length : (fromIndex < 0 ? this.length + fromIndex : fromIndex) + 1;
        var result = this.slice(0, fromIndex).reverse().indexOf(searchElement);
        return (result == -1) ? result : fromIndex - result - 1;
    };
}

Array.prototype.size = function(){
    return this.length;
};

<?php

class TestSPL implements OuterIterator, Countable {
	var $it;
	function TestSPL(Iterator $it){
		$this->it=$it;
	}
	function getInnerIterator(){
		return $this->it;
	}
	function current(){
		return $this->it->current();
	}
	function next(){
		$this->it->next();
	}
	function key(){
		return $this->it->key();
	}
	function valid(){
		return $this->it->valid();
	}
	function rewind(){
		$this->it->rewind();
	}
	function count(){
		$c=0;
		foreach ($this as $value) {
			$c++;
		}
		return $c;
	}
	/**
	 * Limit this array
	 * @param int $offset
	 * @param int $count
	 * @return TestSPL
	 */
	function limit($offset = 0, $count = -1){
		$c= get_class($this);
		return new $c(new LimitIterator($this->getInnerIterator(),$offset,$count));
	}
	/**
	 * Filter the results by passing a class, function or string with wildcards
	 * @param mixed $filter
	 * @return TestSPL
	 */
	function filter($filter){
		$c= get_class($this);
		if (class_exists($filter) && is_subclass_of($filter,FilterIterator)){
			return new $c(new $filter($this->getInnerIterator()));
		}
		if (is_callable($filter)){
			return new $c(new FunctionFilterIterator($this->getInnerIterator(),@$filter));
		}
		if (is_string($filter)){
			$t=preg_replace('/[][{}()*+?.\\\\^$|]/', '\\\\$0',$filter);
			$t=preg_replace('/(\\\\\\*)/',".*",$t);
			$t=preg_replace('/(\\\\\\?)/',".{1}",$t);	
			return $this->filterRE("/^$t$/");
		}
	}
	/**
	 * Filter the results by passing an Regular Expression
	 * regex: the regular expression to match
	 * mode: operation mode (one of self::MATCH, self::GET_MATCH, self::ALL_MATCHES, self::SPLIT)
	 * flags: special flags (self::USE_KEY)
	 * preg_flags: global PREG_* flags, see preg_match(), preg_match_all(), preg_split() 
	 * @param String $regex
	 * @param int $mode
	 * @param int $flags
	 * @param int $preg_flags
	 * @return TestSPL
	 */
	function filterRE($regex, $mode = 0, $flags = 0, $preg_flags = 0){
		$c= get_class($this);
		return new $c(new RegexIterator($this->getInnerIterator(),$regex,$mode,$flags,$preg_flags));
	}
	
	function __toString(){
		
	}
}

class FunctionFilterIterator extends FilterIterator {
	var $fn;
	function FunctionFilterIterator($it, $fn){
		parent::__construct($it);
		if (!is_callable($fn)){
			//TODO error
		}
		$this->fn=$fn;
	}
	function accept(){
		return call_user_func($this->fn,$this->current(), $this->key(), $this->getInnerIterator());
	}
}

$it= new TestSPL(new ArrayIterator(array("ola","hello","nice!")));
echo "no limit, size: ".count($it)."<br>";
foreach ($it as $key => $value) {
	echo $key."-".$value."<br>";
}
function _filter($v,$k,$it){
	return $v>4;
}
//^[\w]*$
//echo "regexp, size: ".count($it)."<br>";
$it=$it->filterRE("/^[\w]*$/")->filter("*l*");

print($it[0]);
?>
<?php 
// *****************************************************************************
// Copyright 2003-2004 by A J Marston <http://www.tonymarston.net>
// Distributed under the GNU General Public Licence
// *****************************************************************************

class Encryption {
	var $scramble1;
	var $scramble2;
	var $errors;
	var $adj;
	var $mod;
	function encryption () {
		$this->errors = array();
		$this->scramble1 = '! #$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~!';
		$this->scramble2 = 'f^jAE]okIOzU[2&q1{3`h5w_794p@6s8?BgP>dFV=m D<TcS%Ze|r:lGK/uCy.Jx)HiQ!#$~(;Lt-R}Ma,NvW+Ynb*0Xf';
		if (strlen($this->scramble1) <> strlen($this->scramble2)) {
			$this->errors[] = '** SCRAMBLE1 is not same length as SCRAMBLE2 **';
		}
		$this->adj = 1.75;
		$this->mod = 3;
	}
	function decrypt ($key, $source) {
		$fudgefactor = $this->_convertKey($key);
		if ($this->errors) return;
		if (empty($source)) {
			$this->errors[] = 'No value has been supplied for decryption';
			return;
		}
		$target = null;
		$factor2 = 0;
		for ($i = 0; $i < strlen($source); $i++) {
			$char2 = substr($source, $i, 1);
			$num2 = strpos($this->scramble2, $char2);
			if ($num2 === false) {
				$this->errors[] = "Source string contains an invalid character ($char2)";
				return;
			}
			if ($num2 == 0) {
				$num2 = strlen($this->scramble1)-1;
			}
			$adj     = $this->_applyFudgeFactor($fudgefactor);
			$factor1 = $factor2 + $adj;
			$num1    = round($factor1 * -1) + $num2;
			$num1    = $this->_checkRange($num1);
			$factor2 = $factor1 + $num2;
			$char1 = substr($this->scramble1, $num1, 1);
			$target .= $char1;
		}
		return rtrim($target);
	}
	function encrypt ($key, $source, $sourcelen = 0) {
		$fudgefactor = $this->_convertKey($key);
		if ($this->errors) return;
		if (empty($source)) {
			$this->errors[] = 'No value has been supplied for encryption';
			return;
		}
		while (strlen($source) < $sourcelen) {
			$source .= ' ';
		}
		$target = null;
		$factor2 = 0;
		for ($i = 0; $i < strlen($source); $i++) {
			$char1 = substr($source, $i, 1);
			$num1 = strpos($this->scramble1, $char1);
			if ($num1 === false) {
				$this->errors[] = "Source string contains an invalid character ($char1)";
				return;
			}
			$adj     = $this->_applyFudgeFactor($fudgefactor);
			$factor1 = $factor2 + $adj;
			$num2    = round($factor1) + $num1;
			$num2    = $this->_checkRange($num2);
			$factor2 = $factor1 + $num2;
			$char2 = substr($this->scramble2, $num2, 1);
			$target .= $char2;
		}
		return $target;
	}
	function getAdjustment(){
		return $this->adj;
	}
	function getModulus (){
		return $this->mod;
	}
	function setAdjustment ($adj){
		$this->adj = (float)$adj;
	}
	function setModulus ($mod){
		$this->mod = (int)abs($mod);
	}
	function _applyFudgeFactor (&$fudgefactor) {
		$fudge = array_shift($fudgefactor);
		$fudge = $fudge + $this->adj;
		$fudgefactor[] = $fudge;
		if (!empty($this->mod)) {
			if ($fudge % $this->mod == 0) {
				$fudge = $fudge * -1;
			}
		}
		return $fudge;
	}
	function _checkRange ($num) {
		$num = round($num);
		$limit = strlen($this->scramble1)-1;
		while ($num > $limit) {
			$num = $num - $limit;
		}
		while ($num < 0) {
			$num = $num + $limit;
		}
		return $num;

	}
	function _convertKey ($key) {
		if (empty($key)) {
			$this->errors[] = 'No value has been supplied for the encryption key';
			return;
		}
		$array[] = strlen($key);
		$tot = 0;
		for ($i = 0; $i < strlen($key); $i++) {
			$char = substr($key, $i, 1);
			$num = strpos($this->scramble1, $char);
			if ($num === false) {
				$this->errors[] = "Key contains an invalid character ($char)";
				return;
			}
			$array[] = $num;
			$tot = $tot + $num;
		}
		$array[] = $tot;
		return $array;
	}
}
?> 
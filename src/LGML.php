<?php
namespace LWB\LGMLParser;
use hafriedlander\Peg\Parser\Basic;

class LGML extends Basic {

/* Node:		indent:Spaces adef:Adef (Spaces "," Spaces adef:Adef)* Spaces ((trailingcolon:",")|(trailingdot:/\.\s?/ trailingtext:/.* /)|"")  */
protected $match_Node_typestack = array('Node');
function match_Node ($stack = array()) {
	$matchrule = "Node"; $result = $this->construct($matchrule, $matchrule, null);
	$_25 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_25 = FALSE; break; }
		$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "adef" );
		}
		else { $_25 = FALSE; break; }
		while (true) {
			$res_7 = $result;
			$pos_7 = $this->pos;
			$_6 = NULL;
			do {
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_6 = FALSE; break; }
				if (substr($this->string,$this->pos,1) == ',') {
					$this->pos += 1;
					$result["text"] .= ',';
				}
				else { $_6 = FALSE; break; }
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_6 = FALSE; break; }
				$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "adef" );
				}
				else { $_6 = FALSE; break; }
				$_6 = TRUE; break;
			}
			while(0);
			if( $_6 === FALSE) {
				$result = $res_7;
				$this->pos = $pos_7;
				unset( $res_7 );
				unset( $pos_7 );
				break;
			}
		}
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_25 = FALSE; break; }
		$_23 = NULL;
		do {
			$_21 = NULL;
			do {
				$res_9 = $result;
				$pos_9 = $this->pos;
				$_11 = NULL;
				do {
					$stack[] = $result; $result = $this->construct( $matchrule, "trailingcolon" ); 
					if (substr($this->string,$this->pos,1) == ',') {
						$this->pos += 1;
						$result["text"] .= ',';
						$subres = $result; $result = array_pop($stack);
						$this->store( $result, $subres, 'trailingcolon' );
					}
					else {
						$result = array_pop($stack);
						$_11 = FALSE; break;
					}
					$_11 = TRUE; break;
				}
				while(0);
				if( $_11 === TRUE ) { $_21 = TRUE; break; }
				$result = $res_9;
				$this->pos = $pos_9;
				$_19 = NULL;
				do {
					$res_13 = $result;
					$pos_13 = $this->pos;
					$_16 = NULL;
					do {
						$stack[] = $result; $result = $this->construct( $matchrule, "trailingdot" ); 
						if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
							$result["text"] .= $subres;
							$subres = $result; $result = array_pop($stack);
							$this->store( $result, $subres, 'trailingdot' );
						}
						else {
							$result = array_pop($stack);
							$_16 = FALSE; break;
						}
						$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
						if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
							$result["text"] .= $subres;
							$subres = $result; $result = array_pop($stack);
							$this->store( $result, $subres, 'trailingtext' );
						}
						else {
							$result = array_pop($stack);
							$_16 = FALSE; break;
						}
						$_16 = TRUE; break;
					}
					while(0);
					if( $_16 === TRUE ) { $_19 = TRUE; break; }
					$result = $res_13;
					$this->pos = $pos_13;
					if (( $subres = $this->literal( '' ) ) !== FALSE) {
						$result["text"] .= $subres;
						$_19 = TRUE; break;
					}
					$result = $res_13;
					$this->pos = $pos_13;
					$_19 = FALSE; break;
				}
				while(0);
				if( $_19 === TRUE ) { $_21 = TRUE; break; }
				$result = $res_9;
				$this->pos = $pos_9;
				$_21 = FALSE; break;
			}
			while(0);
			if( $_21 === FALSE) { $_23 = FALSE; break; }
			$_23 = TRUE; break;
		}
		while(0);
		if( $_23 === FALSE) { $_25 = FALSE; break; }
		$_25 = TRUE; break;
	}
	while(0);
	if( $_25 === TRUE ) { return $this->finalise($result); }
	if( $_25 === FALSE) { return FALSE; }
}


/* Adef:		first:Literal (Spaces second:Literal2)?  */
protected $match_Adef_typestack = array('Adef');
function match_Adef ($stack = array()) {
	$matchrule = "Adef"; $result = $this->construct($matchrule, $matchrule, null);
	$_32 = NULL;
	do {
		$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "first" );
		}
		else { $_32 = FALSE; break; }
		$res_31 = $result;
		$pos_31 = $this->pos;
		$_30 = NULL;
		do {
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_30 = FALSE; break; }
			$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "second" );
			}
			else { $_30 = FALSE; break; }
			$_30 = TRUE; break;
		}
		while(0);
		if( $_30 === FALSE) {
			$result = $res_31;
			$this->pos = $pos_31;
			unset( $res_31 );
			unset( $pos_31 );
		}
		$_32 = TRUE; break;
	}
	while(0);
	if( $_32 === TRUE ) { return $this->finalise($result); }
	if( $_32 === FALSE) { return FALSE; }
}


/* Literal:	quoted:Quoted | simple:/[^\s\.,]+/  */
protected $match_Literal_typestack = array('Literal');
function match_Literal ($stack = array()) {
	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
	$_37 = NULL;
	do {
		$res_34 = $result;
		$pos_34 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_37 = TRUE; break;
		}
		$result = $res_34;
		$this->pos = $pos_34;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/[^\s\.,]+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_37 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_34;
		$this->pos = $pos_34;
		$_37 = FALSE; break;
	}
	while(0);
	if( $_37 === TRUE ) { return $this->finalise($result); }
	if( $_37 === FALSE) { return FALSE; }
}


/* Literal2:	quoted:Quoted | simple:/[^\.,]+/  */
protected $match_Literal2_typestack = array('Literal2');
function match_Literal2 ($stack = array()) {
	$matchrule = "Literal2"; $result = $this->construct($matchrule, $matchrule, null);
	$_42 = NULL;
	do {
		$res_39 = $result;
		$pos_39 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_42 = TRUE; break;
		}
		$result = $res_39;
		$this->pos = $pos_39;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/[^\.,]+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_42 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_39;
		$this->pos = $pos_39;
		$_42 = FALSE; break;
	}
	while(0);
	if( $_42 === TRUE ) { return $this->finalise($result); }
	if( $_42 === FALSE) { return FALSE; }
}


/* Spaces:		/ \s* /  */
protected $match_Spaces_typestack = array('Spaces');
function match_Spaces ($stack = array()) {
	$matchrule = "Spaces"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/ \s* /' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* Quoted:		q:/['"]/ quotedcontents:QuotedContents "$q"  */
protected $match_Quoted_typestack = array('Quoted');
function match_Quoted ($stack = array()) {
	$matchrule = "Quoted"; $result = $this->construct($matchrule, $matchrule, null);
	$_48 = NULL;
	do {
		$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
		if (( $subres = $this->rx( '/[\'"]/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'q' );
		}
		else {
			$result = array_pop($stack);
			$_48 = FALSE; break;
		}
		$matcher = 'match_'.'QuotedContents'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quotedcontents" );
		}
		else { $_48 = FALSE; break; }
		if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_48 = FALSE; break; }
		$_48 = TRUE; break;
	}
	while(0);
	if( $_48 === TRUE ) { return $this->finalise($result); }
	if( $_48 === FALSE) { return FALSE; }
}


/* QuotedContents:	( /[^${parent.q}]|(?:\\${parent.q})/ )*  */
protected $match_QuotedContents_typestack = array('QuotedContents');
function match_QuotedContents ($stack = array()) {
	$matchrule = "QuotedContents"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_52 = $result;
		$pos_52 = $this->pos;
		$_51 = NULL;
		do {
			if (( $subres = $this->rx( '/[^${parent.q}]|(?:\\\\${parent.q})/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_51 = FALSE; break; }
			$_51 = TRUE; break;
		}
		while(0);
		if( $_51 === FALSE) {
			$result = $res_52;
			$this->pos = $pos_52;
			unset( $res_52 );
			unset( $pos_52 );
			break;
		}
	}
	return $this->finalise($result);
}


/* IndentedDot:	indent:Spaces orphandot:/\.\s* /  */
protected $match_IndentedDot_typestack = array('IndentedDot');
function match_IndentedDot ($stack = array()) {
	$matchrule = "IndentedDot"; $result = $this->construct($matchrule, $matchrule, null);
	$_55 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_55 = FALSE; break; }
		$stack[] = $result; $result = $this->construct( $matchrule, "orphandot" ); 
		if (( $subres = $this->rx( '/\.\s* /' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'orphandot' );
		}
		else {
			$result = array_pop($stack);
			$_55 = FALSE; break;
		}
		$_55 = TRUE; break;
	}
	while(0);
	if( $_55 === TRUE ) { return $this->finalise($result); }
	if( $_55 === FALSE) { return FALSE; }
}



}

<?php

namespace LWB\LGMLParser;
use hafriedlander\Peg\Parser\Basic;

class LGML extends Basic {

/* Node:		indent:Spaces 	(adef:Adef adefs:Adefs Spaces
							(tc:TrailingComment
							|(trailingdot:/\.\s?/ trailingtext:/.* /)
							|(trailingcomma:"," Spaces (tc:TrailingComment)?)
							|(trailingcolon:":" Spaces 
								(tc:TrailingComment | trailingcolontext:Literal2)? 
								(trailingsemicolon:";" (Spaces tc:TrailingComment)?)?
							|(trailingsemicolon:";" (Spaces tc:TrailingComment)?)
							|""
							) 
				)  */
protected $match_Node_typestack = array('Node');
function match_Node ($stack = array()) {
	$matchrule = "Node"; $result = $this->construct($matchrule, $matchrule, null);
	$_63 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_63 = FALSE; break; }
		$_61 = NULL;
		do {
			$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adef" );
			}
			else { $_61 = FALSE; break; }
			$matcher = 'match_'.'Adefs'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adefs" );
			}
			else { $_61 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_61 = FALSE; break; }
			$_59 = NULL;
			do {
				$_57 = NULL;
				do {
					$res_4 = $result;
					$pos_4 = $this->pos;
					$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "tc" );
						$_57 = TRUE; break;
					}
					$result = $res_4;
					$this->pos = $pos_4;
					$_55 = NULL;
					do {
						$res_6 = $result;
						$pos_6 = $this->pos;
						$_9 = NULL;
						do {
							$stack[] = $result; $result = $this->construct( $matchrule, "trailingdot" ); 
							if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
								$result["text"] .= $subres;
								$subres = $result; $result = array_pop($stack);
								$this->store( $result, $subres, 'trailingdot' );
							}
							else {
								$result = array_pop($stack);
								$_9 = FALSE; break;
							}
							$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
							if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
								$result["text"] .= $subres;
								$subres = $result; $result = array_pop($stack);
								$this->store( $result, $subres, 'trailingtext' );
							}
							else {
								$result = array_pop($stack);
								$_9 = FALSE; break;
							}
							$_9 = TRUE; break;
						}
						while(0);
						if( $_9 === TRUE ) { $_55 = TRUE; break; }
						$result = $res_6;
						$this->pos = $pos_6;
						$_53 = NULL;
						do {
							$res_11 = $result;
							$pos_11 = $this->pos;
							$_17 = NULL;
							do {
								$stack[] = $result; $result = $this->construct( $matchrule, "trailingcomma" ); 
								if (substr($this->string,$this->pos,1) == ',') {
									$this->pos += 1;
									$result["text"] .= ',';
									$subres = $result; $result = array_pop($stack);
									$this->store( $result, $subres, 'trailingcomma' );
								}
								else {
									$result = array_pop($stack);
									$_17 = FALSE; break;
								}
								$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
								if ($subres !== FALSE) {
									$this->store( $result, $subres );
								}
								else { $_17 = FALSE; break; }
								$res_16 = $result;
								$pos_16 = $this->pos;
								$_15 = NULL;
								do {
									$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
									$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
									if ($subres !== FALSE) {
										$this->store( $result, $subres, "tc" );
									}
									else { $_15 = FALSE; break; }
									$_15 = TRUE; break;
								}
								while(0);
								if( $_15 === FALSE) {
									$result = $res_16;
									$this->pos = $pos_16;
									unset( $res_16 );
									unset( $pos_16 );
								}
								$_17 = TRUE; break;
							}
							while(0);
							if( $_17 === TRUE ) { $_53 = TRUE; break; }
							$result = $res_11;
							$this->pos = $pos_11;
							$_51 = NULL;
							do {
								$_49 = NULL;
								do {
									$res_19 = $result;
									$pos_19 = $this->pos;
									$_36 = NULL;
									do {
										$stack[] = $result; $result = $this->construct( $matchrule, "trailingcolon" ); 
										if (substr($this->string,$this->pos,1) == ':') {
											$this->pos += 1;
											$result["text"] .= ':';
											$subres = $result; $result = array_pop($stack);
											$this->store( $result, $subres, 'trailingcolon' );
										}
										else {
											$result = array_pop($stack);
											$_36 = FALSE; break;
										}
										$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
										$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
										if ($subres !== FALSE) {
											$this->store( $result, $subres );
										}
										else { $_36 = FALSE; break; }
										$res_28 = $result;
										$pos_28 = $this->pos;
										$_27 = NULL;
										do {
											$_25 = NULL;
											do {
												$res_22 = $result;
												$pos_22 = $this->pos;
												$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres, "tc" );
													$_25 = TRUE; break;
												}
												$result = $res_22;
												$this->pos = $pos_22;
												$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres, "trailingcolontext" );
													$_25 = TRUE; break;
												}
												$result = $res_22;
												$this->pos = $pos_22;
												$_25 = FALSE; break;
											}
											while(0);
											if( $_25 === FALSE) { $_27 = FALSE; break; }
											$_27 = TRUE; break;
										}
										while(0);
										if( $_27 === FALSE) {
											$result = $res_28;
											$this->pos = $pos_28;
											unset( $res_28 );
											unset( $pos_28 );
										}
										$res_35 = $result;
										$pos_35 = $this->pos;
										$_34 = NULL;
										do {
											$stack[] = $result; $result = $this->construct( $matchrule, "trailingsemicolon" ); 
											if (substr($this->string,$this->pos,1) == ';') {
												$this->pos += 1;
												$result["text"] .= ';';
												$subres = $result; $result = array_pop($stack);
												$this->store( $result, $subres, 'trailingsemicolon' );
											}
											else {
												$result = array_pop($stack);
												$_34 = FALSE; break;
											}
											$res_33 = $result;
											$pos_33 = $this->pos;
											$_32 = NULL;
											do {
												$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres );
												}
												else { $_32 = FALSE; break; }
												$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres, "tc" );
												}
												else { $_32 = FALSE; break; }
												$_32 = TRUE; break;
											}
											while(0);
											if( $_32 === FALSE) {
												$result = $res_33;
												$this->pos = $pos_33;
												unset( $res_33 );
												unset( $pos_33 );
											}
											$_34 = TRUE; break;
										}
										while(0);
										if( $_34 === FALSE) {
											$result = $res_35;
											$this->pos = $pos_35;
											unset( $res_35 );
											unset( $pos_35 );
										}
										$_36 = TRUE; break;
									}
									while(0);
									if( $_36 === TRUE ) { $_49 = TRUE; break; }
									$result = $res_19;
									$this->pos = $pos_19;
									$_47 = NULL;
									do {
										$res_38 = $result;
										$pos_38 = $this->pos;
										$_44 = NULL;
										do {
											$stack[] = $result; $result = $this->construct( $matchrule, "trailingsemicolon" ); 
											if (substr($this->string,$this->pos,1) == ';') {
												$this->pos += 1;
												$result["text"] .= ';';
												$subres = $result; $result = array_pop($stack);
												$this->store( $result, $subres, 'trailingsemicolon' );
											}
											else {
												$result = array_pop($stack);
												$_44 = FALSE; break;
											}
											$res_43 = $result;
											$pos_43 = $this->pos;
											$_42 = NULL;
											do {
												$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres );
												}
												else { $_42 = FALSE; break; }
												$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres, "tc" );
												}
												else { $_42 = FALSE; break; }
												$_42 = TRUE; break;
											}
											while(0);
											if( $_42 === FALSE) {
												$result = $res_43;
												$this->pos = $pos_43;
												unset( $res_43 );
												unset( $pos_43 );
											}
											$_44 = TRUE; break;
										}
										while(0);
										if( $_44 === TRUE ) { $_47 = TRUE; break; }
										$result = $res_38;
										$this->pos = $pos_38;
										if (( $subres = $this->literal( '' ) ) !== FALSE) {
											$result["text"] .= $subres;
											$_47 = TRUE; break;
										}
										$result = $res_38;
										$this->pos = $pos_38;
										$_47 = FALSE; break;
									}
									while(0);
									if( $_47 === TRUE ) { $_49 = TRUE; break; }
									$result = $res_19;
									$this->pos = $pos_19;
									$_49 = FALSE; break;
								}
								while(0);
								if( $_49 === FALSE) { $_51 = FALSE; break; }
								$_51 = TRUE; break;
							}
							while(0);
							if( $_51 === TRUE ) { $_53 = TRUE; break; }
							$result = $res_11;
							$this->pos = $pos_11;
							$_53 = FALSE; break;
						}
						while(0);
						if( $_53 === TRUE ) { $_55 = TRUE; break; }
						$result = $res_6;
						$this->pos = $pos_6;
						$_55 = FALSE; break;
					}
					while(0);
					if( $_55 === TRUE ) { $_57 = TRUE; break; }
					$result = $res_4;
					$this->pos = $pos_4;
					$_57 = FALSE; break;
				}
				while(0);
				if( $_57 === FALSE) { $_59 = FALSE; break; }
				$_59 = TRUE; break;
			}
			while(0);
			if( $_59 === FALSE) { $_61 = FALSE; break; }
			$_61 = TRUE; break;
		}
		while(0);
		if( $_61 === FALSE) { $_63 = FALSE; break; }
		$_63 = TRUE; break;
	}
	while(0);
	if( $_63 === TRUE ) { return $this->finalise($result); }
	if( $_63 === FALSE) { return FALSE; }
}


/* Adef:		first:Literal Spaces &tc:TrailingComment | first:Literal (Spaces second:Literal2)?   */
protected $match_Adef_typestack = array('Adef');
function match_Adef ($stack = array()) {
	$matchrule = "Adef"; $result = $this->construct($matchrule, $matchrule, null);
	$_78 = NULL;
	do {
		$res_65 = $result;
		$pos_65 = $this->pos;
		$_69 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_69 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_69 = FALSE; break; }
			$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "tc" );
			}
			else { $_69 = FALSE; break; }
			$_69 = TRUE; break;
		}
		while(0);
		if( $_69 === TRUE ) { $_78 = TRUE; break; }
		$result = $res_65;
		$this->pos = $pos_65;
		$_76 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_76 = FALSE; break; }
			$res_75 = $result;
			$pos_75 = $this->pos;
			$_74 = NULL;
			do {
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_74 = FALSE; break; }
				$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "second" );
				}
				else { $_74 = FALSE; break; }
				$_74 = TRUE; break;
			}
			while(0);
			if( $_74 === FALSE) {
				$result = $res_75;
				$this->pos = $pos_75;
				unset( $res_75 );
				unset( $pos_75 );
			}
			$_76 = TRUE; break;
		}
		while(0);
		if( $_76 === TRUE ) { $_78 = TRUE; break; }
		$result = $res_65;
		$this->pos = $pos_65;
		$_78 = FALSE; break;
	}
	while(0);
	if( $_78 === TRUE ) { return $this->finalise($result); }
	if( $_78 === FALSE) { return FALSE; }
}


/* Adefs:		(Spaces "," Spaces adef:Adef)*  */
protected $match_Adefs_typestack = array('Adefs');
function match_Adefs ($stack = array()) {
	$matchrule = "Adefs"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_85 = $result;
		$pos_85 = $this->pos;
		$_84 = NULL;
		do {
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_84 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == ',') {
				$this->pos += 1;
				$result["text"] .= ',';
			}
			else { $_84 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_84 = FALSE; break; }
			$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adef" );
			}
			else { $_84 = FALSE; break; }
			$_84 = TRUE; break;
		}
		while(0);
		if( $_84 === FALSE) {
			$result = $res_85;
			$this->pos = $pos_85;
			unset( $res_85 );
			unset( $pos_85 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Literal:	quoted:Quoted | simple:/([^\s\.,:;\/]|\/(?![\/\*]))+/   */
protected $match_Literal_typestack = array('Literal');
function match_Literal ($stack = array()) {
	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
	$_89 = NULL;
	do {
		$res_86 = $result;
		$pos_86 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_89 = TRUE; break;
		}
		$result = $res_86;
		$this->pos = $pos_86;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\s\.,:;\/]|\/(?![\/\*]))+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_89 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_86;
		$this->pos = $pos_86;
		$_89 = FALSE; break;
	}
	while(0);
	if( $_89 === TRUE ) { return $this->finalise($result); }
	if( $_89 === FALSE) { return FALSE; }
}


/* Literal2:	quoted:Quoted | simple:/([^\.,:;\/]|\/(?![\/\*]))+/   */
protected $match_Literal2_typestack = array('Literal2');
function match_Literal2 ($stack = array()) {
	$matchrule = "Literal2"; $result = $this->construct($matchrule, $matchrule, null);
	$_94 = NULL;
	do {
		$res_91 = $result;
		$pos_91 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_94 = TRUE; break;
		}
		$result = $res_91;
		$this->pos = $pos_91;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\.,:;\/]|\/(?![\/\*]))+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_94 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_91;
		$this->pos = $pos_91;
		$_94 = FALSE; break;
	}
	while(0);
	if( $_94 === TRUE ) { return $this->finalise($result); }
	if( $_94 === FALSE) { return FALSE; }
}


/* LiteralQuoted:	quoted:Quoted */
protected $match_LiteralQuoted_typestack = array('LiteralQuoted');
function match_LiteralQuoted ($stack = array()) {
	$matchrule = "LiteralQuoted"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres, "quoted" );
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* Spaces:		(/ \s /  |  ClosedComment)*  */
protected $match_Spaces_typestack = array('Spaces');
function match_Spaces ($stack = array()) {
	$matchrule = "Spaces"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_103 = $result;
		$pos_103 = $this->pos;
		$_102 = NULL;
		do {
			$_100 = NULL;
			do {
				$res_97 = $result;
				$pos_97 = $this->pos;
				if (( $subres = $this->rx( '/ \s /' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$_100 = TRUE; break;
				}
				$result = $res_97;
				$this->pos = $pos_97;
				$matcher = 'match_'.'ClosedComment'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_100 = TRUE; break;
				}
				$result = $res_97;
				$this->pos = $pos_97;
				$_100 = FALSE; break;
			}
			while(0);
			if( $_100 === FALSE) { $_102 = FALSE; break; }
			$_102 = TRUE; break;
		}
		while(0);
		if( $_102 === FALSE) {
			$result = $res_103;
			$this->pos = $pos_103;
			unset( $res_103 );
			unset( $pos_103 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Quoted:		q:/["]/ quotedcontents:QuotedContents "$q" | q:/[']/ quotedcontents2:QuotedContents2 "$q"  */
protected $match_Quoted_typestack = array('Quoted');
function match_Quoted ($stack = array()) {
	$matchrule = "Quoted"; $result = $this->construct($matchrule, $matchrule, null);
	$_115 = NULL;
	do {
		$res_104 = $result;
		$pos_104 = $this->pos;
		$_108 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/["]/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_108 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents" );
			}
			else { $_108 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_108 = FALSE; break; }
			$_108 = TRUE; break;
		}
		while(0);
		if( $_108 === TRUE ) { $_115 = TRUE; break; }
		$result = $res_104;
		$this->pos = $pos_104;
		$_113 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/[\']/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_113 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents2" );
			}
			else { $_113 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_113 = FALSE; break; }
			$_113 = TRUE; break;
		}
		while(0);
		if( $_113 === TRUE ) { $_115 = TRUE; break; }
		$result = $res_104;
		$this->pos = $pos_104;
		$_115 = FALSE; break;
	}
	while(0);
	if( $_115 === TRUE ) { return $this->finalise($result); }
	if( $_115 === FALSE) { return FALSE; }
}


/* QuotedContents:	( /\\.|[^"]/ )*  */
protected $match_QuotedContents_typestack = array('QuotedContents');
function match_QuotedContents ($stack = array()) {
	$matchrule = "QuotedContents"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_119 = $result;
		$pos_119 = $this->pos;
		$_118 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^"]/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_118 = FALSE; break; }
			$_118 = TRUE; break;
		}
		while(0);
		if( $_118 === FALSE) {
			$result = $res_119;
			$this->pos = $pos_119;
			unset( $res_119 );
			unset( $pos_119 );
			break;
		}
	}
	return $this->finalise($result);
}


/* QuotedContents2:( /\\.|[^']/ )*  */
protected $match_QuotedContents2_typestack = array('QuotedContents2');
function match_QuotedContents2 ($stack = array()) {
	$matchrule = "QuotedContents2"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_122 = $result;
		$pos_122 = $this->pos;
		$_121 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^\']/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_121 = FALSE; break; }
			$_121 = TRUE; break;
		}
		while(0);
		if( $_121 === FALSE) {
			$result = $res_122;
			$this->pos = $pos_122;
			unset( $res_122 );
			unset( $pos_122 );
			break;
		}
	}
	return $this->finalise($result);
}


/* TrailingComment: (l1:Commment1Line /.* / ) | lm:OpenCommmentMLine  */
protected $match_TrailingComment_typestack = array('TrailingComment');
function match_TrailingComment ($stack = array()) {
	$matchrule = "TrailingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_129 = NULL;
	do {
		$res_123 = $result;
		$pos_123 = $this->pos;
		$_126 = NULL;
		do {
			$matcher = 'match_'.'Commment1Line'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "l1" );
			}
			else { $_126 = FALSE; break; }
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_126 = FALSE; break; }
			$_126 = TRUE; break;
		}
		while(0);
		if( $_126 === TRUE ) { $_129 = TRUE; break; }
		$result = $res_123;
		$this->pos = $pos_123;
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "lm" );
			$_129 = TRUE; break;
		}
		$result = $res_123;
		$this->pos = $pos_123;
		$_129 = FALSE; break;
	}
	while(0);
	if( $_129 === TRUE ) { return $this->finalise($result); }
	if( $_129 === FALSE) { return FALSE; }
}


/* ClosingComment: cc:( "*" "/")  */
protected $match_ClosingComment_typestack = array('ClosingComment');
function match_ClosingComment ($stack = array()) {
	$matchrule = "ClosingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
	$_133 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_133 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '/') {
			$this->pos += 1;
			$result["text"] .= '/';
		}
		else { $_133 = FALSE; break; }
		$_133 = TRUE; break;
	}
	while(0);
	if( $_133 === TRUE ) {
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'cc' );
		return $this->finalise($result);
	}
	if( $_133 === FALSE) {
		$result = array_pop($stack);
		return FALSE;
	}
}


/* ClosedComment: OpenCommmentMLine ClosingComment  */
protected $match_ClosedComment_typestack = array('ClosedComment');
function match_ClosedComment ($stack = array()) {
	$matchrule = "ClosedComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_137 = NULL;
	do {
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_137 = FALSE; break; }
		$matcher = 'match_'.'ClosingComment'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_137 = FALSE; break; }
		$_137 = TRUE; break;
	}
	while(0);
	if( $_137 === TRUE ) { return $this->finalise($result); }
	if( $_137 === FALSE) { return FALSE; }
}


/* Commment1Line: "//"  */
protected $match_Commment1Line_typestack = array('Commment1Line');
function match_Commment1Line ($stack = array()) {
	$matchrule = "Commment1Line"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->literal( '//' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* OpenCommmentMLine: "/*" /([^\*]|\*(?![\/]))* /   */
protected $match_OpenCommmentMLine_typestack = array('OpenCommmentMLine');
function match_OpenCommmentMLine ($stack = array()) {
	$matchrule = "OpenCommmentMLine"; $result = $this->construct($matchrule, $matchrule, null);
	$_142 = NULL;
	do {
		if (( $subres = $this->literal( '/*' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_142 = FALSE; break; }
		if (( $subres = $this->rx( '/([^\*]|\*(?![\/]))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_142 = FALSE; break; }
		$_142 = TRUE; break;
	}
	while(0);
	if( $_142 === TRUE ) { return $this->finalise($result); }
	if( $_142 === FALSE) { return FALSE; }
}


/* ClosingCommentMLine: /([^\*]|\*(?![\/]))* / cc:( "*" "/")  */
protected $match_ClosingCommentMLine_typestack = array('ClosingCommentMLine');
function match_ClosingCommentMLine ($stack = array()) {
	$matchrule = "ClosingCommentMLine"; $result = $this->construct($matchrule, $matchrule, null);
	$_149 = NULL;
	do {
		if (( $subres = $this->rx( '/([^\*]|\*(?![\/]))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_149 = FALSE; break; }
		$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
		$_147 = NULL;
		do {
			if (substr($this->string,$this->pos,1) == '*') {
				$this->pos += 1;
				$result["text"] .= '*';
			}
			else { $_147 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '/') {
				$this->pos += 1;
				$result["text"] .= '/';
			}
			else { $_147 = FALSE; break; }
			$_147 = TRUE; break;
		}
		while(0);
		if( $_147 === TRUE ) {
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'cc' );
		}
		if( $_147 === FALSE) {
			$result = array_pop($stack);
			$_149 = FALSE; break;
		}
		$_149 = TRUE; break;
	}
	while(0);
	if( $_149 === TRUE ) { return $this->finalise($result); }
	if( $_149 === FALSE) { return FALSE; }
}


/* IndentedDot:	indent:Spaces (orphandot:/\.\s?/ trailingtext:/.* /)  */
protected $match_IndentedDot_typestack = array('IndentedDot');
function match_IndentedDot ($stack = array()) {
	$matchrule = "IndentedDot"; $result = $this->construct($matchrule, $matchrule, null);
	$_156 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_156 = FALSE; break; }
		$_154 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "orphandot" ); 
			if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'orphandot' );
			}
			else {
				$result = array_pop($stack);
				$_154 = FALSE; break;
			}
			$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'trailingtext' );
			}
			else {
				$result = array_pop($stack);
				$_154 = FALSE; break;
			}
			$_154 = TRUE; break;
		}
		while(0);
		if( $_154 === FALSE) { $_156 = FALSE; break; }
		$_156 = TRUE; break;
	}
	while(0);
	if( $_156 === TRUE ) { return $this->finalise($result); }
	if( $_156 === FALSE) { return FALSE; }
}




}

<?php

namespace LWB\LGMLParser;
use hafriedlander\Peg\Parser\Basic;

class LGML extends Basic {

/* Node2:		indent:Spaces adef:Adef (Spaces "," Spaces adef:Adef)* Spaces ((trailingcomma:",")|(trailingdot:/\.\s?/ trailingtext:/.* /)|"")  */
protected $match_Node2_typestack = array('Node2');
function match_Node2 ($stack = array()) {
	$matchrule = "Node2"; $result = $this->construct($matchrule, $matchrule, null);
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
					$stack[] = $result; $result = $this->construct( $matchrule, "trailingcomma" ); 
					if (substr($this->string,$this->pos,1) == ',') {
						$this->pos += 1;
						$result["text"] .= ',';
						$subres = $result; $result = array_pop($stack);
						$this->store( $result, $subres, 'trailingcomma' );
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


/* Node:		indent:Spaces 	(adef:Adef 
					( 
						(Spaces "," Spaces adef:Adef)* 
						(Spaces 
							(tc:TrailingComment
								|(trailingcomma:"," trailingcommaspaces:Spaces (tc:TrailingComment)?)
								|(trailingdot:/\.\s?/ trailingtext:/.* /)
								|(trailingcolon:":"  (tc:TrailingComment | trailingcolontext:/.* /))
								|""
							) 
						)
					)
				) */
protected $match_Node_typestack = array('Node');
function match_Node ($stack = array()) {
	$matchrule = "Node"; $result = $this->construct($matchrule, $matchrule, null);
	$_79 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_79 = FALSE; break; }
		$_77 = NULL;
		do {
			$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adef" );
			}
			else { $_77 = FALSE; break; }
			$_75 = NULL;
			do {
				while (true) {
					$res_34 = $result;
					$pos_34 = $this->pos;
					$_33 = NULL;
					do {
						$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_33 = FALSE; break; }
						if (substr($this->string,$this->pos,1) == ',') {
							$this->pos += 1;
							$result["text"] .= ',';
						}
						else { $_33 = FALSE; break; }
						$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_33 = FALSE; break; }
						$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "adef" );
						}
						else { $_33 = FALSE; break; }
						$_33 = TRUE; break;
					}
					while(0);
					if( $_33 === FALSE) {
						$result = $res_34;
						$this->pos = $pos_34;
						unset( $res_34 );
						unset( $pos_34 );
						break;
					}
				}
				$_73 = NULL;
				do {
					$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_73 = FALSE; break; }
					$_71 = NULL;
					do {
						$_69 = NULL;
						do {
							$res_36 = $result;
							$pos_36 = $this->pos;
							$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres, "tc" );
								$_69 = TRUE; break;
							}
							$result = $res_36;
							$this->pos = $pos_36;
							$_67 = NULL;
							do {
								$res_38 = $result;
								$pos_38 = $this->pos;
								$_44 = NULL;
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
										$_44 = FALSE; break;
									}
									$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
									$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
									if ($subres !== FALSE) {
										$this->store( $result, $subres, "trailingcommaspaces" );
									}
									else { $_44 = FALSE; break; }
									$res_43 = $result;
									$pos_43 = $this->pos;
									$_42 = NULL;
									do {
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
								if( $_44 === TRUE ) { $_67 = TRUE; break; }
								$result = $res_38;
								$this->pos = $pos_38;
								$_65 = NULL;
								do {
									$res_46 = $result;
									$pos_46 = $this->pos;
									$_49 = NULL;
									do {
										$stack[] = $result; $result = $this->construct( $matchrule, "trailingdot" ); 
										if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
											$result["text"] .= $subres;
											$subres = $result; $result = array_pop($stack);
											$this->store( $result, $subres, 'trailingdot' );
										}
										else {
											$result = array_pop($stack);
											$_49 = FALSE; break;
										}
										$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
										if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
											$result["text"] .= $subres;
											$subres = $result; $result = array_pop($stack);
											$this->store( $result, $subres, 'trailingtext' );
										}
										else {
											$result = array_pop($stack);
											$_49 = FALSE; break;
										}
										$_49 = TRUE; break;
									}
									while(0);
									if( $_49 === TRUE ) { $_65 = TRUE; break; }
									$result = $res_46;
									$this->pos = $pos_46;
									$_63 = NULL;
									do {
										$res_51 = $result;
										$pos_51 = $this->pos;
										$_60 = NULL;
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
												$_60 = FALSE; break;
											}
											$_58 = NULL;
											do {
												$_56 = NULL;
												do {
													$res_53 = $result;
													$pos_53 = $this->pos;
													$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
													$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
													if ($subres !== FALSE) {
														$this->store( $result, $subres, "tc" );
														$_56 = TRUE; break;
													}
													$result = $res_53;
													$this->pos = $pos_53;
													$stack[] = $result; $result = $this->construct( $matchrule, "trailingcolontext" ); 
													if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
														$result["text"] .= $subres;
														$subres = $result; $result = array_pop($stack);
														$this->store( $result, $subres, 'trailingcolontext' );
														$_56 = TRUE; break;
													}
													else {
														$result = array_pop($stack);
													}
													$result = $res_53;
													$this->pos = $pos_53;
													$_56 = FALSE; break;
												}
												while(0);
												if( $_56 === FALSE) { $_58 = FALSE; break; }
												$_58 = TRUE; break;
											}
											while(0);
											if( $_58 === FALSE) { $_60 = FALSE; break; }
											$_60 = TRUE; break;
										}
										while(0);
										if( $_60 === TRUE ) { $_63 = TRUE; break; }
										$result = $res_51;
										$this->pos = $pos_51;
										if (( $subres = $this->literal( '' ) ) !== FALSE) {
											$result["text"] .= $subres;
											$_63 = TRUE; break;
										}
										$result = $res_51;
										$this->pos = $pos_51;
										$_63 = FALSE; break;
									}
									while(0);
									if( $_63 === TRUE ) { $_65 = TRUE; break; }
									$result = $res_46;
									$this->pos = $pos_46;
									$_65 = FALSE; break;
								}
								while(0);
								if( $_65 === TRUE ) { $_67 = TRUE; break; }
								$result = $res_38;
								$this->pos = $pos_38;
								$_67 = FALSE; break;
							}
							while(0);
							if( $_67 === TRUE ) { $_69 = TRUE; break; }
							$result = $res_36;
							$this->pos = $pos_36;
							$_69 = FALSE; break;
						}
						while(0);
						if( $_69 === FALSE) { $_71 = FALSE; break; }
						$_71 = TRUE; break;
					}
					while(0);
					if( $_71 === FALSE) { $_73 = FALSE; break; }
					$_73 = TRUE; break;
				}
				while(0);
				if( $_73 === FALSE) { $_75 = FALSE; break; }
				$_75 = TRUE; break;
			}
			while(0);
			if( $_75 === FALSE) { $_77 = FALSE; break; }
			$_77 = TRUE; break;
		}
		while(0);
		if( $_77 === FALSE) { $_79 = FALSE; break; }
		$_79 = TRUE; break;
	}
	while(0);
	if( $_79 === TRUE ) { return $this->finalise($result); }
	if( $_79 === FALSE) { return FALSE; }
}


/* Adef:		first:Literal Spaces &tc:TrailingComment | first:Literal (Spaces second:Literal2)?  */
protected $match_Adef_typestack = array('Adef');
function match_Adef ($stack = array()) {
	$matchrule = "Adef"; $result = $this->construct($matchrule, $matchrule, null);
	$_94 = NULL;
	do {
		$res_81 = $result;
		$pos_81 = $this->pos;
		$_85 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_85 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_85 = FALSE; break; }
			$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "tc" );
			}
			else { $_85 = FALSE; break; }
			$_85 = TRUE; break;
		}
		while(0);
		if( $_85 === TRUE ) { $_94 = TRUE; break; }
		$result = $res_81;
		$this->pos = $pos_81;
		$_92 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_92 = FALSE; break; }
			$res_91 = $result;
			$pos_91 = $this->pos;
			$_90 = NULL;
			do {
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_90 = FALSE; break; }
				$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "second" );
				}
				else { $_90 = FALSE; break; }
				$_90 = TRUE; break;
			}
			while(0);
			if( $_90 === FALSE) {
				$result = $res_91;
				$this->pos = $pos_91;
				unset( $res_91 );
				unset( $pos_91 );
			}
			$_92 = TRUE; break;
		}
		while(0);
		if( $_92 === TRUE ) { $_94 = TRUE; break; }
		$result = $res_81;
		$this->pos = $pos_81;
		$_94 = FALSE; break;
	}
	while(0);
	if( $_94 === TRUE ) { return $this->finalise($result); }
	if( $_94 === FALSE) { return FALSE; }
}


/* Literal:	quoted:Quoted | simple:/([^\s\.,:\/]|\/(?![\/\*]))+/  */
protected $match_Literal_typestack = array('Literal');
function match_Literal ($stack = array()) {
	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
	$_99 = NULL;
	do {
		$res_96 = $result;
		$pos_96 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_99 = TRUE; break;
		}
		$result = $res_96;
		$this->pos = $pos_96;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\s\.,:\/]|\/(?![\/\*]))+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_99 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_96;
		$this->pos = $pos_96;
		$_99 = FALSE; break;
	}
	while(0);
	if( $_99 === TRUE ) { return $this->finalise($result); }
	if( $_99 === FALSE) { return FALSE; }
}


/* Literal2:	quoted:Quoted | simple:/([^\.,:\/]|\/(?![\/\*]))+/  */
protected $match_Literal2_typestack = array('Literal2');
function match_Literal2 ($stack = array()) {
	$matchrule = "Literal2"; $result = $this->construct($matchrule, $matchrule, null);
	$_104 = NULL;
	do {
		$res_101 = $result;
		$pos_101 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_104 = TRUE; break;
		}
		$result = $res_101;
		$this->pos = $pos_101;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\.,:\/]|\/(?![\/\*]))+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_104 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_101;
		$this->pos = $pos_101;
		$_104 = FALSE; break;
	}
	while(0);
	if( $_104 === TRUE ) { return $this->finalise($result); }
	if( $_104 === FALSE) { return FALSE; }
}


/* Spaces:		(/ \s /  |  ClosedComment)* */
protected $match_Spaces_typestack = array('Spaces');
function match_Spaces ($stack = array()) {
	$matchrule = "Spaces"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_112 = $result;
		$pos_112 = $this->pos;
		$_111 = NULL;
		do {
			$_109 = NULL;
			do {
				$res_106 = $result;
				$pos_106 = $this->pos;
				if (( $subres = $this->rx( '/ \s /' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$_109 = TRUE; break;
				}
				$result = $res_106;
				$this->pos = $pos_106;
				$matcher = 'match_'.'ClosedComment'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_109 = TRUE; break;
				}
				$result = $res_106;
				$this->pos = $pos_106;
				$_109 = FALSE; break;
			}
			while(0);
			if( $_109 === FALSE) { $_111 = FALSE; break; }
			$_111 = TRUE; break;
		}
		while(0);
		if( $_111 === FALSE) {
			$result = $res_112;
			$this->pos = $pos_112;
			unset( $res_112 );
			unset( $pos_112 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Quoted:		q:/["]/ quotedcontents:QuotedContents "$q" | q:/[']/ quotedcontents2:QuotedContents2 "$q" */
protected $match_Quoted_typestack = array('Quoted');
function match_Quoted ($stack = array()) {
	$matchrule = "Quoted"; $result = $this->construct($matchrule, $matchrule, null);
	$_124 = NULL;
	do {
		$res_113 = $result;
		$pos_113 = $this->pos;
		$_117 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/["]/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_117 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents" );
			}
			else { $_117 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_117 = FALSE; break; }
			$_117 = TRUE; break;
		}
		while(0);
		if( $_117 === TRUE ) { $_124 = TRUE; break; }
		$result = $res_113;
		$this->pos = $pos_113;
		$_122 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/[\']/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_122 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents2" );
			}
			else { $_122 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_122 = FALSE; break; }
			$_122 = TRUE; break;
		}
		while(0);
		if( $_122 === TRUE ) { $_124 = TRUE; break; }
		$result = $res_113;
		$this->pos = $pos_113;
		$_124 = FALSE; break;
	}
	while(0);
	if( $_124 === TRUE ) { return $this->finalise($result); }
	if( $_124 === FALSE) { return FALSE; }
}


/* QuotedContents:	( /\\.|[^"]/ )* */
protected $match_QuotedContents_typestack = array('QuotedContents');
function match_QuotedContents ($stack = array()) {
	$matchrule = "QuotedContents"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_128 = $result;
		$pos_128 = $this->pos;
		$_127 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^"]/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_127 = FALSE; break; }
			$_127 = TRUE; break;
		}
		while(0);
		if( $_127 === FALSE) {
			$result = $res_128;
			$this->pos = $pos_128;
			unset( $res_128 );
			unset( $pos_128 );
			break;
		}
	}
	return $this->finalise($result);
}


/* QuotedContents2:( /\\.|[^']/ )* */
protected $match_QuotedContents2_typestack = array('QuotedContents2');
function match_QuotedContents2 ($stack = array()) {
	$matchrule = "QuotedContents2"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_131 = $result;
		$pos_131 = $this->pos;
		$_130 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^\']/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_130 = FALSE; break; }
			$_130 = TRUE; break;
		}
		while(0);
		if( $_130 === FALSE) {
			$result = $res_131;
			$this->pos = $pos_131;
			unset( $res_131 );
			unset( $pos_131 );
			break;
		}
	}
	return $this->finalise($result);
}


/* TrailingComment: (l1:Commment1Line /.* / ) | lm:OpenCommmentMLine */
protected $match_TrailingComment_typestack = array('TrailingComment');
function match_TrailingComment ($stack = array()) {
	$matchrule = "TrailingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_138 = NULL;
	do {
		$res_132 = $result;
		$pos_132 = $this->pos;
		$_135 = NULL;
		do {
			$matcher = 'match_'.'Commment1Line'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "l1" );
			}
			else { $_135 = FALSE; break; }
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_135 = FALSE; break; }
			$_135 = TRUE; break;
		}
		while(0);
		if( $_135 === TRUE ) { $_138 = TRUE; break; }
		$result = $res_132;
		$this->pos = $pos_132;
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "lm" );
			$_138 = TRUE; break;
		}
		$result = $res_132;
		$this->pos = $pos_132;
		$_138 = FALSE; break;
	}
	while(0);
	if( $_138 === TRUE ) { return $this->finalise($result); }
	if( $_138 === FALSE) { return FALSE; }
}


/* ClosingComment: cc:(/([^\*]|\*(?!\/))* /  "*" "/") */
protected $match_ClosingComment_typestack = array('ClosingComment');
function match_ClosingComment ($stack = array()) {
	$matchrule = "ClosingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
	$_143 = NULL;
	do {
		if (( $subres = $this->rx( '/([^\*]|\*(?!\/))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_143 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_143 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '/') {
			$this->pos += 1;
			$result["text"] .= '/';
		}
		else { $_143 = FALSE; break; }
		$_143 = TRUE; break;
	}
	while(0);
	if( $_143 === TRUE ) {
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'cc' );
		return $this->finalise($result);
	}
	if( $_143 === FALSE) {
		$result = array_pop($stack);
		return FALSE;
	}
}


/* ClosingComment1: cc:(/.* /  "*" "/") */
protected $match_ClosingComment1_typestack = array('ClosingComment1');
function match_ClosingComment1 ($stack = array()) {
	$matchrule = "ClosingComment1"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
	$_148 = NULL;
	do {
		if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_148 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_148 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '/') {
			$this->pos += 1;
			$result["text"] .= '/';
		}
		else { $_148 = FALSE; break; }
		$_148 = TRUE; break;
	}
	while(0);
	if( $_148 === TRUE ) {
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'cc' );
		return $this->finalise($result);
	}
	if( $_148 === FALSE) {
		$result = array_pop($stack);
		return FALSE;
	}
}


/* ClosedComment: OpenCommmentMLine ClosingComment */
protected $match_ClosedComment_typestack = array('ClosedComment');
function match_ClosedComment ($stack = array()) {
	$matchrule = "ClosedComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_152 = NULL;
	do {
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_152 = FALSE; break; }
		$matcher = 'match_'.'ClosingComment'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_152 = FALSE; break; }
		$_152 = TRUE; break;
	}
	while(0);
	if( $_152 === TRUE ) { return $this->finalise($result); }
	if( $_152 === FALSE) { return FALSE; }
}


/* Commment1Line: "//" */
protected $match_Commment1Line_typestack = array('Commment1Line');
function match_Commment1Line ($stack = array()) {
	$matchrule = "Commment1Line"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->literal( '//' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* OpenCommmentMLine: "/*" /([^\*]|\*(?![\/]))* /  */
protected $match_OpenCommmentMLine_typestack = array('OpenCommmentMLine');
function match_OpenCommmentMLine ($stack = array()) {
	$matchrule = "OpenCommmentMLine"; $result = $this->construct($matchrule, $matchrule, null);
	$_157 = NULL;
	do {
		if (( $subres = $this->literal( '/*' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_157 = FALSE; break; }
		if (( $subres = $this->rx( '/([^\*]|\*(?![\/]))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_157 = FALSE; break; }
		$_157 = TRUE; break;
	}
	while(0);
	if( $_157 === TRUE ) { return $this->finalise($result); }
	if( $_157 === FALSE) { return FALSE; }
}


/* IndentedDot:	indent:Spaces (orphandot:/\.\s?/ trailingtext:/.* /) */
protected $match_IndentedDot_typestack = array('IndentedDot');
function match_IndentedDot ($stack = array()) {
	$matchrule = "IndentedDot"; $result = $this->construct($matchrule, $matchrule, null);
	$_164 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_164 = FALSE; break; }
		$_162 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "orphandot" ); 
			if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'orphandot' );
			}
			else {
				$result = array_pop($stack);
				$_162 = FALSE; break;
			}
			$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'trailingtext' );
			}
			else {
				$result = array_pop($stack);
				$_162 = FALSE; break;
			}
			$_162 = TRUE; break;
		}
		while(0);
		if( $_162 === FALSE) { $_164 = FALSE; break; }
		$_164 = TRUE; break;
	}
	while(0);
	if( $_164 === TRUE ) { return $this->finalise($result); }
	if( $_164 === FALSE) { return FALSE; }
}



}

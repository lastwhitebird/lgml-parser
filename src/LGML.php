<?php

namespace LWB\LGMLParser;
use hafriedlander\Peg\Parser\Basic;

class LGML extends Basic {

/* Node:		indent:Spaces 	(adef:Adef adefs:Adefs Spaces
							(tc:TrailingComment
							|(trailingdot:/\.\s?/ trailingtext:/.* /)
							|(trailingcomma:"," Spaces (tc:TrailingComment)?)
							|(trailingcolon:":" Spaces 
								(tc:TrailingComment | trailingcolontext:LiteralQuoted)? 
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
												$matcher = 'match_'.'LiteralQuoted'; $key = $matcher; $pos = $this->pos;
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


/* Adef2:		first:Literal (Spaces second:Literal2)?   | first:Literal Spaces &tc:TrailingComment */
protected $match_Adef2_typestack = array('Adef2');
function match_Adef2 ($stack = array()) {
	$matchrule = "Adef2"; $result = $this->construct($matchrule, $matchrule, null);
	$_78 = NULL;
	do {
		$res_65 = $result;
		$pos_65 = $this->pos;
		$_71 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_71 = FALSE; break; }
			$res_70 = $result;
			$pos_70 = $this->pos;
			$_69 = NULL;
			do {
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_69 = FALSE; break; }
				$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "second" );
				}
				else { $_69 = FALSE; break; }
				$_69 = TRUE; break;
			}
			while(0);
			if( $_69 === FALSE) {
				$result = $res_70;
				$this->pos = $pos_70;
				unset( $res_70 );
				unset( $pos_70 );
			}
			$_71 = TRUE; break;
		}
		while(0);
		if( $_71 === TRUE ) { $_78 = TRUE; break; }
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
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_76 = FALSE; break; }
			$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "tc" );
			}
			else { $_76 = FALSE; break; }
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


/* Adef1:		first:Literal Spaces &tc:TrailingComment | first:Literal (Spaces second:Literal2)?  
							|&trailingdot:/\.\s?/ 
							|&trailingcomma:"," 
							|&trailingcolon:":" 
							|&trailingsemicolon:";" 
							|&"" */
protected $match_Adef1_typestack = array('Adef1');
function match_Adef1 ($stack = array()) {
	$matchrule = "Adef1"; $result = $this->construct($matchrule, $matchrule, null);
	$_113 = NULL;
	do {
		$res_80 = $result;
		$pos_80 = $this->pos;
		$_84 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_84 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_84 = FALSE; break; }
			$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "tc" );
			}
			else { $_84 = FALSE; break; }
			$_84 = TRUE; break;
		}
		while(0);
		if( $_84 === TRUE ) { $_113 = TRUE; break; }
		$result = $res_80;
		$this->pos = $pos_80;
		$_111 = NULL;
		do {
			$res_86 = $result;
			$pos_86 = $this->pos;
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
			if( $_92 === TRUE ) { $_111 = TRUE; break; }
			$result = $res_86;
			$this->pos = $pos_86;
			$_109 = NULL;
			do {
				$res_94 = $result;
				$pos_94 = $this->pos;
				$stack[] = $result; $result = $this->construct( $matchrule, "trailingdot" ); 
				if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$subres = $result; $result = array_pop($stack);
					$this->store( $result, $subres, 'trailingdot' );
					$_109 = TRUE; break;
				}
				else { $result = array_pop($stack); }
				$result = $res_94;
				$this->pos = $pos_94;
				$_107 = NULL;
				do {
					$res_96 = $result;
					$pos_96 = $this->pos;
					$stack[] = $result; $result = $this->construct( $matchrule, "trailingcomma" ); 
					if (substr($this->string,$this->pos,1) == ',') {
						$this->pos += 1;
						$result["text"] .= ',';
						$subres = $result; $result = array_pop($stack);
						$this->store( $result, $subres, 'trailingcomma' );
						$_107 = TRUE; break;
					}
					else { $result = array_pop($stack); }
					$result = $res_96;
					$this->pos = $pos_96;
					$_105 = NULL;
					do {
						$res_98 = $result;
						$pos_98 = $this->pos;
						$stack[] = $result; $result = $this->construct( $matchrule, "trailingcolon" ); 
						if (substr($this->string,$this->pos,1) == ':') {
							$this->pos += 1;
							$result["text"] .= ':';
							$subres = $result; $result = array_pop($stack);
							$this->store( $result, $subres, 'trailingcolon' );
							$_105 = TRUE; break;
						}
						else { $result = array_pop($stack); }
						$result = $res_98;
						$this->pos = $pos_98;
						$_103 = NULL;
						do {
							$res_100 = $result;
							$pos_100 = $this->pos;
							$stack[] = $result; $result = $this->construct( $matchrule, "trailingsemicolon" ); 
							if (substr($this->string,$this->pos,1) == ';') {
								$this->pos += 1;
								$result["text"] .= ';';
								$subres = $result; $result = array_pop($stack);
								$this->store( $result, $subres, 'trailingsemicolon' );
								$_103 = TRUE; break;
							}
							else { $result = array_pop($stack); }
							$result = $res_100;
							$this->pos = $pos_100;
							$res_102 = $result;
							$pos_102 = $this->pos;
							if (( $subres = $this->literal( '' ) ) !== FALSE) {
								$result["text"] .= $subres;
								$result = $res_102;
								$this->pos = $pos_102;
								$_103 = TRUE; break;
							}
							else {
								$result = $res_102;
								$this->pos = $pos_102;
							}
							$result = $res_100;
							$this->pos = $pos_100;
							$_103 = FALSE; break;
						}
						while(0);
						if( $_103 === TRUE ) { $_105 = TRUE; break; }
						$result = $res_98;
						$this->pos = $pos_98;
						$_105 = FALSE; break;
					}
					while(0);
					if( $_105 === TRUE ) { $_107 = TRUE; break; }
					$result = $res_96;
					$this->pos = $pos_96;
					$_107 = FALSE; break;
				}
				while(0);
				if( $_107 === TRUE ) { $_109 = TRUE; break; }
				$result = $res_94;
				$this->pos = $pos_94;
				$_109 = FALSE; break;
			}
			while(0);
			if( $_109 === TRUE ) { $_111 = TRUE; break; }
			$result = $res_86;
			$this->pos = $pos_86;
			$_111 = FALSE; break;
		}
		while(0);
		if( $_111 === TRUE ) { $_113 = TRUE; break; }
		$result = $res_80;
		$this->pos = $pos_80;
		$_113 = FALSE; break;
	}
	while(0);
	if( $_113 === TRUE ) { return $this->finalise($result); }
	if( $_113 === FALSE) { return FALSE; }
}


/* Adef:		first:Literal Spaces &tc:TrailingComment | first:Literal (Spaces second:Literal2)?   */
protected $match_Adef_typestack = array('Adef');
function match_Adef ($stack = array()) {
	$matchrule = "Adef"; $result = $this->construct($matchrule, $matchrule, null);
	$_128 = NULL;
	do {
		$res_115 = $result;
		$pos_115 = $this->pos;
		$_119 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_119 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_119 = FALSE; break; }
			$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "tc" );
			}
			else { $_119 = FALSE; break; }
			$_119 = TRUE; break;
		}
		while(0);
		if( $_119 === TRUE ) { $_128 = TRUE; break; }
		$result = $res_115;
		$this->pos = $pos_115;
		$_126 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_126 = FALSE; break; }
			$res_125 = $result;
			$pos_125 = $this->pos;
			$_124 = NULL;
			do {
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_124 = FALSE; break; }
				$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "second" );
				}
				else { $_124 = FALSE; break; }
				$_124 = TRUE; break;
			}
			while(0);
			if( $_124 === FALSE) {
				$result = $res_125;
				$this->pos = $pos_125;
				unset( $res_125 );
				unset( $pos_125 );
			}
			$_126 = TRUE; break;
		}
		while(0);
		if( $_126 === TRUE ) { $_128 = TRUE; break; }
		$result = $res_115;
		$this->pos = $pos_115;
		$_128 = FALSE; break;
	}
	while(0);
	if( $_128 === TRUE ) { return $this->finalise($result); }
	if( $_128 === FALSE) { return FALSE; }
}


/* Adefs:		(Spaces "," Spaces adef:Adef)*  */
protected $match_Adefs_typestack = array('Adefs');
function match_Adefs ($stack = array()) {
	$matchrule = "Adefs"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_135 = $result;
		$pos_135 = $this->pos;
		$_134 = NULL;
		do {
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_134 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == ',') {
				$this->pos += 1;
				$result["text"] .= ',';
			}
			else { $_134 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_134 = FALSE; break; }
			$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adef" );
			}
			else { $_134 = FALSE; break; }
			$_134 = TRUE; break;
		}
		while(0);
		if( $_134 === FALSE) {
			$result = $res_135;
			$this->pos = $pos_135;
			unset( $res_135 );
			unset( $pos_135 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Literal:	quoted:Quoted | simple:/([^\s\.,:;\/]|\/(?![\/\*]))+/   */
protected $match_Literal_typestack = array('Literal');
function match_Literal ($stack = array()) {
	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
	$_139 = NULL;
	do {
		$res_136 = $result;
		$pos_136 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_139 = TRUE; break;
		}
		$result = $res_136;
		$this->pos = $pos_136;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\s\.,:;\/]|\/(?![\/\*]))+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_139 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_136;
		$this->pos = $pos_136;
		$_139 = FALSE; break;
	}
	while(0);
	if( $_139 === TRUE ) { return $this->finalise($result); }
	if( $_139 === FALSE) { return FALSE; }
}


/* Literal2:	quoted:Quoted | simple:/([^\.,:;\/]|\/(?![\/\*]))+/   */
protected $match_Literal2_typestack = array('Literal2');
function match_Literal2 ($stack = array()) {
	$matchrule = "Literal2"; $result = $this->construct($matchrule, $matchrule, null);
	$_144 = NULL;
	do {
		$res_141 = $result;
		$pos_141 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_144 = TRUE; break;
		}
		$result = $res_141;
		$this->pos = $pos_141;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\.,:;\/]|\/(?![\/\*]))+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_144 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_141;
		$this->pos = $pos_141;
		$_144 = FALSE; break;
	}
	while(0);
	if( $_144 === TRUE ) { return $this->finalise($result); }
	if( $_144 === FALSE) { return FALSE; }
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
		$res_153 = $result;
		$pos_153 = $this->pos;
		$_152 = NULL;
		do {
			$_150 = NULL;
			do {
				$res_147 = $result;
				$pos_147 = $this->pos;
				if (( $subres = $this->rx( '/ \s /' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$_150 = TRUE; break;
				}
				$result = $res_147;
				$this->pos = $pos_147;
				$matcher = 'match_'.'ClosedComment'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_150 = TRUE; break;
				}
				$result = $res_147;
				$this->pos = $pos_147;
				$_150 = FALSE; break;
			}
			while(0);
			if( $_150 === FALSE) { $_152 = FALSE; break; }
			$_152 = TRUE; break;
		}
		while(0);
		if( $_152 === FALSE) {
			$result = $res_153;
			$this->pos = $pos_153;
			unset( $res_153 );
			unset( $pos_153 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Quoted:		q:/["]/ quotedcontents:QuotedContents "$q" | q:/[']/ quotedcontents2:QuotedContents2 "$q"  */
protected $match_Quoted_typestack = array('Quoted');
function match_Quoted ($stack = array()) {
	$matchrule = "Quoted"; $result = $this->construct($matchrule, $matchrule, null);
	$_165 = NULL;
	do {
		$res_154 = $result;
		$pos_154 = $this->pos;
		$_158 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/["]/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_158 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents" );
			}
			else { $_158 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_158 = FALSE; break; }
			$_158 = TRUE; break;
		}
		while(0);
		if( $_158 === TRUE ) { $_165 = TRUE; break; }
		$result = $res_154;
		$this->pos = $pos_154;
		$_163 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/[\']/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_163 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents2" );
			}
			else { $_163 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_163 = FALSE; break; }
			$_163 = TRUE; break;
		}
		while(0);
		if( $_163 === TRUE ) { $_165 = TRUE; break; }
		$result = $res_154;
		$this->pos = $pos_154;
		$_165 = FALSE; break;
	}
	while(0);
	if( $_165 === TRUE ) { return $this->finalise($result); }
	if( $_165 === FALSE) { return FALSE; }
}


/* QuotedContents:	( /\\.|[^"]/ )*  */
protected $match_QuotedContents_typestack = array('QuotedContents');
function match_QuotedContents ($stack = array()) {
	$matchrule = "QuotedContents"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_169 = $result;
		$pos_169 = $this->pos;
		$_168 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^"]/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_168 = FALSE; break; }
			$_168 = TRUE; break;
		}
		while(0);
		if( $_168 === FALSE) {
			$result = $res_169;
			$this->pos = $pos_169;
			unset( $res_169 );
			unset( $pos_169 );
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
		$res_172 = $result;
		$pos_172 = $this->pos;
		$_171 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^\']/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_171 = FALSE; break; }
			$_171 = TRUE; break;
		}
		while(0);
		if( $_171 === FALSE) {
			$result = $res_172;
			$this->pos = $pos_172;
			unset( $res_172 );
			unset( $pos_172 );
			break;
		}
	}
	return $this->finalise($result);
}


/* TrailingComment: (l1:Commment1Line /.* / ) | lm:OpenCommmentMLine  */
protected $match_TrailingComment_typestack = array('TrailingComment');
function match_TrailingComment ($stack = array()) {
	$matchrule = "TrailingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_179 = NULL;
	do {
		$res_173 = $result;
		$pos_173 = $this->pos;
		$_176 = NULL;
		do {
			$matcher = 'match_'.'Commment1Line'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "l1" );
			}
			else { $_176 = FALSE; break; }
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_176 = FALSE; break; }
			$_176 = TRUE; break;
		}
		while(0);
		if( $_176 === TRUE ) { $_179 = TRUE; break; }
		$result = $res_173;
		$this->pos = $pos_173;
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "lm" );
			$_179 = TRUE; break;
		}
		$result = $res_173;
		$this->pos = $pos_173;
		$_179 = FALSE; break;
	}
	while(0);
	if( $_179 === TRUE ) { return $this->finalise($result); }
	if( $_179 === FALSE) { return FALSE; }
}


/* ClosingComment: cc:(/([^\*]|\*(?!\/))* /  "*" "/")  */
protected $match_ClosingComment_typestack = array('ClosingComment');
function match_ClosingComment ($stack = array()) {
	$matchrule = "ClosingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
	$_184 = NULL;
	do {
		if (( $subres = $this->rx( '/([^\*]|\*(?!\/))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_184 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_184 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '/') {
			$this->pos += 1;
			$result["text"] .= '/';
		}
		else { $_184 = FALSE; break; }
		$_184 = TRUE; break;
	}
	while(0);
	if( $_184 === TRUE ) {
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'cc' );
		return $this->finalise($result);
	}
	if( $_184 === FALSE) {
		$result = array_pop($stack);
		return FALSE;
	}
}


/* ClosingComment1: cc:(/.* /  "*" "/")  */
protected $match_ClosingComment1_typestack = array('ClosingComment1');
function match_ClosingComment1 ($stack = array()) {
	$matchrule = "ClosingComment1"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
	$_189 = NULL;
	do {
		if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_189 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_189 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '/') {
			$this->pos += 1;
			$result["text"] .= '/';
		}
		else { $_189 = FALSE; break; }
		$_189 = TRUE; break;
	}
	while(0);
	if( $_189 === TRUE ) {
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'cc' );
		return $this->finalise($result);
	}
	if( $_189 === FALSE) {
		$result = array_pop($stack);
		return FALSE;
	}
}


/* ClosedComment: OpenCommmentMLine ClosingComment  */
protected $match_ClosedComment_typestack = array('ClosedComment');
function match_ClosedComment ($stack = array()) {
	$matchrule = "ClosedComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_193 = NULL;
	do {
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_193 = FALSE; break; }
		$matcher = 'match_'.'ClosingComment'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_193 = FALSE; break; }
		$_193 = TRUE; break;
	}
	while(0);
	if( $_193 === TRUE ) { return $this->finalise($result); }
	if( $_193 === FALSE) { return FALSE; }
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
	$_198 = NULL;
	do {
		if (( $subres = $this->literal( '/*' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_198 = FALSE; break; }
		if (( $subres = $this->rx( '/([^\*]|\*(?![\/]))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_198 = FALSE; break; }
		$_198 = TRUE; break;
	}
	while(0);
	if( $_198 === TRUE ) { return $this->finalise($result); }
	if( $_198 === FALSE) { return FALSE; }
}


/* IndentedDot:	indent:Spaces (orphandot:/\.\s?/ trailingtext:/.* /)  */
protected $match_IndentedDot_typestack = array('IndentedDot');
function match_IndentedDot ($stack = array()) {
	$matchrule = "IndentedDot"; $result = $this->construct($matchrule, $matchrule, null);
	$_205 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_205 = FALSE; break; }
		$_203 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "orphandot" ); 
			if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'orphandot' );
			}
			else {
				$result = array_pop($stack);
				$_203 = FALSE; break;
			}
			$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'trailingtext' );
			}
			else {
				$result = array_pop($stack);
				$_203 = FALSE; break;
			}
			$_203 = TRUE; break;
		}
		while(0);
		if( $_203 === FALSE) { $_205 = FALSE; break; }
		$_205 = TRUE; break;
	}
	while(0);
	if( $_205 === TRUE ) { return $this->finalise($result); }
	if( $_205 === FALSE) { return FALSE; }
}




}

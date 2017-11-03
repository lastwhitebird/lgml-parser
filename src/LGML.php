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
								(
									(trailingsemicolon:";" (Spaces tc:TrailingComment)?)?
									|(trailingslash:"/" (Spaces tc:TrailingComment)?)?
								)
							|(trailingsemicolon:";" (Spaces tc:TrailingComment)?)
							|(trailingslash:"/" (Spaces tc:TrailingComment)?)
							|""
							) 
				)  */
protected $match_Node_typestack = array('Node');
function match_Node ($stack = array()) {
	$matchrule = "Node"; $result = $this->construct($matchrule, $matchrule, null);
	$_85 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_85 = FALSE; break; }
		$_83 = NULL;
		do {
			$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adef" );
			}
			else { $_83 = FALSE; break; }
			$matcher = 'match_'.'Adefs'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adefs" );
			}
			else { $_83 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_83 = FALSE; break; }
			$_81 = NULL;
			do {
				$_79 = NULL;
				do {
					$res_4 = $result;
					$pos_4 = $this->pos;
					$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "tc" );
						$_79 = TRUE; break;
					}
					$result = $res_4;
					$this->pos = $pos_4;
					$_77 = NULL;
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
						if( $_9 === TRUE ) { $_77 = TRUE; break; }
						$result = $res_6;
						$this->pos = $pos_6;
						$_75 = NULL;
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
							if( $_17 === TRUE ) { $_75 = TRUE; break; }
							$result = $res_11;
							$this->pos = $pos_11;
							$_73 = NULL;
							do {
								$_71 = NULL;
								do {
									$res_19 = $result;
									$pos_19 = $this->pos;
									$_48 = NULL;
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
											$_48 = FALSE; break;
										}
										$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
										$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
										if ($subres !== FALSE) {
											$this->store( $result, $subres );
										}
										else { $_48 = FALSE; break; }
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
										$_46 = NULL;
										do {
											$_44 = NULL;
											do {
												$res_29 = $result;
												$pos_29 = $this->pos;
												$res_36 = $result;
												$pos_36 = $this->pos;
												$_35 = NULL;
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
														$_35 = FALSE; break;
													}
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
														$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
														$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
														if ($subres !== FALSE) {
															$this->store( $result, $subres, "tc" );
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
													}
													$_35 = TRUE; break;
												}
												while(0);
												if( $_35 === TRUE ) { $_44 = TRUE; break; }
												if( $_35 === FALSE) {
													$result = $res_36;
													$this->pos = $pos_36;
													unset( $res_36 );
													unset( $pos_36 );
												}
												$result = $res_29;
												$this->pos = $pos_29;
												$res_43 = $result;
												$pos_43 = $this->pos;
												$_42 = NULL;
												do {
													$stack[] = $result; $result = $this->construct( $matchrule, "trailingslash" ); 
													if (substr($this->string,$this->pos,1) == '/') {
														$this->pos += 1;
														$result["text"] .= '/';
														$subres = $result; $result = array_pop($stack);
														$this->store( $result, $subres, 'trailingslash' );
													}
													else {
														$result = array_pop($stack);
														$_42 = FALSE; break;
													}
													$res_41 = $result;
													$pos_41 = $this->pos;
													$_40 = NULL;
													do {
														$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
														$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
														if ($subres !== FALSE) {
															$this->store( $result, $subres );
														}
														else { $_40 = FALSE; break; }
														$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
														$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
														if ($subres !== FALSE) {
															$this->store( $result, $subres, "tc" );
														}
														else { $_40 = FALSE; break; }
														$_40 = TRUE; break;
													}
													while(0);
													if( $_40 === FALSE) {
														$result = $res_41;
														$this->pos = $pos_41;
														unset( $res_41 );
														unset( $pos_41 );
													}
													$_42 = TRUE; break;
												}
												while(0);
												if( $_42 === TRUE ) { $_44 = TRUE; break; }
												if( $_42 === FALSE) {
													$result = $res_43;
													$this->pos = $pos_43;
													unset( $res_43 );
													unset( $pos_43 );
												}
												$result = $res_29;
												$this->pos = $pos_29;
												$_44 = FALSE; break;
											}
											while(0);
											if( $_44 === FALSE) { $_46 = FALSE; break; }
											$_46 = TRUE; break;
										}
										while(0);
										if( $_46 === FALSE) { $_48 = FALSE; break; }
										$_48 = TRUE; break;
									}
									while(0);
									if( $_48 === TRUE ) { $_71 = TRUE; break; }
									$result = $res_19;
									$this->pos = $pos_19;
									$_69 = NULL;
									do {
										$res_50 = $result;
										$pos_50 = $this->pos;
										$_56 = NULL;
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
												$_56 = FALSE; break;
											}
											$res_55 = $result;
											$pos_55 = $this->pos;
											$_54 = NULL;
											do {
												$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres );
												}
												else { $_54 = FALSE; break; }
												$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
												$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
												if ($subres !== FALSE) {
													$this->store( $result, $subres, "tc" );
												}
												else { $_54 = FALSE; break; }
												$_54 = TRUE; break;
											}
											while(0);
											if( $_54 === FALSE) {
												$result = $res_55;
												$this->pos = $pos_55;
												unset( $res_55 );
												unset( $pos_55 );
											}
											$_56 = TRUE; break;
										}
										while(0);
										if( $_56 === TRUE ) { $_69 = TRUE; break; }
										$result = $res_50;
										$this->pos = $pos_50;
										$_67 = NULL;
										do {
											$res_58 = $result;
											$pos_58 = $this->pos;
											$_64 = NULL;
											do {
												$stack[] = $result; $result = $this->construct( $matchrule, "trailingslash" ); 
												if (substr($this->string,$this->pos,1) == '/') {
													$this->pos += 1;
													$result["text"] .= '/';
													$subres = $result; $result = array_pop($stack);
													$this->store( $result, $subres, 'trailingslash' );
												}
												else {
													$result = array_pop($stack);
													$_64 = FALSE; break;
												}
												$res_63 = $result;
												$pos_63 = $this->pos;
												$_62 = NULL;
												do {
													$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
													$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
													if ($subres !== FALSE) {
														$this->store( $result, $subres );
													}
													else { $_62 = FALSE; break; }
													$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
													$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
													if ($subres !== FALSE) {
														$this->store( $result, $subres, "tc" );
													}
													else { $_62 = FALSE; break; }
													$_62 = TRUE; break;
												}
												while(0);
												if( $_62 === FALSE) {
													$result = $res_63;
													$this->pos = $pos_63;
													unset( $res_63 );
													unset( $pos_63 );
												}
												$_64 = TRUE; break;
											}
											while(0);
											if( $_64 === TRUE ) { $_67 = TRUE; break; }
											$result = $res_58;
											$this->pos = $pos_58;
											if (( $subres = $this->literal( '' ) ) !== FALSE) {
												$result["text"] .= $subres;
												$_67 = TRUE; break;
											}
											$result = $res_58;
											$this->pos = $pos_58;
											$_67 = FALSE; break;
										}
										while(0);
										if( $_67 === TRUE ) { $_69 = TRUE; break; }
										$result = $res_50;
										$this->pos = $pos_50;
										$_69 = FALSE; break;
									}
									while(0);
									if( $_69 === TRUE ) { $_71 = TRUE; break; }
									$result = $res_19;
									$this->pos = $pos_19;
									$_71 = FALSE; break;
								}
								while(0);
								if( $_71 === FALSE) { $_73 = FALSE; break; }
								$_73 = TRUE; break;
							}
							while(0);
							if( $_73 === TRUE ) { $_75 = TRUE; break; }
							$result = $res_11;
							$this->pos = $pos_11;
							$_75 = FALSE; break;
						}
						while(0);
						if( $_75 === TRUE ) { $_77 = TRUE; break; }
						$result = $res_6;
						$this->pos = $pos_6;
						$_77 = FALSE; break;
					}
					while(0);
					if( $_77 === TRUE ) { $_79 = TRUE; break; }
					$result = $res_4;
					$this->pos = $pos_4;
					$_79 = FALSE; break;
				}
				while(0);
				if( $_79 === FALSE) { $_81 = FALSE; break; }
				$_81 = TRUE; break;
			}
			while(0);
			if( $_81 === FALSE) { $_83 = FALSE; break; }
			$_83 = TRUE; break;
		}
		while(0);
		if( $_83 === FALSE) { $_85 = FALSE; break; }
		$_85 = TRUE; break;
	}
	while(0);
	if( $_85 === TRUE ) { return $this->finalise($result); }
	if( $_85 === FALSE) { return FALSE; }
}


/* Adef:		first:Literal Spaces &tc:TrailingComment | first:Literal (Spaces second:Literal2)?   */
protected $match_Adef_typestack = array('Adef');
function match_Adef ($stack = array()) {
	$matchrule = "Adef"; $result = $this->construct($matchrule, $matchrule, null);
	$_100 = NULL;
	do {
		$res_87 = $result;
		$pos_87 = $this->pos;
		$_91 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_91 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_91 = FALSE; break; }
			$matcher = 'match_'.'TrailingComment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "tc" );
			}
			else { $_91 = FALSE; break; }
			$_91 = TRUE; break;
		}
		while(0);
		if( $_91 === TRUE ) { $_100 = TRUE; break; }
		$result = $res_87;
		$this->pos = $pos_87;
		$_98 = NULL;
		do {
			$matcher = 'match_'.'Literal'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "first" );
			}
			else { $_98 = FALSE; break; }
			$res_97 = $result;
			$pos_97 = $this->pos;
			$_96 = NULL;
			do {
				$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_96 = FALSE; break; }
				$matcher = 'match_'.'Literal2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "second" );
				}
				else { $_96 = FALSE; break; }
				$_96 = TRUE; break;
			}
			while(0);
			if( $_96 === FALSE) {
				$result = $res_97;
				$this->pos = $pos_97;
				unset( $res_97 );
				unset( $pos_97 );
			}
			$_98 = TRUE; break;
		}
		while(0);
		if( $_98 === TRUE ) { $_100 = TRUE; break; }
		$result = $res_87;
		$this->pos = $pos_87;
		$_100 = FALSE; break;
	}
	while(0);
	if( $_100 === TRUE ) { return $this->finalise($result); }
	if( $_100 === FALSE) { return FALSE; }
}


/* Adefs:		(Spaces "," Spaces adef:Adef)*  */
protected $match_Adefs_typestack = array('Adefs');
function match_Adefs ($stack = array()) {
	$matchrule = "Adefs"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_107 = $result;
		$pos_107 = $this->pos;
		$_106 = NULL;
		do {
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_106 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == ',') {
				$this->pos += 1;
				$result["text"] .= ',';
			}
			else { $_106 = FALSE; break; }
			$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_106 = FALSE; break; }
			$matcher = 'match_'.'Adef'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "adef" );
			}
			else { $_106 = FALSE; break; }
			$_106 = TRUE; break;
		}
		while(0);
		if( $_106 === FALSE) {
			$result = $res_107;
			$this->pos = $pos_107;
			unset( $res_107 );
			unset( $pos_107 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Literal:	quoted:Quoted | simple:/([^\s\.,:;\/])+/   */
protected $match_Literal_typestack = array('Literal');
function match_Literal ($stack = array()) {
	$matchrule = "Literal"; $result = $this->construct($matchrule, $matchrule, null);
	$_111 = NULL;
	do {
		$res_108 = $result;
		$pos_108 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_111 = TRUE; break;
		}
		$result = $res_108;
		$this->pos = $pos_108;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\s\.,:;\/])+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_111 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_108;
		$this->pos = $pos_108;
		$_111 = FALSE; break;
	}
	while(0);
	if( $_111 === TRUE ) { return $this->finalise($result); }
	if( $_111 === FALSE) { return FALSE; }
}


/* Literal2:	quoted:Quoted | simple:/([^\.,:;\/])+/   */
protected $match_Literal2_typestack = array('Literal2');
function match_Literal2 ($stack = array()) {
	$matchrule = "Literal2"; $result = $this->construct($matchrule, $matchrule, null);
	$_116 = NULL;
	do {
		$res_113 = $result;
		$pos_113 = $this->pos;
		$matcher = 'match_'.'Quoted'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "quoted" );
			$_116 = TRUE; break;
		}
		$result = $res_113;
		$this->pos = $pos_113;
		$stack[] = $result; $result = $this->construct( $matchrule, "simple" ); 
		if (( $subres = $this->rx( '/([^\.,:;\/])+/' ) ) !== FALSE) {
			$result["text"] .= $subres;
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'simple' );
			$_116 = TRUE; break;
		}
		else { $result = array_pop($stack); }
		$result = $res_113;
		$this->pos = $pos_113;
		$_116 = FALSE; break;
	}
	while(0);
	if( $_116 === TRUE ) { return $this->finalise($result); }
	if( $_116 === FALSE) { return FALSE; }
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
		$res_125 = $result;
		$pos_125 = $this->pos;
		$_124 = NULL;
		do {
			$_122 = NULL;
			do {
				$res_119 = $result;
				$pos_119 = $this->pos;
				if (( $subres = $this->rx( '/ \s /' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$_122 = TRUE; break;
				}
				$result = $res_119;
				$this->pos = $pos_119;
				$matcher = 'match_'.'ClosedComment'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_122 = TRUE; break;
				}
				$result = $res_119;
				$this->pos = $pos_119;
				$_122 = FALSE; break;
			}
			while(0);
			if( $_122 === FALSE) { $_124 = FALSE; break; }
			$_124 = TRUE; break;
		}
		while(0);
		if( $_124 === FALSE) {
			$result = $res_125;
			$this->pos = $pos_125;
			unset( $res_125 );
			unset( $pos_125 );
			break;
		}
	}
	return $this->finalise($result);
}


/* Quoted:		q:/["]/ quotedcontents:QuotedContents "$q" | q:/[']/ quotedcontents2:QuotedContents2 "$q"  */
protected $match_Quoted_typestack = array('Quoted');
function match_Quoted ($stack = array()) {
	$matchrule = "Quoted"; $result = $this->construct($matchrule, $matchrule, null);
	$_137 = NULL;
	do {
		$res_126 = $result;
		$pos_126 = $this->pos;
		$_130 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/["]/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_130 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents" );
			}
			else { $_130 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_130 = FALSE; break; }
			$_130 = TRUE; break;
		}
		while(0);
		if( $_130 === TRUE ) { $_137 = TRUE; break; }
		$result = $res_126;
		$this->pos = $pos_126;
		$_135 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "q" ); 
			if (( $subres = $this->rx( '/[\']/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'q' );
			}
			else {
				$result = array_pop($stack);
				$_135 = FALSE; break;
			}
			$matcher = 'match_'.'QuotedContents2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "quotedcontents2" );
			}
			else { $_135 = FALSE; break; }
			if (( $subres = $this->literal( ''.$this->expression($result, $stack, 'q').'' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_135 = FALSE; break; }
			$_135 = TRUE; break;
		}
		while(0);
		if( $_135 === TRUE ) { $_137 = TRUE; break; }
		$result = $res_126;
		$this->pos = $pos_126;
		$_137 = FALSE; break;
	}
	while(0);
	if( $_137 === TRUE ) { return $this->finalise($result); }
	if( $_137 === FALSE) { return FALSE; }
}


/* QuotedContents:	( /\\.|[^"]/ )*  */
protected $match_QuotedContents_typestack = array('QuotedContents');
function match_QuotedContents ($stack = array()) {
	$matchrule = "QuotedContents"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_141 = $result;
		$pos_141 = $this->pos;
		$_140 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^"]/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_140 = FALSE; break; }
			$_140 = TRUE; break;
		}
		while(0);
		if( $_140 === FALSE) {
			$result = $res_141;
			$this->pos = $pos_141;
			unset( $res_141 );
			unset( $pos_141 );
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
		$res_144 = $result;
		$pos_144 = $this->pos;
		$_143 = NULL;
		do {
			if (( $subres = $this->rx( '/\\\\.|[^\']/' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_143 = FALSE; break; }
			$_143 = TRUE; break;
		}
		while(0);
		if( $_143 === FALSE) {
			$result = $res_144;
			$this->pos = $pos_144;
			unset( $res_144 );
			unset( $pos_144 );
			break;
		}
	}
	return $this->finalise($result);
}


/* TrailingComment: (l1:Commment1Line /.* / ) | lm:OpenCommmentMLine  */
protected $match_TrailingComment_typestack = array('TrailingComment');
function match_TrailingComment ($stack = array()) {
	$matchrule = "TrailingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_151 = NULL;
	do {
		$res_145 = $result;
		$pos_145 = $this->pos;
		$_148 = NULL;
		do {
			$matcher = 'match_'.'Commment1Line'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "l1" );
			}
			else { $_148 = FALSE; break; }
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_148 = FALSE; break; }
			$_148 = TRUE; break;
		}
		while(0);
		if( $_148 === TRUE ) { $_151 = TRUE; break; }
		$result = $res_145;
		$this->pos = $pos_145;
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "lm" );
			$_151 = TRUE; break;
		}
		$result = $res_145;
		$this->pos = $pos_145;
		$_151 = FALSE; break;
	}
	while(0);
	if( $_151 === TRUE ) { return $this->finalise($result); }
	if( $_151 === FALSE) { return FALSE; }
}


/* ClosingComment: cc:( "*" "/")  */
protected $match_ClosingComment_typestack = array('ClosingComment');
function match_ClosingComment ($stack = array()) {
	$matchrule = "ClosingComment"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "cc" ); 
	$_155 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_155 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '/') {
			$this->pos += 1;
			$result["text"] .= '/';
		}
		else { $_155 = FALSE; break; }
		$_155 = TRUE; break;
	}
	while(0);
	if( $_155 === TRUE ) {
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'cc' );
		return $this->finalise($result);
	}
	if( $_155 === FALSE) {
		$result = array_pop($stack);
		return FALSE;
	}
}


/* ClosedComment: OpenCommmentMLine ClosingComment  */
protected $match_ClosedComment_typestack = array('ClosedComment');
function match_ClosedComment ($stack = array()) {
	$matchrule = "ClosedComment"; $result = $this->construct($matchrule, $matchrule, null);
	$_159 = NULL;
	do {
		$matcher = 'match_'.'OpenCommmentMLine'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_159 = FALSE; break; }
		$matcher = 'match_'.'ClosingComment'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_159 = FALSE; break; }
		$_159 = TRUE; break;
	}
	while(0);
	if( $_159 === TRUE ) { return $this->finalise($result); }
	if( $_159 === FALSE) { return FALSE; }
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


/* OpenCommmentMLine: "/*" /([^\*]|\*(?![\/]))*$/   */
protected $match_OpenCommmentMLine_typestack = array('OpenCommmentMLine');
function match_OpenCommmentMLine ($stack = array()) {
	$matchrule = "OpenCommmentMLine"; $result = $this->construct($matchrule, $matchrule, null);
	$_164 = NULL;
	do {
		if (( $subres = $this->literal( '/*' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_164 = FALSE; break; }
		if (( $subres = $this->rx( '/([^\*]|\*(?![\/]))*$/' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_164 = FALSE; break; }
		$_164 = TRUE; break;
	}
	while(0);
	if( $_164 === TRUE ) { return $this->finalise($result); }
	if( $_164 === FALSE) { return FALSE; }
}


/* ClosingCommentMLine: /([^\*]|\*(?![\/]))* / cc:ClosingComment  */
protected $match_ClosingCommentMLine_typestack = array('ClosingCommentMLine');
function match_ClosingCommentMLine ($stack = array()) {
	$matchrule = "ClosingCommentMLine"; $result = $this->construct($matchrule, $matchrule, null);
	$_168 = NULL;
	do {
		if (( $subres = $this->rx( '/([^\*]|\*(?![\/]))* /' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_168 = FALSE; break; }
		$matcher = 'match_'.'ClosingComment'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "cc" );
		}
		else { $_168 = FALSE; break; }
		$_168 = TRUE; break;
	}
	while(0);
	if( $_168 === TRUE ) { return $this->finalise($result); }
	if( $_168 === FALSE) { return FALSE; }
}


/* IndentedDot:	indent:Spaces (orphandot:/\.\s?/ trailingtext:/.* /)  */
protected $match_IndentedDot_typestack = array('IndentedDot');
function match_IndentedDot ($stack = array()) {
	$matchrule = "IndentedDot"; $result = $this->construct($matchrule, $matchrule, null);
	$_175 = NULL;
	do {
		$matcher = 'match_'.'Spaces'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "indent" );
		}
		else { $_175 = FALSE; break; }
		$_173 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "orphandot" ); 
			if (( $subres = $this->rx( '/\.\s?/' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'orphandot' );
			}
			else {
				$result = array_pop($stack);
				$_173 = FALSE; break;
			}
			$stack[] = $result; $result = $this->construct( $matchrule, "trailingtext" ); 
			if (( $subres = $this->rx( '/.* /' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'trailingtext' );
			}
			else {
				$result = array_pop($stack);
				$_173 = FALSE; break;
			}
			$_173 = TRUE; break;
		}
		while(0);
		if( $_173 === FALSE) { $_175 = FALSE; break; }
		$_175 = TRUE; break;
	}
	while(0);
	if( $_175 === TRUE ) { return $this->finalise($result); }
	if( $_175 === FALSE) { return FALSE; }
}




}

<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getMainFieldsClass'][]='EXT:tcamanipulate/class.tcamanipulate_tceforms_procTCAtitle.php:user_tcamanipulate_tceforms_procTCAtitle';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postUserLookUp'][]='EXT:tcamanipulate/class.tcamanipulate_userauth_TCApostproc.php:user_tcamanipulate_userauth_TCApostproc->processTCAtitles';
?>

<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

if (TYPO3_MODE=="BE") require_once(t3lib_extMgm::extPath('tcamanipulate').'class.tcamanipulate_userauth_TCApostproc.php');
?>
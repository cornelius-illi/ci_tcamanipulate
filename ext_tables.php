<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

if (TYPO3_MODE=="BE") {
	$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);
	require_once($extPath.'class.tcamanipulate_userauth_TCApostproc.php');
}
?>
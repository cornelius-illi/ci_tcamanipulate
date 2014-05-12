<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Stig Nørgaard Færch (stig@altforintet.dk)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
* Class with methods called as hooks from TCE Forms
*
* @author Stig Nørgaard Færch <stig@altforintet.dk>
*/

require_once(PATH_t3lib.'class.t3lib_befunc.php');

class user_tcamanipulate_tceforms_procTCAtitle {

	 /*
	 * @param	string		$tablename: Name of the current table
	 * @param	string		$table: The table of the current record
	 * @param	string		$id: The current record UID
	 * @return	void		Nothing returned. The fieldArray is directly changed, as it is passed by reference
	 */
	function getMainFields_preProcess($tablename, $table, $id) {
		global $TCA;
		if (is_object($GLOBALS['BE_USER']) && $TCA) {
			$modTSconfig=t3lib_BEfunc::getModTSconfig($table['pid'],'tx_tcamanipulate.renameFields'); //Gets the TSconfig
			//Rename many fields
			if(isset($modTSconfig['properties'][$tablename])) {
				foreach($TCA[$tablename]['columns'] as $fieldname=>$fieldarray){
					$TCA[$tablename]['columns'][$fieldname]['label'] = $modTSconfig['properties'][$tablename].strrchr($TCA[$tablename]['columns'][$fieldname]['label'],'.');
				}
			}
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcamanipulate/class.tcamanipulate_tceforms_procTCAtitle.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcamanipulate/class.tcamanipulate_tceforms_procTCAtitle.php']);
}

?>
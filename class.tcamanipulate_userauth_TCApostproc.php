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

class user_tcamanipulate_userauth_TCApostproc {

	 /*
	 * @return	void		Nothing returned.
	 */
	function processTCAtitles(&$params, &$reference) {
		global $TCA;
		if (is_object($GLOBALS['BE_USER']) && $TCA) {
			$pageid=t3lib_div::_GP('id');
			if (!$pageid) {
				$editconf = t3lib_div::_GP('edit');
				//IF TCEFORM
				if (is_array($editconf))	{
					foreach($editconf as $table=>$uidvalue){
						if(is_array($uidvalue)) {
							if ((current($uidvalue)=='new' AND key($uidvalue)>0) OR $table=='pages'){
								$pageid = key($uidvalue);
							//Doesn't seem to be necessary:
							//elseif((current($uidvalue)=='new' AND key($uidvalue)<0) OR current($uidvalue)=='edit')
							} else {
								$recordArr = t3lib_BEfunc::getRecord($table,intval(abs(key($uidvalue))),'pid');
								$pageid = $recordArr['pid'];
							}
						}
					}
				} else {
					//IF IRRE
					$ajax = t3lib_div::_GP('ajax');
					if (is_array($ajax)) {
						ereg('^data\[([0-9]+)\]',$ajax[1],$matches);
						$pageid = $matches[1];
					}
				}
			}
			if(intval($pageid)) {
				$includeLibs=t3lib_BEfunc::getModTSconfig($pageid,'tx_tcamanipulate.includeLibs'); //Gets the TSconfig
				if (is_array($includeLibs['properties'])) {
					foreach($includeLibs['properties'] as $libkey=>$libpath) {
						$filepath=t3lib_div::getFileAbsFileName($libpath);
						if (is_file($filepath)) include_once($filepath);
					}
				}
				
				$modTSconfig=t3lib_BEfunc::getModTSconfig($pageid,'TCA'); //Gets the TSconfig
				if (is_array($modTSconfig)) {
					if (isset($modTSconfig['properties'])) {
						unset($modTSconfig['properties']['includeLibs'],$modTSconfig['properties']['renameFields']);
						$newTCA = $this->cleanKeys($modTSconfig['properties']);
					}
					if (is_array($newTCA)) {
						foreach($newTCA as $table=>$value){
							if (!is_array($modTSconfig[$table]['columns']) OR !is_array($modTSconfig[$table])) {
								t3lib_div::loadTCA($table);
							}
						}
						$GLOBALS['TCA']=t3lib_div::array_merge_recursive_overrule($GLOBALS['TCA'],(is_array($newTCA)?$newTCA:array()));
					}
				}
			}
		}
	}
	
	function cleanKeys($array){
		if(!is_array($array)) return $array;

		$new_arr = array();
		foreach ($array as $key=>$value){
			$new_arr[str_replace('.','',$key)] = $this->cleanKeys($value);
		}
		return $new_arr;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcamanipulate/class.tcamanipulate_userauth_TCApostproc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcamanipulate/class.tcamanipulate_userauth_TCApostproc.php']);
}

?>
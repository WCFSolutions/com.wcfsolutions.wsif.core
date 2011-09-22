<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
// delete deprecated files
$deprecatedFiles = array(
	'acp/wsifCoreInstall.php',
	'images/wsif-header-logo.png'
);

$sql = "DELETE FROM	wcf".WCF_N."_package_installation_file_log
	WHERE		filename IN ('".implode("','", array_map('escapeString', $deprecatedFiles))."')
			AND packageID = ".$this->installation->getPackageID();
WCF::getDB()->sendQuery($sql);

foreach ($deprecatedFiles as $file) {
	@unlink(RELATIVE_WCF_DIR.$this->installation->getPackage()->getDir().$file);
}
?>
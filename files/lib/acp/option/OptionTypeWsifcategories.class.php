<?php
// wsif imports
require_once(WSIF_DIR.'lib/data/category/Category.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/option/OptionType.class.php');

/**
 * OptionTypeSelect is an implementation of OptionType for a category select.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2010 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsif.core
 * @subpackage	acp.option
 * @category	Community Framework
 */
class OptionTypeWsifcategories implements OptionType {	
	/**
	 * @see OptionType::getFormElement()
	 */
	public function getFormElement(&$optionData) {
		if (!isset($optionData['optionValue'])) {
			if (isset($optionData['defaultValue'])) $optionData['optionValue'] = explode(",", $optionData['defaultValue']);
			else $optionData['optionValue'] = array();
		}
		else if (!is_array($optionData['optionValue'])) {
			$optionData['optionValue'] = explode(",", $optionData['optionValue']);
		}
		
		WCF::getTPL()->assign(array(
			'optionData' => $optionData,
			'options' => Category::getCategorySelect(array())
		));
		return WCF::getTPL()->fetch('optionTypeMultiselect');
	}
	
	/**
	 * @see OptionType::validate()
	 */
	public function validate($optionData, $newValue) {
		if (!is_array($newValue)) $newValue = array();
		$options = Category::getCategorySelect(array());
		foreach ($newValue as $value) {
			if (!isset($options[$value])) throw new UserInputException($optionData['optionName'], 'validationFailed');
		}
	}
	
	/**
	 * @see OptionType::getData()
	 */
	public function getData($optionData, $newValue) {
		if (!is_array($newValue)) $newValue = array();
		return implode(',', $newValue);
	}
}
?>
<?PHP
/**
 * patTemplate HighlightPHP filter
 *
 * $Id: HighlightPhp.php 435 2008-02-26 02:15:29Z s.moffatt@toowoomba.qld.gov.au $
 *
 * Highlights PHP code in the output.
 *
 * @package		patTemplate
 * @subpackage	Filters
 * @author		Stephan Schmidt <schst@php.net>
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * patTemplate HighlightPHP filter
 *
 * $Id: HighlightPhp.php 435 2008-02-26 02:15:29Z s.moffatt@toowoomba.qld.gov.au $
 *
 * Highlights PHP code in the output.
 *
 * @package		patTemplate
 * @subpackage	Filters
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_OutputFilter_HighlightPhp extends patTemplate_OutputFilter
{
	/**
	* filter name
	*
	* @access	protected
	* @abstract
	* @var	string
	*/
	var	$_name	=	'HighlightPhp';

	/**
	* remove all whitespace from the output
	*
	* @access	public
	* @param	string		data
	* @return	string		data without whitespace
	*/
	function apply( $data )
	{
		return highlight_string($data, true);
	}
}
?>

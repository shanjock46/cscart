<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/


define('TWG_DEFAULT_DATA_FORMAT', 'json');
define('TWG_DEFAULT_API_VERSION', '2.0');

/*
 Twigmo requests response
 collect data and return it as doc
 also include methods to parse sent data into array
 */
class ApiData
{
	const CHARSET = 'utf-8';
	
	private $api_version = TWG_DEFAULT_API_VERSION;
	private $format = TWG_DEFAULT_DATA_FORMAT;
	private $api; // api object with data 
	private $callback; // callback function name
	
	function __construct($api_version = TWG_DEFAULT_API_VERSION, $format = TWG_DEFAULT_DATA_FORMAT)
	{
		$this->api_version = $api_version;

		if ($this->api_version == '2.0') {
			$this->api = new TwgApiv2();

		} else {
			$this->api = new TwgApi();

		}
		$this->format = $format;
	}

	function addError($code, $message)
	{
		$this->api->addError($code, $message);
	}
	
	function setMeta($value, $name)
	{
		$this->api->setMeta($value, $name);
	}

	function getMeta($name = '')
	{
		return $this->api->getMeta($name);
	}

	function setData($data, $object_name = '')
	{
		$this->api->setData($data, $object_name);
	}

	function setCallback($value)
	{
		$this->callback = $value;
		$this->format = 'jsonp';
	}

	function getData()
	{
		return $this->api->getData();
	}

	function getErrors()
	{
		return $this->api->getErrors();
	}

	function setResponseList($list)
	{
		return $this->api->setResponseList($list);
	}

	function parseResponse($doc, $format = TWG_DEFAULT_DATA_FORMAT)
	{
		return $this->api->parseResponse($doc, $format);
	}

	function getAsDoc($format = TWG_DEFAULT_DATA_FORMAT, $xml_root_node = 'data')
	{
		$result = $this->api->getResponseData($xml_root_node);
		
		return self::applyFormat($result, $format, $xml_root_node);
	}

	function applyFormat($doc, $format = TWG_DEFAULT_DATA_FORMAT, $xml_root_node = '')
	{
		if ($format == 'xml') {
			return self::getAsXML($doc, $xml_root_node);

		} elseif ($format == 'json') {
			return self::getAsJSON($doc);

		} elseif ($format == 'jsonp') {
			// jsonp format
			if (!empty($this->callback)) {
				$result = self::getAsJSON($doc);
				return $this->callback . '(' . $result . ');';
			}

		}

		// unknown format return nothing
		return '';
	}

	/*
	 * Parse Api doc (json or xml) to array 
	 */
	static function parseDocument($data, $format = TWG_DEFAULT_DATA_FORMAT) 
	{
		if ($format == 'xml') {
			$result = @simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
			return self::getObjectAsArray($result);
		} elseif ($format == 'jsonp') {
			if (preg_match('/[^\(.]*\((.*)\).*/', $data, $matches)) {
				$result = $matches[1];
				return (array) fn_from_json($result, true);
			}
			return (array) fn_from_json($data, true);
		} elseif ($format == 'json') {
			return (array) fn_from_json($data, true);
		}

		return false;
	}

	static function getObjectAsArray($object)
	{
		if (empty($object)) {
			return (string) $object;
		}

		if (!is_array($object)) {
			$check_object = (array) $object;
			if (isset($check_object[0])) {
				return trim($check_object[0]);
			}
		} else {
			$check_object = $object;
		}
		
		$result = array();	
	    foreach ($check_object as $key => $value )
    	{
           	$result[$key] = self::getObjectAsArray($value);
    	}

		return $result;
	}

	static function getAsJSON($data)
	{
		return fn_to_json($data);
	}

	static function getAsXML($data, $xml_root_node = 'data', $charset = self::CHARSET)
	{
		$xml = simplexml_load_string("<?xml version='1.0' encoding='" . $charset . "'?><$xml_root_node />");
		self::arrayToXML($data, $xml);
  		return $xml->asXML();
	}

	static function arrayToXML($data, &$xml, $charset = self::CHARSET)
	{
		if (empty($data) || !is_array($data)) {
			return '';
		}

		foreach($data as $key => $value) {
			if (is_numeric($key)) {
				$key = "node_". (string) $key;
			}
 
			$key = preg_replace('/[^a-z_0-9]/i', '', $key);
 
			if (is_array($value)) {
				$is_object_list = true;
				foreach ($value as $sub_key => $sub_value) {
					if (!is_numeric($sub_key)) {
						$is_object_list = false;
					}
				}
				// The sub values are the objects with properties
				if ($is_object_list) {
					foreach ($value as $sub_key => $sub_value) {
						if (is_array($sub_value)) {
							$node = $xml->addChild($key);
							self::arrayToXml($sub_value, $node);
						} else {
							self::addXMLChild($xml, $key, $sub_value, $charset);
						}
					}
				} else {
					$node = $xml->addChild($key);
					self::arrayToXml($value, $node);
				}
			} else {
				self::addXMLChild($xml, $key, $value, $charset);
			}
 		}

 		return $xml;
	}
	
	static function addXMLChild(&$xml, $key, $value, $charset)
	{
		if (is_numeric($value) || strlen($value) <= 1) {
			$xml->addChild($key, $value);
		} else {
	    	$node = $xml->addChild($key); 
    		$node = dom_import_simplexml($node);
    		$no = $node->ownerDocument;
    		$node->appendChild($no->createCDATASection($value));
  		}

		return true;
	}

	static function getObjects($response_data)
	{
		if (is_array($response_data)) {
			$field_names = array_keys($response_data);
			if (is_numeric(current($field_names))) {
				return $response_data;
			}
		}
		return array($response_data);
	}

	/*
	 * copypaste from checkout.php controller if ($mode == 'checkout' || $mode == 'summary')
	 */
	function addPaymentNotifications()
	{
		if (empty($_REQUEST['action']) or empty($_REQUEST['object']) or $_REQUEST['action'] != 'get' or $_REQUEST['object'] != 'errors') {
			return;
		}
		$cart = &$_SESSION['cart'];
		if (!empty($cart['failed_order_id']) || !empty($cart['processed_order_id'])) {
			$_ids = !empty($cart['failed_order_id']) ? $cart['failed_order_id'] : $cart['processed_order_id'];
			$_order_id = reset($_ids);
			$_payment_info = db_get_field("SELECT data FROM ?:order_data WHERE order_id = ?i AND type = 'P'", $_order_id);
			if (!empty($_payment_info)) {
				$_payment_info = unserialize(fn_decrypt_text($_payment_info));
			}

			if (!empty($cart['failed_order_id'])) {
				$_msg = !empty($_payment_info['reason_text']) ? $_payment_info['reason_text'] : '';
				$_msg .= empty($_msg) ? fn_get_lang_var('text_order_placed_error') : '';
				fn_set_notification('O', '', $_msg);
				$cart['processed_order_id'] = $cart['failed_order_id'];
				unset($cart['failed_order_id']);
			}
		}
	}

	/*
	 * functions to set and return response
	 */
	function returnResponse($xml_root_node = 'data')
	{
		$this->addPaymentNotifications();
		$notifications = fn_get_notifications();
		// Clear all the user notifications
		$_SESSION['notifications'] = array();
		$this->setMeta(empty($notifications) ? array() : array_values($notifications), 'notifications');
		$this->setMeta(Registry::get('addons.twigmo.access_id'), 'access_id');
		$this->setMeta(TWIGMO_VERSION, 'twigmo_version');
		$this->setMeta(PRODUCT_VERSION, 'cart_version');
		$this->setMeta(PRODUCT_TYPE, 'cart_edition');
		$doc = $this->getAsDoc($this->format, $xml_root_node);

		self::showResponse($doc, $this->format);
	}

	/*
	 * output response doc and exit
	 */
	static function showResponse($response = '', $format = TWG_DEFAULT_DATA_FORMAT)
	{
		if ($format == 'xml') {
			$content_type = 'Content-type: application/xml; charset=' . self::CHARSET;
		} elseif ($format == 'jsonp') {
			$content_type = 'Content-type: application/x-javascript; charset=' . self::CHARSET;
		} else {
			$content_type = 'Content-type: application/json; charset=' . self::CHARSET;
		}

		header($content_type);
		echo $response;
		exit;
	}

}

?>

<?php

class Bwork_Helper_BaseUrl {

	private $defaultBaseUrl;

	public function __construct() {
		$config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');

		$this->defaultBaseUrl = $config->get('sub_url');
	}

	public function baseUrl($url = null, $ssl = false) {
		return ($ssl === true? 'https://' . $_SERVER['SERVER_NAME']:'').$this->defaultBaseUrl.($url !== null? $url:'');
	}

}
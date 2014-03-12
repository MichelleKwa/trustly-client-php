<?php

class Trustly_Data_JSONRPCResponse extends Trustly_Data_Response {

	public function __construct($response_body, $curl) {
		parent::__construct($response_body, $curl);

		$version = (string)$this->get('version');
		if($version !== '1.1') {
			throw new Trustly_JSONRPCVersionException("JSON RPC Version $version is not supported. " . json_encode($this->payload));
		}

		if($this->isError()) {
			$this->response_result = $this->response_result['error'];
		}
	}

	public function getErrorCode() {
		if($this->isError() && isset($this->result['data']['code'])) {
			return $this->result['data']['code'];
		}
		return NULL;
	}

	public function getErrorMessage() {
		if($this->isError() && isset($this->result['data']['message'])) {
			return $this->result['data']['message'];
		}
		return NULL;
	}
}

?>
<?php

/**
*	Copyright (C) 2016 inviPay.com
*	
*	http://www.invipay.com
*
*	@author Kuba Pilecki (kpilecki@invipay.com)
* 	@version 1.0.4
*
*	Redistribution and use in source and binary forms, with or
*	without modification, are permitted provided that the following
*	conditions are met: Redistributions of source code must retain the
*	above copyright notice, this list of conditions and the following
*	disclaimer. Redistributions in binary form must reproduce the above
*	copyright notice, this list of conditions and the following disclaimer
*	in the documentation and/or other materials provided with the
*	distribution.
*	
*	THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED
*	WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
*	MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN
*	NO EVENT SHALL CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
*	INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
*	BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
*	OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
*	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
*	TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
*	USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
*	DAMAGE.
*/

require_once(dirname(__FILE__) ."/../exceptions/ApiOperationException.class.php");
require_once(dirname(__FILE__) ."/../exceptions/AccessFromIpDeniedException.class.php");
require_once(dirname(__FILE__) ."/../exceptions/AuthenticationException.class.php");
require_once(dirname(__FILE__) ."/../exceptions/SignatureException.class.php");
require_once(dirname(__FILE__) ."/../exceptions/ValidationException.class.php");
require_once(dirname(__FILE__) ."/../exceptions/TransactionContractorException.class.php");
require_once(dirname(__FILE__) ."/../exceptions/ObjectNotFoundException.class.php");

abstract class AbstractRestApiClient
{
    const HEADER_APIKEY_KEY = "X-InviPay-ApiKey";
    const HEADER_SIGNATURE_KEY = "X-InviPay-Signature";
    const SIGNING_ALGORHITM_NAME = "sha256";

	protected $baseUrl;
	protected $apiKey;
	protected $signatureKey;

	private $knownExceptions = array('AccessFromIpDeniedException', 'AuthenticationException', 'SignatureException', 'ValidationException', 'TransactionContractorException', 'ObjectNotFoundException');
	
	abstract protected function getServiceAddress();

	public function __construct($baseUrl, $apiKey, $signatureKey)
	{
		$this->baseUrl = $baseUrl;
		$this->apiKey = $apiKey;
		$this->signatureKey = $signatureKey;
	}

	public function __call_ws_action($actionPath, $arguments, $httpMethod, $outputType, $outputIsArray = false)
	{
			$ch = curl_init();

			$methodAddress = $this->baseUrl.$this->getServiceAddress().$actionPath;

			$headers = array( 
			            "Content-type: application/json;charset=\"utf-8\"", 
			            "Accept: application/json,application/octet-stream", 
			            "Cache-Control: no-cache", 
			            "Pragma: no-cache",
			            AbstractRestApiClient::HEADER_APIKEY_KEY . ": " . $this->apiKey,
			        );

			$queryString = '';

			if ($httpMethod == 'GET')
			{
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				$this->__appendToQueryString($queryString, $arguments !== null ? http_build_query($arguments) : null);
			}
			else if ($httpMethod == 'POST')
			{
				curl_setopt($ch, CURLOPT_POST, true);
				
				if ($arguments != null)
				{
					$postBody = json_encode($this->__toArray($arguments));
					$bodyHash = $this->__calculateBodyHash($postBody);
					array_push($headers, AbstractRestApiClient::HEADER_SIGNATURE_KEY . ": " . $bodyHash);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
				}
			}
			else
			{
				return null;
			}

			$methodAddress .= $queryString;

			curl_setopt($ch, CURLOPT_URL, $methodAddress);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			$response = curl_exec($ch);
			$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			curl_close($ch);

			$header = trim(substr($response, 0, $header_size));
			$body = trim(substr($response, $header_size));

			//$this->__checkResponseHash($header, $body);

			$output = $this->__createResponseObject($status, $body, $outputType, $outputIsArray);

			if (is_subclass_of($output, 'ApiOperationException') == false) {
				$this->__checkResponseHash($header, $body);
			}

			return $output;
	}

	protected function __checkResponseHash($header, $body)
	{
		if ($body === null){ return; }

		$signature = null;
		$calculatedSignature = null;

		if ($header !== null)
		{
			foreach (explode("\n", $header) as $line)
			{
				$line = trim($line);
				$lineArray = explode(':', $line);
				if (count($lineArray) == 2)
				{
					$key = trim($lineArray[0]);
					$value = trim($lineArray[1]);

					if ($key === AbstractRestApiClient::HEADER_SIGNATURE_KEY)
					{
						$signature = $value;
						break;
					}
				}
			}
		}

		if ($signature !== null)
		{
			$calculatedSignature = $this->__calculateBodyHash($body);
			if ($signature == $calculatedSignature)
			{
				return;
			}
		}

		throw new SignatureException("Wrong response signature! Response data was either manipulated between server and client or server you've contacted isn't InviPay server!", array('received_signature' => $signature, 'proper_signature' => $calculatedSignature, 'message_body' => $body));
	}

	protected function __calculateBodyHash($body)
	{
		$output = hash(AbstractRestApiClient::SIGNING_ALGORHITM_NAME, $body.$this->signatureKey);
		return $output;
	}

	protected function __appendToQueryString(&$queryString, $newData)
	{
		if ($newData !== null)
		{
			if ($queryString === null || $queryString == ''){ $queryString = '?'; }
			$queryString .= $queryString == '?' ? $newData : '&'.$newData;
		}
	}

	protected function __createResponseObject($status, $response, $outputType, $outputIsArray)
	{
		if ($status == '200')
		{
			$data = json_decode($response, true);
			return $data === null ? $response : $this->__mapArrayToObject($data, $outputType, $outputIsArray);
		}
		else if ($status == '204'){ return null; }
		else
		{
			$data = json_decode($response, true);
			if ($data !== null && is_array($data) && array_key_exists('error', $data) && $data['error'] == true)
			{
				$errorType = $data['type'];
				$errorMessage = array_key_exists('message', $data) ? $data['message'] : null;
				$errorData = array_key_exists('data', $data) ? $data['data'] : null;
				
				if (in_array($errorType, $this->knownExceptions))
				{
					throw new $errorType($errorMessage, $errorData);
				}
				else
				{
					throw new ApiOperationException($errorType, $errorMessage, $errorData);
					
				}
			}
		}
		
		throw new ApiOperationException(null, "Unknown API error, HTTP status: " . $status, $response);
	}

	protected function __mapArrayToObject($response, $outputType, $outputIsArray)
	{
		if ($outputType === null){ return $response; }
		else if (is_callable($outputType)){ return $outputType($response); }
		else if (is_string($outputType) && is_array($response))
		{
			//var_dump($response);

			if (!$outputIsArray){ $response = array($response); }

			$rclass = new ReflectionClass($outputType);
			$output = array();

			foreach ($response as $item)
			{
				$mapped = new $outputType();

				foreach ($item as $property => $value)
				{
					try
					{
						$rmethodName = 'set'.ucfirst($property);
						$rmethod = $rclass->getMethod($rmethodName);

						if ($rmethod !== null && $rmethod->isPublic())
						{
							$rparams = $rmethod->getParameters();
							$rparamsCount = count($rparams);
							if ($rparams !== null && $rparamsCount > 0)
							{
								$rparamValue = $value;

								if ($rparams[0] != null)
								{
									if ($rparams[0]->isArray())
									{
										if ($rparamsCount > 1)
										{
											$rparamValue = $this->__mapArrayToObject($rparamValue, $rparams[1]->getClass()->name, true);
										}
										else
										{
											continue;
										}
									}
									else if ($rparams[0]->getClass() !== null)
									{
										$rparamValue = $this->__mapArrayToObject($rparamValue, $rparams[0]->getClass()->name, false);
									}
								}

								$mapped->$rmethodName($rparamValue);
							}
						}
					}
					catch (Exception $ex)
					{
					}
				}

				$output[] = $mapped;
			}

			return $outputIsArray ? $output : $output[0];
		}
		
		return $response;
	}

	protected function __xmlToArray($xmlString)
	{
		$xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
		$json = json_encode($xml);
		$array = json_decode($json, true);

		return $array;
	}

	protected function __toArray($object)
	{
		$output = array();

		$rclass = new ReflectionClass($object);

		foreach ($rclass->getMethods(ReflectionMethod::IS_PUBLIC) as $rmethod)
		{
			if ($rmethod !== null)
			{
				$propertyName = $rmethod->name;
				if (strrpos($propertyName, 'get', -strlen($propertyName)) !== FALSE)
				{
					$propertyNameKey = substr($propertyName, 3);
					$propertyNameKey = $this->__countLowerCaseChars($propertyNameKey) == 0 ? $propertyNameKey : lcfirst($propertyNameKey);
					$propertyValue = $object->$propertyName();

					if (is_object($propertyValue))
					{
						$propertyValue = $this->__toArray($propertyValue);
					}

					$output[$propertyNameKey] = $propertyValue;
				}
			}
		}

		return $output;
	}

	protected function __countLowerCaseChars($input)
	{
		$match = array();
		preg_match_all('/[a-z]/', $input, $match);
		return count($match[0]);
	}
}
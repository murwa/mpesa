<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 6:21 AM
 */

namespace Mxgel\MPesa\Requests;

//
use Mxgel\MPesa\Auth\Auth;
use Mxgel\MPesa\Certificates\Security;
use Mxgel\MPesa\Contracts\CommandsContract;
use Mxgel\MPesa\Contracts\RequestContract;
use Mxgel\MPesa\Exceptions\SafaricomException;
use Mxgel\MPesa\Model;
use Mxgel\MPesa\Responses\Response;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request as Psr7Request;

/**
 * Class Request
 *
 * @package Mxgel\MPesa\Requests
 */
abstract class Request extends Model implements CommandsContract, RequestContract
{
    /**
     * @var string
     */
    protected $method = 'post';
    /**
     * @var string
     *
     * Validation URL for the client.
     */
    protected $validationURL;
    /**
     * @var string
     *
     * Confirmation URL for the client.
     */
    protected $confirmationURL;
    /**
     * @var string
     *
     * Default response type for timeout.
     */
    protected $responseType = 'Cancelled';
    /**
     * @var string
     *
     * The short code of the organization.
     */
    protected $shortCode;
    /**
     * @var string
     *
     * Unique command for each transaction type.
     */
    protected $commandID;
    /**
     * @var float
     *
     * The amount been transacted.
     */
    protected $amount;
    /**
     * @var int
     *
     * Msisdn (phone number) sending the transaction, start with country code without the plus(+) sign.
     */
    protected $Msisdn;
    /**
     * @var string
     *
     * Bill Reference Number (Optional).
     */
    protected $billRefNumber = null;
    /**
     * @var string
     *
     * Base64 encoded string of the \Mxgel\MPesa\Requests\Request short code and password, which is encrypted using
     * M-Pesa public key and validates the transaction on M-Pesa Core system.
     */
    protected $securityCredential;

    /**
     * @var int
     */
    protected $partyA;
    /**
     * @var int
     */
    protected $partyB;
    /**
     * @var string
     */
    protected $remarks;
    /**
     * @var string
     */
    protected $queueTimeOutURL;
    /**
     * @var string
     */
    protected $resultURL;
    /**
     * @var string
     *
     * This is the credential/username used to authenticate the transaction request.
     */
    protected $initiatorName;
    /**
     * @var string
     */
    protected $occasion;
    /**
     * @var string
     *
     * This is the credential/username used to authenticate the transaction request.
     */
    protected $initiator;
    /**
     * @var int
     */
    protected $senderIdentifierType;
    /**
     * @var int
     *
     * This is a misspelling, correct. Saf prefers it this way, suckers!
     * Wasted my whole day, pussies.
     */
    protected $recieverIdentifierType;

    /**
     * @var string
     */
    protected $accountReference;
    /**
     * @var int
     */
    protected $phoneNumber;
    /**
     * @var string
     */
    protected $callBackURL;
    /**
     * @var string
     */
    protected $transactionDesc;
    /**
     * @var int
     */
    protected $businessShortCode;

    /**
     * @var int
     */
    protected $identifierType;

    /**
     * @var string
     */
    protected $transactionID;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $resultRouteName;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Request constructor.
     *
     * @param null $content
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->setAccountReference(self::generateReferenceNumber());
    }


    /**
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * @return null|string
     */
    public function getBillRefNumber()
    {
        return $this->billRefNumber ?: $this->setBillRefNumber()->getBillRefNumber();
    }

    /**
     * @return int
     */
    public function getMsisdn()
    {
        return $this->Msisdn;
    }

    /**
     * @param int $Msisdn
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setMsisdn($Msisdn)
    {
        $this->Msisdn = $Msisdn;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $shortCode
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * @param string $billRefNumber
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setBillRefNumber($billRefNumber = null)
    {
        $this->billRefNumber = $billRefNumber ?: self::generateReferenceNumber();

        return $this;
    }

    /**
     * @return string
     */
    public function getCommandID()
    {
        return $this->commandID;
    }

    /**
     * @return string
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * @return string
     */
    public function getConfirmationURL()
    {
        return $this->confirmationURL;
    }

    /**
     * @return string
     */
    public function getValidationURL()
    {
        return $this->validationURL;
    }

    /**
     * @param string $confirmationURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setConfirmationURL($confirmationURL)
    {
        $this->confirmationURL = $confirmationURL;

        return $this;
    }

    /**
     * @param string $validationURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setValidationURL($validationURL)
    {
        $this->validationURL = $validationURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultURL()
    {
        return $this->resultURL;
    }

    /**
     * @param string $resultURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setResultURL($resultURL)
    {
        $this->resultURL = $resultURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getQueueTimeOutURL()
    {
        return $this->queueTimeOutURL;
    }

    /**
     * @param string $queueTimeOutURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setQueueTimeOutURL($queueTimeOutURL)
    {
        $this->queueTimeOutURL = $queueTimeOutURL;

        return $this;
    }

    /**
     * @param string $remarks
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @return int
     */
    public function getPartyB()
    {
        return $this->partyB;
    }

    /**
     * @param int $partyB
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setPartyB($partyB)
    {
        $this->partyB = $partyB;

        return $this;
    }

    /**
     * @return int
     */
    public function getPartyA()
    {
        return $this->partyA;
    }

    /**
     * @param int $partyA
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setPartyA($partyA)
    {
        $this->partyA = $partyA;

        return $this;
    }

    /**
     * @param string $commandID
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setCommandID($commandID)
    {
        $this->commandID = $commandID;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityCredential()
    {
        return $this->securityCredential;
    }

    /**
     * @param string $securityCredential
     *
     * @return $this
     */
    public function setSecurityCredential($securityCredential)
    {
        $this->securityCredential = $securityCredential;

        return $this;
    }

    /**
     * @return string
     */
    public function getOccasion()
    {
        return $this->occasion;
    }

    /**
     * @param string $occasion
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setOccasion($occasion)
    {
        $this->occasion = $occasion;

        return $this;
    }

    /**
     * @return string
     */
    public function getInitiatorName()
    {
        return $this->initiatorName;
    }

    /**
     * @param string $initiatorName
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setInitiatorName($initiatorName)
    {
        $this->initiatorName = $initiatorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getInitiator()
    {
        return $this->initiator;
    }

    /**
     * @param string $initiator
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setInitiator($initiator)
    {
        $this->initiator = $initiator;

        return $this;
    }

    /**
     * @return int
     */
    public function getSenderIdentifierType()
    {
        return $this->senderIdentifierType;
    }

    /**
     * @param int $senderIdentifierType
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setSenderIdentifierType($senderIdentifierType)
    {
        $this->senderIdentifierType = $senderIdentifierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountReference()
    {
        return $this->accountReference;
    }

    /**
     * @return int
     */
    public function getRecieverIdentifierType()
    {
        return $this->recieverIdentifierType;
    }

    /**
     * @param int $recieverIdentifierType
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setRecieverIdentifierType($recieverIdentifierType)
    {
        $this->recieverIdentifierType = $recieverIdentifierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionDesc()
    {
        return $this->transactionDesc;
    }

    /**
     * @param string $transactionDesc
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setTransactionDesc($transactionDesc)
    {
        $this->transactionDesc = $transactionDesc;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallBackURL()
    {
        return $this->callBackURL;
    }

    /**
     * @param string $callBackURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setCallBackURL($callBackURL)
    {
        $this->callBackURL = $callBackURL;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultRouteName()
    {
        return $this->resultRouteName;
    }

    /**
     * @param \Mxgel\MPesa\Responses\Response $response
     *
     * @return Request
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return \Mxgel\MPesa\Responses\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $method
     *
     * @return Request
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return int
     */
    public function getBusinessShortCode()
    {
        return $this->businessShortCode;
    }

    /**
     * @param int $businessShortCode
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setBusinessShortCode($businessShortCode)
    {
        $this->businessShortCode = $businessShortCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdentifierType()
    {
        return $this->identifierType;
    }

    /**
     * @param int $identifierType
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setIdentifierType($identifierType)
    {
        $this->identifierType = $identifierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    /**
     * @param string $transactionID
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setTransactionID($transactionID)
    {
        $this->transactionID = $transactionID;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    protected function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    protected function generatePassword($passKey)
    {
        $code = $this->getBusinessShortCode();
        $timestamp = $this->getTimestamp();

        return base64_encode("{$code}{$passKey}{$timestamp}");
    }

    /**
     * @param string $timestamp
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Execute request and return response
     *
     * @param $auth Auth
     *
     * @return \Mxgel\MPesa\Responses\Response
     * @throws \Mxgel\MPesa\Exceptions\SafaricomException
     */
    public function execute($auth)
    {
        $client = self::getHttpClient([
            'headers' => [
                'Authorization' => $auth->getAuthorizationHeader(),
                'Content-Type'  => "application/json",
            ],
        ]);
        try {
            $handler = $client->getConfig('handler');
            $middleware = Middleware::tap(function (Psr7Request $request) {
                // Dump headers
//                dump($request->getHeaders());

                // Dump body
//                dump($request->getBody()->getContents());
            });
            $response = $client->request($this->getMethod(), $this->getUri(), [
                'json' => $this->toArray(),
                //                'handler' => $middleware($handler),
            ]);

            return new Response($response->getBody()->getContents());
        } catch (ClientException | ServerException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            throw SafaricomException::createFromString($error);
        } catch (Exception $e) {
            throw new SafaricomException($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    protected static function generateReferenceNumber()
    {
        return str_random(4);
    }

    /**
     * @param string $accountReference
     *
     * @return Request
     */
    public function setAccountReference($accountReference)
    {
        $this->accountReference = $accountReference;

        return $this;
    }
}
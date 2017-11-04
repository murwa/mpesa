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
    public function getShortCode(): string
    {
        return $this->shortCode ?: config('services.safaricom.short_codes.0.short_code');
    }

    /**
     * @return null|string
     */
    public function getBillRefNumber(): ?string
    {
        return $this->billRefNumber ?: $this->setBillRefNumber()->getBillRefNumber();
    }

    /**
     * @return int
     */
    public function getMsisdn(): int
    {
        return $this->Msisdn;
    }

    /**
     * @param int $Msisdn
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setMsisdn(int $Msisdn): Request
    {
        $this->Msisdn = $Msisdn;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setAmount(float $amount): Request
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $shortCode
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setShortCode(string $shortCode): Request
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * @param string $billRefNumber
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setBillRefNumber(string $billRefNumber = null): Request
    {
        $this->billRefNumber = $billRefNumber ?: self::generateReferenceNumber();

        return $this;
    }

    /**
     * @return string
     */
    public function getCommandID(): string
    {
        return $this->commandID;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @return string
     */
    public function getConfirmationURL(): string
    {
        if ($this->confirmationURL) {
            return $this->confirmationURL;
        } else {
            $route = config('services.safaricom.routes.confirmation');

            return $this->setConfirmationURL(route($route))->getConfirmationURL();
        }
    }

    /**
     * @return string
     */
    public function getValidationURL(): string
    {
        if ($this->validationURL) {
            return $this->validationURL;
        } else {
            $route = config('services.safaricom.routes.validation');

            return $this->setValidationURL(route($route))->getValidationURL();
        }
    }

    /**
     * @param string $confirmationURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setConfirmationURL(string $confirmationURL): Request
    {
        $this->confirmationURL = $confirmationURL;

        return $this;
    }

    /**
     * @param string $validationURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setValidationURL(string $validationURL): Request
    {
        $this->validationURL = $validationURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultURL(): string
    {
        if ($this->resultURL) {
            return $this->resultURL;
        } else {
            return $this->setResultURL(route($this->getResultRouteName()))->getResultURL();
        }
    }

    /**
     * @param string $resultURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setResultURL(string $resultURL): Request
    {
        $this->resultURL = $resultURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getQueueTimeOutURL(): string
    {
        if ($this->queueTimeOutURL) {
            return $this->queueTimeOutURL;
        } else {
            $route = config('services.safaricom.routes.timeout');

            return $this->setQueueTimeOutURL(route($route))->getQueueTimeOutURL();
        }
    }

    /**
     * @param string $queueTimeOutURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setQueueTimeOutURL(string $queueTimeOutURL): Request
    {
        $this->queueTimeOutURL = $queueTimeOutURL;

        return $this;
    }

    /**
     * @param string $remarks
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setRemarks(string $remarks): Request
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * @return string
     */
    public function getRemarks(): string
    {
        return $this->remarks;
    }

    /**
     * @return int
     */
    public function getPartyB(): int
    {
        return $this->partyB;
    }

    /**
     * @param int $partyB
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setPartyB(int $partyB): Request
    {
        $this->partyB = $partyB;

        return $this;
    }

    /**
     * @return int
     */
    public function getPartyA(): int
    {
        return $this->partyA;
    }

    /**
     * @param int $partyA
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setPartyA(int $partyA): Request
    {
        $this->partyA = $partyA;

        return $this;
    }

    /**
     * @param string $commandID
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setCommandID(string $commandID): Request
    {
        $this->commandID = $commandID;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityCredential(): string
    {
        if ($this->securityCredential) {
            return $this->securityCredential;
        } else {
            return $this->setSecurityCredential(Security::generateCredentials())->getSecurityCredential();
        }
    }

    /**
     * @param string $securityCredential
     *
     * @return $this
     */
    public function setSecurityCredential(string $securityCredential)
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
    public function setOccasion(string $occasion): Request
    {
        $this->occasion = $occasion;

        return $this;
    }

    /**
     * @return string
     */
    public function getInitiatorName(): string
    {
        if ($this->initiatorName) {
            return $this->initiatorName;
        } else {
            $name = config('services.safaricom.short_codes.0.initiator_name');

            return $this->setInitiatorName($name)->getInitiatorName();
        }
    }

    /**
     * @param string $initiatorName
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setInitiatorName(string $initiatorName): Request
    {
        $this->initiatorName = $initiatorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getInitiator(): string
    {
        if ($this->initiator) {
            return $this->initiator;
        } else {
            $name = config('services.safaricom.short_codes.0.initiator_name');

            return $this->setInitiator($name)->getInitiator();
        }
    }

    /**
     * @param string $initiator
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setInitiator(string $initiator): Request
    {
        $this->initiator = $initiator;

        return $this;
    }

    /**
     * @return int
     */
    public function getSenderIdentifierType(): int
    {
        return $this->senderIdentifierType;
    }

    /**
     * @param int $senderIdentifierType
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setSenderIdentifierType(int $senderIdentifierType): Request
    {
        $this->senderIdentifierType = $senderIdentifierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountReference(): string
    {
        return $this->accountReference;
    }

    /**
     * @return int
     */
    public function getRecieverIdentifierType(): int
    {
        return $this->recieverIdentifierType;
    }

    /**
     * @param int $recieverIdentifierType
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setRecieverIdentifierType(int $recieverIdentifierType): Request
    {
        $this->recieverIdentifierType = $recieverIdentifierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionDesc(): string
    {
        return $this->transactionDesc;
    }

    /**
     * @param string $transactionDesc
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setTransactionDesc(string $transactionDesc): Request
    {
        $this->transactionDesc = $transactionDesc;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallBackURL(): string
    {
        if ($this->callBackURL) {
            return $this->callBackURL;
        } else {
            $route = config('services.safaricom.routes.callback');

            return $this->setCallBackURL(route($route))->getCallBackURL();
        }
    }

    /**
     * @param string $callBackURL
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setCallBackURL(string $callBackURL): Request
    {
        $this->callBackURL = $callBackURL;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setPhoneNumber(int $phoneNumber): Request
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultRouteName(): string
    {
        return $this->resultRouteName;
    }

    /**
     * @param \Mxgel\MPesa\Responses\Response $response
     *
     * @return Request
     */
    public function setResponse(Response $response): Request
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return \Mxgel\MPesa\Responses\Response
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getBusinessShortCode(): int
    {
        return $this->businessShortCode;
    }

    /**
     * @param int $businessShortCode
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setBusinessShortCode(int $businessShortCode): Request
    {
        $this->businessShortCode = $businessShortCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdentifierType(): int
    {
        return $this->identifierType;
    }

    /**
     * @param int $identifierType
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setIdentifierType(int $identifierType): Request
    {
        $this->identifierType = $identifierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionID(): string
    {
        return $this->transactionID;
    }

    /**
     * @param string $transactionID
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setTransactionID(string $transactionID): Request
    {
        $this->transactionID = $transactionID;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    protected function setPassword(string $password): Request
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    protected function generatePassword(): string
    {
        $code = $this->getBusinessShortCode();
        $passKey = config('services.safaricom.LNMO_passkey');
        $timestamp = $this->getTimestamp();

        return base64_encode("{$code}{$passKey}{$timestamp}");
    }

    /**
     * @param string $timestamp
     *
     * @return \Mxgel\MPesa\Requests\Request
     */
    public function setTimestamp(string $timestamp): Request
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Execute request and return response
     *
     * @return \Mxgel\MPesa\Responses\Response
     */
    public function execute(): Response
    {
        $client = self::getHttpClient([
            'headers' => [
                'Authorization' => Auth::getAuthorizationHeader(),
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
    public function getMethod(): string
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
    public function setAccountReference(string $accountReference): Request
    {
        $this->accountReference = $accountReference;

        return $this;
    }
}
# README #

This is a non-official implementation of Safaricom's Mpesa G2 API

### How do I get set up? ###

The preferred way is installation via composer:-

`composer require mxgel/mpesa`

That's all.

#### Auth

To communicate with the daraja APIs, you'll always require an access token. 
This has been simplified for you in this library. All you have to do is provide an instance of `Mxgel\MPesa\Auth\Auth` to the execute method. A piece of code like:-

```php
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @return \Mxgel\MPesa\Auth\Auth
     */
    public function getAuth(): Auth
    {
        if (!$this->auth) {
            return $this->auth = new Mxgel\MPesa\Auth\Auth([
                'key'    => config('key'),
                'secret' => config('secret'),
            ]);
        }

        return $this->auth;
    }
    
```

#### MPESA Express

This API is used to initiate online payment on behalf of a customer.

#### Example

Sample code (in Laravel) to initiate the payment can be something like this (use `Mxgel\MPesa\Requests\LNMO`).

```php
$request = LNMO::make($amount, $phoneNumber, $shortCode, 'Wallet top up');
$request->setPassKey(config('LNMO_passkey'))
    ->setBusinessShortCode(config('LNMO_short_code'))
    ->setCallBackURL($callback);


$resp = $request->execute($this->getAuth());
Log::info('STk data', $request->toArray());

//NOTE: For a real application, save this details in a data store
```

We now need to write a callback that will receive data from safaricom upon request completion by the customer. **Remember to save request details above in a data store**

Here is a sample of the callback in laravel.

For easy handling of the received data, we use `Mxgel\MPesa\Responses\LNMOCallbackResponse` class. This strips away unnecessary data and just give us the juice.


```php
// Assuming u have an Express model, u can have this.

Log::debug('LNMO Data', $this->request->all());
$resp = new LNMOCallbackResponse($this->request->get('Body'));
Express::whereMerchantRequestId($resp->getMerchantRequestID())
    ->whereCheckoutRequestId($resp->getCheckoutRequestID())
    ->whereConfirmed(false)                 // Ensure it's yet to be updated
    ->update([
        'receipt_number' => $resp->getMpesaReceiptNumber(),
        'confirmed'      => $resp->completed(),
    ]);
```

Sometimes you might want to write a cron job to update un-confirmed transactions. Luckily, we can use the status check api, and it's a breeze. Use `Mxgel\MPesa\Requests\LNMQ` class like so 

```php
$request = new LNMQ([
    'businessShortCode' => $business_short_code,
    'checkoutRequestID' => $checkout_request_id,
    'passKey'           => config('LNMO_passkey'),
]);

// Remember our auth object? Yes, we need it.
$resp = $request->execute($this->getAuth());
Log::info("Execute status with data: ", $request->toArray());
Log::info("Executed status check with response", $resp->toArray());
if ($resp->completed()) {
    // Your code here...
}
```

At this point, your STK should be fine.

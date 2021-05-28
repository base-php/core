<?php

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe as API;

/**
 * Make a new customer and payment in Stripe, require stripe/stripe-php package.
 */
class Stripe
{
    /**
     * Secret key for Stripe API.
     *
     * $view string
     */
    public $secret_key;

    /**
     * Publishable key for Stripe API.
     *
     * $view string
     */
    public $publishable_key;

    /**
     * Email of the customer.
     *
     * $view string
     */
    public $email;

    /**
     * Token for Stripe API.
     *
     * $view string
     */
    public $token;

    /**
     * Amount of the purchase.
     *
     * $view string
     */
    public $amount;

    /**
     * Currency in which the purchase will be made.
     *
     * $view string
     */
    public $currency;

    /**
     * Initialize the class to use from a global function.
     *
     * @return PDF
     */
    public static function init()
    {
        $class = new static;
        return $class;
    }

    /**
     * Set secret key for Stripe API.
     *
     * @param $secret_key string
     * @return Stripe
     */
    public function secret_key($secret_key)
    {
        $this->secret_key = $secret_key;
        return $this;
    }

    /**
     * Set publishable key for Stripe API.
     *
     * @param $publishable_key string
     * @return Stripe
     */
    public function publishable_key($publishable_key)
    {
        $this->publishable_key = $publishable_key;
        return $this;
    }

    /**
     * Set email of the customer.
     *
     * @param $email string
     * @return Stripe
     */
    public function email($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set token for Stripe API.
     *
     * @param $token string
     * @return Stripe
     */
    public function token($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Set amount of the purchase.
     *
     * @param $amount float
     * @return Stripe
     */
    public function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Set currency of the purchase.
     *
     * @param $amount string
     * @return Stripe
     */
    public function currency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Create the customer and register the purchase.
     *
     * @return Stripe
     */
    public function save()
    {
        $stripe = [
            'secret_key'      => $this->secret_key,
            'publishable_key' => $this->publishable_key,
        ];

        API::setApiKey($stripe['secret_key']);

        $customer = Customer::create([
            'email'  => $this->email,
            'source' => $this->token,
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'amount'   => $this->amount,
            'currency' => $this->currency,
        ]);
    }
}

/**
 * Initialize global helper.
 *
 * @return Stripe
 */
function stripe()
{
    return Stripe::init();
}

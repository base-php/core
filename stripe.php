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
     * Set amount of the purchase.
     *
     * @param $amount float
     * @return Stripe
     */
    public function amount(string $amount): Stripe
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
    public function currency(string $currency): Stripe
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Set email of the customer.
     *
     * @param $email string
     * @return Stripe
     */
    public function email(string $email): Stripe
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Initialize the class to use from a global function.
     *
     * @return Stripe
     */
    public static function init(): Stripe
    {
        $class = new static;
        return $class;
    }    

    /**
     * Set publishable key for Stripe API.
     *
     * @param $publishable_key string
     * @return Stripe
     */
    public function publishable_key(string $publishable_key): Stripe
    {
        $this->publishable_key = $publishable_key;
        return $this;
    }

    /**
     * Create the customer and register the purchase.
     *
     * @return void
     */
    public function save(): void
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

    /**
     * Set secret key for Stripe API.
     *
     * @param $secret_key string
     * @return Stripe
     */
    public function secret_key(string $secret_key): Stripe
    {
        $this->secret_key = $secret_key;
        return $this;
    }

    /**
     * Set token for Stripe API.
     *
     * @param $token string
     * @return Stripe
     */
    public function token(string $token): Stripe
    {
        $this->token = $token;
        return $this;
    }
}

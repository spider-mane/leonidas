<?php

namespace WebTheory\Leonidas\Auth;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Request;

class Nonce
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var int
     */
    protected $expiration = 1;

    public const EXP_12 = 1;
    public const EXP_24 = 2;

    /**
     *
     */
    public function __construct(string $name, string $action, ?int $expiration = null)
    {
        $this->name = $name;
        $this->action = $action;

        if ($expiration && (1 === $expiration || 2 === $expiration)) {
            $this->expiration = $expiration;
        }
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of action
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Get the value of expiration
     *
     * @return int
     */
    public function getExpiration(): int
    {
        return $this->expiration;
    }

    /**
     *
     */
    public function generate()
    {
        return wp_create_nonce($this->action);
    }

    /**
     *
     */
    public function field(bool $referer = false)
    {
        return wp_nonce_field($this->action, $this->name, $referer, false);
    }

    /**
     *
     */
    public function url(string $url)
    {
        return wp_nonce_url($url, $this->action, $this->name);
    }

    /**
     *
     */
    public static function tick()
    {
        return wp_nonce_tick();
    }

    /**
     *
     */
    public function verify(ServerRequestInterface $request)
    {
        $nonce = Request::var($request, $this->name);

        if (!$nonce) {
            return false;
        }

        $verified = wp_verify_nonce($nonce, $this->action);

        return $verified && $verified <= $this->expiration;
    }
}

<?php

namespace Leonidas\Library\Core\Auth;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Request;

class Nonce implements CsrfManagerInterface
{
    protected string $name;

    protected string $action;

    protected ?int $expiration = 1;

    public const EXP_12 = 1;
    public const EXP_24 = 2;

    public function __construct(string $name, string $action, ?int $expiration = null)
    {
        $this->name = $name;
        $this->action = $action;

        if ($expiration && (1 === $expiration || 2 === $expiration)) {
            $this->expiration = $expiration;
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getExpiration(): int
    {
        return $this->expiration;
    }

    public function getToken(): string
    {
        return $this->generate();
    }

    public function generate()
    {
        return wp_create_nonce($this->action);
    }

    public function renderField(): string
    {
        return $this->field(false);
    }

    public function field(bool $referer = false): string
    {
        return wp_nonce_field($this->action, $this->name, $referer, false);
    }

    public function toHtml(): string
    {
        return $this->field(false);
    }

    public function url(string $url)
    {
        return wp_nonce_url($url, $this->action, $this->name);
    }

    public function verify(ServerRequestInterface $request): bool
    {
        $nonce = Request::var($request, $this->name);

        return $nonce ? wp_verify_nonce($nonce, $this->action) : false;
    }

    public function validate(ServerRequestInterface $request): bool
    {
        $verified = $this->verify($request);

        return $verified && ($verified <= $this->expiration);
    }

    public function __toString()
    {
        return $this->field(false);
    }

    public static function tick()
    {
        return wp_nonce_tick();
    }
}

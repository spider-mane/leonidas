<?php

namespace Leonidas\Library\Core\Http\Form;

use GuzzleHttp\Psr7\ServerRequest;
use Leonidas\Contracts\Http\Form\FormControllerInterface;
use Leonidas\Contracts\Http\Form\FormInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;
use WebTheory\Saveyour\Fields\Hidden;

class Form implements FormControllerInterface
{
    /**
     *
     */
    protected $action;

    /**
     *
     */
    protected $handler;

    /**
     * @var bool
     */
    protected $nopriv = true;

    /**
     * @var string
     */
    protected $redirect;

    /**
     *
     */
    public function __construct(string $action, string $handler, bool $nopriv = true, ?string $redirect = null)
    {
        $this->action = $action;
        $this->nopriv = $nopriv;
        $this->setHandler($handler);

        if ($redirect) {
            $this->redirect = $redirect;
        }
    }

    /**
     * Set the value of form
     *
     * @param string $handler
     *
     * @return self
     */
    public function setHandler(string $handler)
    {
        if (class_exists($handler) && in_array(FormInterface::class, class_implements($handler))) {
            $this->handler = $handler;
        } else {
            $interface = \Leonidas\Contracts\Http\Form\FormInterface::class;
            $message = "\$form argument must be a reference to an implementation of $interface";

            throw new \Exception($message);
        }

        return $this;
    }

    /**
     *
     */
    protected function hook()
    {
        add_action("admin_post_{$this->action}", [$this, 'handle']);

        if (true === $this->nopriv) {
            add_action("admin_post_nopriv_{$this->action}", [$this, 'handle']);
        }

        return $this;
    }

    /**
     *
     */
    public function build(): array
    {
        $request = $this->getRequest();
        $handler = $this->initHandler();
        $verification = array_merge(
            $handler->verificationFields($request),
            $this->requestFields($request)
        );

        return [
            'method' => $this->method(),
            'action' => $this->action(),
            'fields' => $handler->formFields($request),
            'checks' => implode("\n", $verification)
        ];
    }

    /**
     *
     */
    public function handle()
    {
        $request = $this->getRequest();
        $results = $this->process($request);

        $this->redirect($request, $results);

        exit;
    }

    /**
     *
     */
    public function process(ServerRequestInterface $request): FormProcessingCacheInterface
    {
        return $this->initHandler()->process($request);
    }

    /**
     *
     */
    protected function redirect(ServerRequestInterface $request, FormProcessingCacheInterface $results)
    {
        wp_safe_redirect($this->redirect ?? wp_get_referer());
    }

    /**
     *
     */
    protected function initHandler(): FormInterface
    {
        return new $this->handler();
    }

    /**
     *
     */
    protected function method()
    {
        return 'post';
    }

    /**
     *
     */
    protected function action()
    {
        return esc_url(admin_url('admin-post.php'));
    }

    /**
     *
     */
    protected function getRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }

    /**
     *
     */
    protected function requestFields(ServerRequestInterface $request)
    {
        return [
            'action' => (new Hidden())
                ->setName('action')
                ->setValue($this->action)
                ->toHtml(),

            'referer' => wp_referer_field(false)
        ];
    }

    /**
     *
     */
    public static function create(string $id, string $handler, bool $nopriv = false, ?string $redirect = null): Form
    {
        return (new static($id, $handler, $nopriv, $redirect))->hook();
    }
}

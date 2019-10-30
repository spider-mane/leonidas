<?php

namespace Theme;

use Backalley\Form\Fields\Hidden;

class WpForm
{
    /**
     *
     */
    protected $id;

    /**
     *
     */
    protected $handler;

    /**
     * @var bool
     */
    protected $nopriv = false;

    /**
     * @var string
     */
    protected $redirect;

    /**
     *
     */
    protected $config;

    /**
     *
     */
    protected static $forms = [];

    /**
     *
     */
    public function __construct(string $id)
    {
        $this->id = $id;

        static::$forms[$id] = $this;
    }

    /**
     * Set the value of nopriv
     *
     * @param bool $nopriv
     *
     * @return self
     */
    protected function setNopriv(bool $nopriv)
    {
        $this->nopriv = $nopriv;

        return $this;
    }

    /**
     * Set the value of redirect
     *
     * @param string $redirect
     *
     * @return self
     */
    public function setRedirect(string $redirect)
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     *
     */
    protected function hook()
    {
        add_action("admin_post_{$this->id}", [$this, 'process']);

        if (true === $this->nopriv) {
            add_action("admin_post_nopriv_{$this->id}", [$this, 'process']);
        }

        return $this;
    }

    /**
     *
     */
    public static function register(string $id, string $handler, ?bool $nopriv = null)
    {
        $form = (new static($id, $handler))->hook();

        if ($nopriv) {
            $form->setNopriv($nopriv);
        }
    }

    /**
     *
     */
    public static function get(string $form)
    {
        return (static::$forms[$form])->build();
    }

    /**
     *
     */
    public function process()
    {
        $handler = $this->getHandler();

        $handler::process($this->config);
        $this->redirect();

        exit;
    }

    /**
     *
     */
    protected function redirect()
    {
        wp_safe_redirect($this->redirect ?? wp_get_referer());
    }

    /**
     *
     */
    protected function build()
    {
        $handler = $this->getHandler();

        return $handler::build([

            'method' => $this->config['method'] ?? 'post',
            'action' => $this->config['action'] ?? $this->action(),
            'security' => $this->security(),
            'fields' => $this->config['fields'],

        ], $this->config);
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
    protected function security()
    {
        $security = $this->config['security'];

        $nonce = $security['nonce'];
        $recaptcha = $security['reCaptcha'];

        return [

            'action' => (new Hidden)
                ->setName('action')
                ->setValue($this->id)
                ->toHtml(),

            'nonce' => (new Hidden)
                ->setName($nonce['name'])
                ->setValue(wp_create_nonce($nonce['action']))
                ->toHtml(),

            'referer' => wp_referer_field(false),

            'reCaptcha' => (new Hidden)
                ->setName($recaptcha)
                ->setId($recaptcha)
                ->toHtml(),
        ];
    }

    /**
     * @return FormHandler
     */
    protected static function getFormController(array $config): FormHandler
    {
        $security = $config['security'];

        $nonce = $security['nonce'];
        $recaptcha = $security['reCaptcha'];

        $recaptchaSecret = Config::get('services.reCaptcha.secret');

        return (new FormHandler)
            ->addValidator(new WpNonceValidator($nonce['name'], $nonce['action']))
    }
}

<?php

namespace WebTheory\Leonidas\Admin\Term;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Fields\AbstractField;
use WebTheory\Leonidas\Admin\Contracts\TermFieldInterface;
use WebTheory\Leonidas\Admin\Traits\UsesTemplateTrait;

class Field extends AbstractField implements TermFieldInterface
{
    use UsesTemplateTrait;

    /**
     * @var string
     */
    protected $template;

    /**
     *
     */
    protected function setTemplate(): Field
    {
        switch (get_current_screen()->base) {

            case 'edit-tags':
                $template = 'term--add__field';
                break;

            case 'term':
                $template = 'term--edit__field';
                break;
        }

        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function render(ServerRequestInterface $request): string
    {
        $context = [
            'label' => $this->label,
            'description' => $this->description,
            'field' => $this->renderFormField($request)
        ];

        return $this->setTemplate()->renderTemplate($context);
    }
}

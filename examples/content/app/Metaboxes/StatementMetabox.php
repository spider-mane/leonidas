<?php

namespace Example\Content\Metaboxes;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxFieldInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Framework\Capsule\Abstracts\MetaboxCapsule;
use Leonidas\Library\Admin\Component\Metabox\Element\Field;
use Leonidas\Library\Admin\Component\Metabox\Layout\SegmentedLayout;
use Leonidas\Library\Admin\Field\Data\PostMetaFieldManager;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Controller\Builder\FormFieldControllerBuilder;
use WebTheory\Saveyour\Field\Type\Textarea;
use WebTheory\Saveyour\Validation\RespectValidator;
use WP_Screen;

class StatementMetabox extends MetaboxCapsule
{
    use LeonidasServices;

    public function id(): string
    {
        return $this->slug('statement');
    }

    public function title(): string
    {
        return 'Statement';
    }

    public function screen(): string|array|WP_Screen
    {
        return $this->key('statement');
    }

    public function layout(ServerRequestInterface $request): MetaboxLayoutInterface
    {
        return new SegmentedLayout(
            $this->textField($request),
            $this->mediaField($request),
        );
    }

    protected function formFields(ServerRequestInterface $request): array
    {
        return [
            $this->textFormField($request),
        ];
    }

    protected function textField(ServerRequestInterface $request): MetaboxFieldInterface
    {
        return (new Field($this->textFormField($request)))
            ->setLabel('Text')
            ->setDescription('');
    }

    protected function mediaField(ServerRequestInterface $request): MetaboxFieldInterface
    {
        return (new Field($this->mediaFormField($request)))
            ->setLabel('Media')
            ->setDescription('');
    }

    protected function textFormField(ServerRequestInterface $request): FormFieldControllerInterface
    {
        $var = $this->slug('statement-text');
        $meta = $this->scoped('statement-text');

        $builder = FormFieldControllerBuilder::for($var)->dataManager(
            new PostMetaFieldManager($meta)
        );

        if ($this->isGetRequest($request)) {
            $builder->formField((new Textarea())->addClass('textbox'));
        } else {
            $builder->validator(new RespectValidator(
                Validator::notEmpty()->setName('required')
            ));
        }

        return $builder->get();
    }

    protected function mediaFormField(ServerRequestInterface $request): FormFieldControllerInterface
    {
        $var = $this->slug('statement-media');
        $meta = $this->scoped('statement-media');

        $builder = FormFieldControllerBuilder::for($var)->dataManager(
            new PostMetaFieldManager($meta)
        );

        if ($this->isGetRequest($request)) {
            //
        } else {
            $builder->validator(new RespectValidator(
                //
            ));
        }

        return $builder->get();
    }

    protected function alerts(): array
    {
        return [
            'required' => [
                'id' => 'statement',
                'message' => 'Text is required',
                'type' => 'error',
                'dismissible' => false,
            ],
        ];
    }
}

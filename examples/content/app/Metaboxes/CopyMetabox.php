<?php

namespace Example\Content\Metaboxes;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
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

class CopyMetabox extends MetaboxCapsule
{
    use LeonidasServices;

    public function id(): string
    {
        return $this->slug('copy');
    }

    public function title(): string
    {
        return 'Copy';
    }

    public function screen(): string|array|WP_Screen
    {
        return $this->key('copy');
    }

    public function layout(ServerRequestInterface $request): MetaboxLayoutInterface
    {
        return new SegmentedLayout(...$this->components($request));
    }

    /**
     * @return list<MetaboxComponentInterface>
     */
    protected function components(ServerRequestInterface $request): array
    {
        return [
            $this->contentField($request),
            $this->mediaField($request),
        ];
    }

    protected function contentField(ServerRequestInterface $request): MetaboxFieldInterface
    {
        return (new Field($this->contentFormField($request)))
            ->setLabel('Text')
            ->setDescription('');
    }

    protected function mediaField(ServerRequestInterface $request): MetaboxFieldInterface
    {
        return (new Field($this->mediaFormField($request)))
            ->setLabel('Media')
            ->setDescription('');
    }

    protected function formFields(ServerRequestInterface $request): array
    {
        return [
            $this->contentFormField($request),
        ];
    }

    protected function contentFormField(ServerRequestInterface $request): FormFieldControllerInterface
    {
        $var = $this->slug('copy-text');
        $meta = $this->scoped('copy-text');

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
        $var = $this->slug('copy-media');
        $meta = $this->scoped('copy-media');

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
                'id' => 'copy',
                'message' => 'Text is required',
                'type' => 'error',
                'dismissible' => false,
            ],
        ];
    }
}

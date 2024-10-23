<?php

namespace Example\Plugin\Metaboxes;

use Faker\Factory;
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
use WebTheory\Saveyour\Field\Type\Text;
use WebTheory\Saveyour\Validation\RespectValidator;
use WP_Screen;

class RandomStuff extends MetaboxCapsule
{
    use LeonidasServices;

    public function id(): string
    {
        return $this->prefix('app-random-stuff', '-');
    }

    public function title(): string
    {
        return 'Random Stuff';
    }

    public function screen(): string|array|WP_Screen
    {
        return 'post';
    }

    public function layout(ServerRequestInterface $request): MetaboxLayoutInterface
    {
        return new SegmentedLayout(
            $this->randomThingField($request)
        );
    }

    protected function formFields(ServerRequestInterface $request): array
    {
        return [
            $this->randomThingFormField($request),
        ];
    }

    protected function randomThingField(ServerRequestInterface $request): MetaboxFieldInterface
    {
        return (new Field($this->randomThingFormField($request)))
            ->setLabel('Random Thing')
            ->setDescription(Factory::create()->sentence(15));
    }

    protected function randomThingFormField(ServerRequestInterface $request): FormFieldControllerInterface
    {
        $var = $this->prefix('random-thing', '-');
        $meta = $this->prefix('random-thing', '--');

        $builder = FormFieldControllerBuilder::for($var)->dataManager(
            new PostMetaFieldManager($meta)
        );

        if ('GET' === $request->getMethod()) {
            $builder->formField((new Text())->addClass('regular-text'));
        } else {
            $builder->validator(new RespectValidator(
                Validator::number()->setName('not_a_thing')
            ));
        }

        return $builder->get();
    }

    protected function alerts(): array
    {
        return [
            'not_a_thing' => [
                'id' => 'not-a-thing',
                'message' => 'Enter a valid random thing',
                'type' => 'error',
                'dismissible' => true,
            ],
        ];
    }
}

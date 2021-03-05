<?php

namespace WebTheory\Leonidas\Admin\Repository;

use GuzzleHttp\Psr7\ServerRequest;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxRepositoryInterface;

class MetaboxRepository implements MetaboxRepositoryInterface
{
    /**
     * @var MetaboxInterface[]
     */
    protected $metaboxes = [];

    public function getMetabox(string $id)
    {
        return $this->metaboxes[$id];
    }

    public function addMetabox(MetaboxInterface $metabox)
    {
        $this->metaboxes[$metabox->getId()] = $metabox;
        $this->addMetaboxToWp($metabox);
    }

    protected function addMetaboxToWp(MetaboxInterface $metabox)
    {
        add_meta_box(
            $metabox->getId(),
            $metabox->getTitle(),
            [$this, 'metaboxCallbackWrapper'],
            $metabox->getScreen(),
            $metabox->getContext(),
            $metabox->getPriority(),
            $metabox->getCallBackArgs()
        );
    }

    public function metaboxCallbackWrapper($object, array $metabox)
    {
        $localMetabox = $this->getMetabox($metabox['id']);

        if ($localMetabox) {
            $request = $this->getServerRequest()
                ->withAttribute('object', $object)
                ->withAttribute('metabox', $metabox);

            echo $localMetabox->renderComponent($request);
        }
    }

    public function renderMetaBoxes($screen, $context, ServerRequestInterface $request): string
    {
        if (!$object = $request->getAttribute('object')) {
            $message = '$request argument passed to ' . __METHOD__ . ' must include an "object" attribute.';
            throw new InvalidArgumentException($message);
        }

        ob_start();
        $output = do_meta_boxes($screen, $context, $object);
        ob_get_clean();

        return $output;
    }

    public function doMetaboxes($screen, $context, ServerRequestInterface $request): void
    {
        echo $this->renderMetaBoxes($screen, $context, $request);
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }
}

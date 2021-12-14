<?php

namespace Leonidas\Traits\Registrars;

use Leonidas\Contracts\Admin\Components\MetaboxInterface;

trait RegistersMetabox
{
    protected function registerMetabox()
    {
        $metabox = $this->getMetabox();

        add_meta_box(
            $metabox->getId(),
            $metabox->getTitle(),
            $this->getRenderMetaboxCallback(),
            $metabox->getScreen(),
            $metabox->getContext(),
            $metabox->getPriority(),
            $metabox->getCallBackArgs()
        );
    }

    protected function getRenderMetaboxCallback()
    {
        return function () {
            $this->renderMetabox();
        };
    }

    abstract protected function getMetabox(): MetaboxInterface;

    abstract protected function renderMetabox(): void;
}

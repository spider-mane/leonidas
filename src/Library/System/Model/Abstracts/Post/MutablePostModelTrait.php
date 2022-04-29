<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Psr\Link\LinkInterface;

trait MutablePostModelTrait
{
    use PostModelTrait;

    public function setName(string $name): self
    {
        $this->post->post_name = $name;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->post->post_title = $title;

        return $this;
    }

    public function setGuid(LinkInterface $guid): self
    {
        $this->post->guid = $guid->getHref();

        return $this;
    }

    public function setMenuOrder(int $menuOrder): self
    {
        $this->post->menu_order = $menuOrder;

        return $this;
    }

    public function setPageTemplate(string $pageTemplate): self
    {
        $this->post->page_template = $pageTemplate;

        return $this;
    }
}

<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeInterface;
use Psr\Link\LinkInterface;
use WP_Post;

interface PostModelInterface extends EntityModelInterface
{
    public function getName(): string;

    public function getGuid(): LinkInterface;

    public function getMenuOrder(): int;

    public function getPageTemplate(): string;

    public function getPostType(): PostTypeInterface;

    public function getCore(): WP_Post;
}

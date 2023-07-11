<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WP_Screen;

interface MetaboxCapsuleInterface extends FormProcessingCapsuleInterface
{
    public function id(): string;

    public function title(): string;

    public function screen(): string|array|WP_Screen;

    public function context(): string;

    public function priority(): string;

    public function args(): array;

    public function layout(ServerRequestInterface $request): MetaboxLayoutInterface;

    public function policy(): ?ServerRequestPolicyInterface;
}

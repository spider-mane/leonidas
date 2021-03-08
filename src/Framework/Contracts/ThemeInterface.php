<?php

namespace WebTheory\Leonidas\Framework\Contracts;

use WebTheory\Leonidas\Admin\Contracts\WpExtensionInterface;

interface ThemeInterface extends WpExtensionInterface
{
    public function getImage(string $image): ?string;

    public function getVideo(string $video): ?string;

    public function getAudio(string $audio): ?string;

    public function getFont(string $font): ?string;

    public function getLang(string $language): ?string;
}

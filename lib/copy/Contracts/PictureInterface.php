<?php

namespace WebContent\Copy\Contracts;

interface PictureInterface extends MimeInterface
{
    public function getAlt(): string;
}

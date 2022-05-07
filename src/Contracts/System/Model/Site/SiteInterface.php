<?php

namespace Leonidas\Contracts\System\Model\Site;

interface SiteInterface
{
    public function getTitle(): string;

    public function getDescription(): string;

    public function getIcon(int $size = 512): string;

    public function getUrl(): string;

    public function getAdminUrl(): string;

    public function getCharset(): string;

    public function getLocale(): string;

    public function getLanguageAttributes(): string;

    public function getRssUrl(): string;

    public function getRss2Url(): string;

    public function getAtomUrl(): string;

    public function getRdfUrl(): string;

    public function getPingbackUrl(): string;
}

<?php

namespace Leonidas\Library\System\Model\Site;

use Leonidas\Contracts\System\Model\Site\SiteInterface;
use Leonidas\Library\System\Model\Abstracts\GetAccessGrantedTrait;
use Leonidas\Library\System\Model\GetAccessProvider;

class Site implements SiteInterface
{
    use GetAccessGrantedTrait;

    protected string $title;

    protected string $description;

    protected string $icon;

    protected string $url;

    protected string $adminUrl;

    protected string $charset;

    protected string $locale;

    protected string $languageAttributes;

    protected string $rssUrl;

    protected string $rss2Url;

    protected string $atomUrl;

    protected string $rdfUrl;

    protected string $pingbackUrl;

    public function __construct()
    {
        $this->getAccessProvider = new GetAccessProvider($this);
    }

    public function getTitle(): string
    {
        return $this->title ??= get_bloginfo('name');
    }

    public function getDescription(): string
    {
        return $this->description ??= get_bloginfo('description');
    }

    public function getIcon(int $size = 512): string
    {
        return $this->icon ??= get_site_icon_url($size);
    }

    public function getUrl(): string
    {
        return $this->url ??= get_home_url();
    }

    public function getAdminUrl(): string
    {
        return $this->adminUrl ??= get_admin_url();
    }

    public function getCharset(): string
    {
        return $this->charset ??= get_bloginfo('charset');
    }

    public function getLocale(): string
    {
        return $this->locale ??= get_locale();
    }

    public function getLanguageAttributes(): string
    {
        return $this->languageAttributes ??= get_language_attributes();
    }

    public function getRssUrl(): string
    {
        return $this->rssUrl ??= get_feed_link('rss');
    }

    public function getRss2Url(): string
    {
        return $this->rss2Url ??= get_feed_link('rss2');
    }

    public function getAtomUrl(): string
    {
        return $this->atomUrl ??= get_feed_link('atom');
    }

    public function getRdfUrl(): string
    {
        return $this->rdfUrl ??= get_feed_link('rdf');
    }

    public function getPingbackUrl(): string
    {
        return $this->pingbackUrl ??= get_bloginfo('pingback_url');
    }
}

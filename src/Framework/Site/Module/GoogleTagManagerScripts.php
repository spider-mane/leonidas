<?php

namespace Leonidas\Framework\Site\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsWpBodyOpenHook;
use Leonidas\Hooks\TargetsWpHeadHook;
use WebTheory\Html\Html;

class GoogleTagManagerScripts extends Module
{
    use TargetsWpBodyOpenHook;
    use TargetsWpHeadHook;

    protected const NS_URL = 'https://www.googletagmanager.com/ns.html';

    protected const GTAG_URL = 'https://www.googletagmanager.com/gtag/js';

    protected const GTM_SCRIPT = <<<JS
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '%s');
    JS;

    protected string $tagId;

    public function hook(): void
    {
        $this->targetWpBodyOpenHook();
        $this->targetWpHeadHook();
    }

    protected function getTagId(): string
    {
        return $this->tagId ?? $this->tagId();
    }

    protected function getWpHeadPriority(): int
    {
        return PHP_INT_MIN;
    }

    protected function getWpBodyOpenPriority(): int
    {
        return PHP_INT_MIN;
    }

    protected function doWpHeadAction(): void
    {
        $nl = PHP_EOL;
        $script = $nl . $this->getGtmScript() . $nl;

        echo '<!-- Google Tag Manager -->' . $nl;
        echo Html::tag('script', [], $script) . $nl;
        echo '<!-- End Google Tag Manager -->' . $nl;
    }

    protected function doWpBodyOpenAction(): void
    {
        $nl = PHP_EOL;
        $iframe = $this->getNsIframe();

        echo '<!-- Google Tag Manager (noscript) -->' . $nl;
        echo Html::tag('noscript', [], $iframe) . $nl;
        echo '<!-- End Google Tag Manager (noscript) -->' . $nl;
    }

    protected function getGtmScript(): string
    {
        return sprintf(static::GTM_SCRIPT, $this->getTagId());
    }

    protected function getNsIframe(): string
    {
        return Html::tag('iframe', [
            'src' => add_query_arg($this->getNsQuery(), static::NS_URL),
            'height' => '0',
            'width' => '0',
            'style' => 'display:none;visibility:hidden',
        ]);
    }

    protected function getNsQuery(): array
    {
        return ['id' => $this->getTagId()];
    }

    protected function tagId(): string
    {
        return $this->getConfig('services.google.tag_manager.id', '');
    }
}

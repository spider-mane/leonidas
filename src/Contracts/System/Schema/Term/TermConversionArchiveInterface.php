<?php

namespace Leonidas\Contracts\System\Schema\Term;

use Leonidas\Contracts\System\Schema\EntityConversionArchiveInterface;
use WP_Term;

interface TermConversionArchiveInterface extends EntityConversionArchiveInterface
{
    public function getConversion(WP_Term $post): object;

    public function getReversion(object $entity): WP_Term;

    public function archive(WP_Term $native, object $conversion): void;
}

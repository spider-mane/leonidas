<?php

namespace Leonidas\Library\System\Model\Abstracts;

use DateTime;
use Leonidas\Contracts\System\Model\DatableInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;

trait DatableAccessProviderTrait
{
    protected function resolvedDatableGetters(DatableInterface $datable): array
    {
        $format = $datable::DATE_FORMAT;

        $getDate = fn () => $datable->getDate()->format($format);
        $getDateGmt = fn () => $datable->getDateGmt()->format($format);
        $getDateModified = fn () => $datable->getDateModified()->format($format);
        $getDateModifiedGmt = fn () => $datable->getDateModifiedGmt()->format($format);

        return [
            'date' => $getDate,
            'dateGmt' => $getDateGmt,
            'date_gmt' => $getDateGmt,
            'dateModified' => $getDateModified,
            'date_modified' => $getDateModified,
            'dateModifiedGmt' => $getDateModifiedGmt,
            'date_modified_gmt' => $getDateModifiedGmt,
        ];
    }

    protected function resolvedDatableSetters(MutableDatableInterface $datable): array
    {
        $setDate = fn ($date) => $datable->setDate(new DateTime($date));
        $setDateGmt = fn ($date) => $datable->setDateGmt(new DateTime($date));
        $setDateModified = fn ($date) => $datable->setDateModified(new DateTime($date));
        $setDateModifiedGmt = fn ($date) => $datable->setDateModifiedGmt(new DateTime($date));

        return [
            'date' => $setDate,
            'dateGmt' => $setDateGmt,
            'date_gmt' => $setDateGmt,
            'dateModified' => $setDateModified,
            'date_modified' => $setDateModified,
            'dateModifiedGmt' => $setDateModifiedGmt,
            'date_modified_gmt' => $setDateModifiedGmt,
        ];
    }
}

<?php

namespace Leonidas\Framework\Access;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * @method static string format(PhoneNumber $number, $numberFormat)
 * @method static string formatByPattern(PhoneNumber $number, $numberFormat, array $userDefinedFormats)
 * @method static PhoneNumber parse($numberToParse, $defaultRegion = null, PhoneNumber $phoneNumber = null, $keepRawInput = false)
 */
trait PhoneNumberUtilFacadeTrait
{
    public static function formatUs(string $phoneNumber, string $format = 'dashes', $scheme = PhoneNumberFormat::NATIONAL): string
    {
        return static::formatByPattern(
            static::parse($phoneNumber, 'US'),
            $scheme,
            [static::getNumberFormatUS($format)]
        );
    }

    public static function formatNatUS(string $phoneNumber, string $format = 'dashes')
    {
        return static::formatUs(
            $phoneNumber,
            $format,
            PhoneNumberFormat::NATIONAL
        );
    }

    public static function formatIntlUS(string $phoneNumber, string $format = 'dashes')
    {
        return static::formatUs(
            $phoneNumber,
            $format,
            PhoneNumberFormat::INTERNATIONAL
        );
    }

    public static function getHref($phoneNumber, $region = 'US'): string
    {
        return static::format(
            static::parse($phoneNumber, $region),
            PhoneNumberFormat::RFC3966
        );
    }

    public static function getNumberFormatUS(string $format): NumberFormat
    {
        $pattern = "(\\d{3})(\\d{3})(\\d{4})";
        $formats = static::formatsUS();

        return (new NumberFormat())
            ->setPattern($pattern)
            ->setFormat($formats[$format]);
    }

    protected static function formatsUS(): array
    {
        return [
            'raw' => "\$1\$2\$3",
            'dots' => "\$1.\$2.\$3",
            'dashes' => "\$1-\$2-\$3",
            'spaces' => "\$1 \$2 \$3",
            'classic' => "(\$1) \$2-\$3",
        ];
    }

    protected static function _getFacadeAccessor()
    {
        return PhoneNumberUtil::class;
    }
}

<?php

namespace Example\Plugin\Settings;

use Faker\Factory;
use Leonidas\Contracts\Admin\Processing\Setting\SettingCapsuleInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeRepositoryInterface;
use Leonidas\Framework\Capsule\Abstracts\AbstractCapsule;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;
use WebTheory\Saveyour\Formatting\LazyDataFormatter;
use WebTheory\Saveyour\Validation\PermissiveValidator;

class CompanyName extends AbstractCapsule implements SettingCapsuleInterface
{
    protected ValidatorInterface $validator;

    protected InputFormatterInterface $formatter;

    protected SettingNoticeRepositoryInterface $notices;

    public function name(): string
    {
        return $this->prefix('company-name', '--');
    }

    public function group(): string
    {
        return $this->prefix('company-info', '--');
    }

    public function type(): string
    {
        return 'string';
    }

    public function description(): string
    {
        return Factory::create()->sentence(10);
    }

    public function default(): mixed
    {
        return null;
    }

    public function rest(): bool|array|null
    {
        return null;
    }

    public function extra(): ?array
    {
        return null;
    }

    public function validator(): ValidatorInterface
    {
        return $this->formatter ??= new PermissiveValidator();
    }

    public function formatter(): InputFormatterInterface
    {
        return $this->formatter ??= new LazyDataFormatter();
    }

    public function notices(): SettingNoticeRepositoryInterface
    {
        return $this->notices ??= $this->getService(
            SettingNoticeRepositoryInterface::class
        );
    }
}

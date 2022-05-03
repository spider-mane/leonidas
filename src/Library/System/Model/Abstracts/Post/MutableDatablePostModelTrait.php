<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use DateTimeInterface;
use Leonidas\Contracts\System\Model\DatableInterface;

trait MutableDatablePostModelTrait
{
    use DatablePostModelTrait;

    public function setDate(DateTimeInterface $date): self
    {
        $this->post->post_date = $date->format(DatableInterface::DATE_FORMAT);

        return $this;
    }

    public function setDateGmt(DateTimeInterface $date): self
    {
        $this->post->post_date_gmt = $date->format(DatableInterface::DATE_FORMAT);

        return $this;
    }

    public function setDateModified(DateTimeInterface $date): self
    {
        $this->post->post_modified = $date->format(DatableInterface::DATE_FORMAT);

        return $this;
    }

    public function setDateModifiedGmt(DateTimeInterface $date): self
    {
        $this->post->post_modified_gmt = $date->format(DatableInterface::DATE_FORMAT);

        return $this;
    }
}

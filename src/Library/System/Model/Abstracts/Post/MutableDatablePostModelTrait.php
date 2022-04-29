<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use DateTimeInterface;

trait MutableDatablePostModelTrait
{
    use DatablePostModelTrait;

    public function setDate(DateTimeInterface $date): self
    {
        $this->post->post_date = $date->getTimestamp();

        return $this;
    }

    public function setDateGmt(DateTimeInterface $date): self
    {
        $this->post->post_date_gmt = $date->getTimestamp();

        return $this;
    }

    public function setDateModified(DateTimeInterface $date): self
    {
        $this->post->post_modified = $date->getTimestamp();

        return $this;
    }

    public function setDateModifiedGmt(DateTimeInterface $date): self
    {
        $this->post->post_modified_gmt = $date->getTimestamp();

        return $this;
    }
}

<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Carbon\Carbon;
use Carbon\CarbonInterface;

trait DatablePostModelTrait
{
    use MappedToWpPostTrait;

    public function getDate(): CarbonInterface
    {
        return new Carbon($this->post->post_date);
    }

    public function getDateGmt(): CarbonInterface
    {
        return new Carbon($this->post->post_date_gmt);
    }

    public function getDateModified(): CarbonInterface
    {
        return new Carbon($this->post->post_modified);
    }

    public function getDateModifiedGmt(): CarbonInterface
    {
        return new Carbon($this->post->post_modified_gmt);
    }
}

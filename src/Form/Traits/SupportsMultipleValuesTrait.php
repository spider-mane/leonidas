<?

namespace WebTheory\SaveyourFields\Traits;


trait SupportsMultipleValuesTrait
{
    /**
     *
     */
    public $value = [];

    /**
     *
     */
    public function setValue($value)
    {
        $this->value[] = $value;
    }
}

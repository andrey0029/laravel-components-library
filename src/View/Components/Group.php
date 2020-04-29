<?php


namespace TomSix\Components\View\Components;


use Illuminate\View\Component;

class Group extends Component
{
    /**
     * Specifies the name
     *
     * @var string $name
     */
    public string $name;

    /**
     * The label text. There will no label rendered if it isn't provided
     *
     * @var string|null $label
     */
    public ?string $label;

    /**
     * Define a default value
     *
     * @var mixed $value
     */
    public $value;

    /**
     * All extra HTML-tag attributes
     *
     * @var string $inputAttributes
     */
    public string $inputAttributes;

    /**
     * InputField constructor.
     * @param string $name
     * @param string|null $label
     * @param array|string $inputAttributes
     * @param mixed $value
     */
    public function __construct(string $name, ?string $label = null, $inputAttributes = [], $value = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->inputAttributes = is_string($inputAttributes) ? $inputAttributes : $this->renderAttributes($inputAttributes);
        $this->value = old($this->nameWithoutBrackets(), $value) ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('library::form.group');
    }

    /**
     * Get the name without brackets when using multiple values
     *
     * @return string|string[]
     */
    public function nameWithoutBrackets()
    {
        return str_replace('[]', '', $this->name);
    }

    private function renderAttributes(array $attributes): string
    {
        $attributeStrings = [];

        foreach ($attributes as $attribute => $value)
        {
            if(is_int($attribute)) {
                $attributeStrings[] = $value;
                continue;
            }

            $value = htmlentities($value, ENT_QUOTES, 'UTF-8', false);

            $attributeStrings[] = "{$attribute}={$value}";
        }

        return implode(' ', $attributeStrings);
    }
}
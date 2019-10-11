<?php

namespace KarimQaderi\Zoroaster\Fields\Group;

class HtmlElement extends ViewAbstract
{


    /**
     * element کلاس
     *
     * @var string
     */
    public $class;

    /**
     * ها عنصر
     *
     * @var array
     */
    public $text;

    /**
     * element
     *
     * @var string
     */
    public $element;

    /**
     * ایجاد
     */
    public function __construct($element, $text, $class = null, $att = [])
    {
        $this->element = $element;
        $this->class = $class;
        $this->text = $text;
        $this->att = $att;
    }

    /**
     * عنصر ایجاد
     *
     * @return static
     */
    public static function make($element, $text, $class = null, $att = [])
    {
        return new static($element, $text, $class, $att);
    }

    /**
     *  نمایش
     *
     * @return string
     */
    public function render($builder, $field = null, $ResourceRequest = null)
    {
        $att = '';
        foreach ($builder->att as $key => $val) {
            $att .= $key . '="' . $val . '" ';
        }

        return "<{$builder->element} class='{$builder->class}' {$att}>" . $builder->text . "</{$builder->element}>";
    }
}

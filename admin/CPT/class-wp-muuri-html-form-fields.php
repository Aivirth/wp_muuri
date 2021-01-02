<?php

class Wp_Muuri_html_form_fields
{
    /**
     * Calls the appropriate function based on a field type.
     */
    public function sort(array $fieldCfg, $post)
    {
        $name = $fieldCfg['name'];
        $label = $fieldCfg['label'];
        $type = $fieldCfg['type'];
        $default = $fieldCfg['default'];
        $value = isset($post[$name][0]) ? $post[$name][0] : $default;

        switch ($type) {
            case 'select':
                $options = $fieldCfg['options'];
                $html = $this->select($value, $name, $label, $options);
                break;

            case 'radio':
                $options = $fieldCfg['options'];
                $html = $this->radio($value, $name, $label, $options);

                break;
            case 'number':
                $min = array_key_exists('min', $fieldCfg)
                    ? $fieldCfg['min']
                    : null;
                $max = array_key_exists('max', $fieldCfg)
                    ? $fieldCfg['max']
                    : null;
                $step = array_key_exists('step', $fieldCfg)
                    ? $fieldCfg['step']
                    : null;

                $html = $this->number($value, $name, $label, $min, $max, $step);

                break;

            case 'text':
                $html = $this->text($value, $name, $label);

                break;

            default:
                $html = '';
                break;
        }

        return $html;
    }

    /**
     * Prints a standard text form field.
     *
     * @param string $value
     * @param string $name
     * @param string $label
     * @return string
     */
    public function text(string $value, string $name, string $label): string
    {
        $html = <<<HTML
            <div class="uk-margin">
                <label class="uk-form-label" for="{$name}">{$label}</label>
                <input class="uk-input" type="text" id="{$name}" name="{$name}" value="{$value}" />
            </div>
HTML;

        return $html;
    }

    /**
     * Prints a standard number form field.
     *
     * @param string $value
     * @param string $name
     * @param string $label
     * @param float $min
     * @param float $max
     * @param float $step
     * @return string
     */
    public function number(
        string $value,
        string $name,
        string $label,
        float $min = null,
        float $max = null,
        float $step = null
    ): string {
        $min = !is_null($min) && is_float($min) ? "min=\"{$min}\"" : '';
        $max = !is_null($max) && is_float($max) ? "max=\"{$max}\"" : '';
        $step = !is_null($step) && is_float($step) ? "step=\"{$step}\"" : '';

        $html = <<<HTML
        <div class="uk-margin">
            <label class="uk-form-label" for="{$name}">{$label}</label>
            <input class="uk-input" type="number" {$min} {$max} {$step} id="{$name}" name="{$name}" value="{$value}" />
       </div>
HTML;

        return $html;
    }

    /**
     * Prints a default radio form field.
     *
     * @param integer $value
     * @param string $name
     * @param string $label
     * @param array $options
     * @return string
     */
    public function radio(
        int $value,
        string $name,
        string $label,
        array $options
    ): string {
        $html =
            '<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">';
        $html .= "<div class=\"uk-form-label\">{$label}</div>";
        $html .= '<div class="uk-form-controls">';

        foreach ($options as $key => $optValue) {
            $checked = $value == $key ? 'checked="checked"' : '';

            $html .= "<label><input class=\"uk-radio\" type=\"radio\" name=\"{$name}\" {$checked} value=\"{$key}\">{$optValue}</label>";
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Prints a default select form field.
     *
     * @param string $value
     * @param string $name
     * @param string $label
     * @param array $options
     * @return string
     */
    public function select(
        string $value,
        string $name,
        string $label,
        array $options
    ): string {
        $html = '<div class="uk-margin">';
        $html .= "<label class=\"uk-form-label\" for=\"{$name}\">{$label}</label>";
        $html .= '<div class="uk-form-controls">';
        $html .= "<select class=\"uk-select\" id=\"{$name}\" name=\"{$name}\">";

        foreach ($options as $key => $optValue) {
            $selected = $value === $key ? 'selected' : '';
            $html .= "<option value=\"{$key}\" {$selected}>{$optValue}</option>";
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Prints a default textarea form field.
     *
     * @param string $value
     * @param string $name
     * @param string $label
     * @param array $options
     * @return string
     */
    public function textarea(string $value, string $name, string $label): string
    {
        $html = <<<HTML
            <div class="uk-margin">
                <label class="uk-form-label" for="{$name}">{$label}</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea" id="{$name}" name="{$name}" rows="5" placeholder="Textarea">{$value}</textarea>
                </div>
            </div>
HTML;

        return $html;
    }

    public function color(string $value, string $name, string $label): string
    {
        $html = <<<HTML
        <div class="uk-margin">
            <label class="uk-form-label" for="{$name}">{$label}</label>
            <div class="uk-form-controls">
                <button class="uk-color-picker">
                    <span class="uk-color-preview"></span>
                </button>
                <input type="hidden" name="{$name}" id="{$name}" value="{$value}">
            </div>
        </div>
HTML;

        return $html;
    }
}

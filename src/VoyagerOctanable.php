<?php

namespace TCG\Voyager;

use Illuminate\Support\Str;
use TCG\Voyager\Events\FormFieldsRegistered;
use TCG\Voyager\FormFields\After\DescriptionHandler;

class VoyagerOctanable extends Voyager
{
    public function __construct()
    {
        parent::__construct();

        $this->registerFormFields();
    }
    protected function registerFormFields()
    {
        $formFields = [
            'checkbox',
            'multiple_checkbox',
            'color',
            'date',
            'file',
            'image',
            'multiple_images',
            'media_picker',
            'number',
            'password',
            'radio_btn',
            'rich_text_box',
            'code_editor',
            'markdown_editor',
            'select_dropdown',
            'select_multiple',
            'text',
            'text_area',
            'time',
            'timestamp',
            'hidden',
            'coordinates',
        ];

        foreach ($formFields as $formField) {
            $class = Str::studly("{$formField}_handler");

            $this->addFormField("\\TCG\\Voyager\\FormFields\\{$class}");
        }

        $this->addAfterFormField(DescriptionHandler::class);

        event(new FormFieldsRegistered($formFields));
    }
}

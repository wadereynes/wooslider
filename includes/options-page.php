<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('after_setup_theme', 'load_carbon_fields');
add_action('carbon_fields_register_fields', 'create_options_page');

function load_carbon_fields() {

    \Carbon_Fields\Carbon_Fields::boot();

}

function create_options_page() {
    Container::make('theme_options', __('Theme Options'))
    ->add_fields( array(
        Field::make('text', 'wooslider_plugin_title', __('Featured Product Title'))->set_help_text('Enter your product feature title'),
        Field::make('text', 'wooslider_recepients', __('Recipient Email')),
        Field::make('textarea', 'wooslider_message', __('Confirmation Message')),
    ));
}
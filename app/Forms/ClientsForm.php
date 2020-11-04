<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ClientsForm extends Form
{
    public function buildForm()
    {
        $this->add("name", "text")
        	->add("email", "email")
        	->add("handphone", "text")
        	->add("telp", "text")
            ->add("city_id", "select", [
                'attr'        => ['class' => 'form-control select2'],
                'choices'     =>  \App\Models\City::pluck("name", "city_id")->toArray(),
                'empty_value' => '- Select City -',
                'label'       => 'City'
            ])
        	->add("address", "textarea");
    }
}

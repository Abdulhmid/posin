<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class RolesForm extends Form
{
    public function buildForm()
    {
        $this->add("label", "text")
        	->add("name", "text");
    }
}

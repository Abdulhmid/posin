<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Models\Roles_client;
use Models\Outlets;

class UsersForm extends Form
{
    public function buildForm()
    {
        $selectedRc=\DB::table('roles_client')->first()->id;
        $selectedOutlets=\DB::table('outlets')->first()->id;
        $this->add("username", "text")
        	->add("name", "text")
        	->add("email", "email")
            ->add('password','password')
            ->add('password_confirmation','password')
            ->add("id_role", "select", [
                'attr'        => ['class' => 'form-control select2','style'=>'display:none'],
                'choices'     =>  \App\Models\Roles_client::pluck("id_role", "id")->toArray(),
                'empty_value' => '- Select Role -',
                'selected' => $selectedRc,
                'label'       => false
            ])
            ->add("id_outlet", "select", [
                'attr'        => ['class' => 'form-control select2','style'=>'display:none'],
                'choices'     =>  \App\Models\Outlets::pluck("name", "id")->toArray(),
                'empty_value' => '- Select Outlets -',
                'selected' => $selectedOutlets,
                'label'       => false
            ])
        	->add("address", "textarea");
    }
}

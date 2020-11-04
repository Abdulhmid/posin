<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ModulesForm extends Form
{
    public function buildForm()
    {
		$this

        ->add('module_name', 'text', [
            'attr' => ['placeholder' => 'Module Name', 'id' => 'module_name'] ,
            'wrapper' => [
                'class' => 'form-group'
            ],
            'label'     => 'Nama Modul'
        ])

        ->add('module_name_alias', 'text', [
            'attr' => ['placeholder' => 'Module Alias Name'] ,
            'wrapper' => [
                'class' => 'form-group'
            ],
            'label'     => 'Nama Alias Modul'
        ])

        ->add('function', 'text', [
        	'attr' => [
                'class' => 'form-control', 
                'id' => 'tagType', 
                'placeholder' => 'Name Function Controller'
            ],
            'wrapper' => [
                'class' => 'form-group'
            ],
            'label'     => 'Nama Fungsi',
            'help_block'  => [
                'text'           => 'CATATAN: Klik Jika Ingin Mengubah.',
                'tag'            => 'p',
                'helpBlockAttrs' => ''
            ]
        ])

        ->add('function_alias', 'text', [
        	'attr' => [
                'class' => 'form-control', 
                'id' => 'tagTypeAlias', 
                'placeholder' => 'Name Function Controller'
            ],
            'wrapper' => [
                'class' => 'form-group'
            ],
            'label'     => 'Nama Alias Fungsi',
            'help_block'  => [
                'text'           => 'CATATAN: Klik Jika Ingin Mengubah.',
                'tag'            => 'p',
                'helpBlockAttrs' => ''
            ]
        ])
		->add('description', 'textarea', [
			'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Module Desciption'
            ],
			'label' => 'Keterangan'
		]);
    }
}

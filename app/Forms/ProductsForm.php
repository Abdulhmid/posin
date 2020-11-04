<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ProductsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add("id_supplier", "select", [
                'attr'        => ['class' => 'form-control select2'],
                'choices'     =>  \App\Models\Suppliers::pluck("name", "id")->toArray(),
                'empty_value' => '- Pilih Suppliers -',
                'label'       => 'Suppliers'
            ])
            ->add("id_category", "select", [
                'attr'        => ['class' => 'form-control select2'],
                'choices'     =>  \App\Models\Category::pluck("name", "id")->toArray(),
                'empty_value' => '- Pilih Kategori -',
                'label'       => 'Kategori'
            ])
        	->add("name", "text")
        	->add("purchase_price", "number",[
                'attr' => ['min'=>0]
            ])
            ->add("procentage", "number",[
                'label' => 'Prosentase Harga Jual (%) Harga Beli + (%*Harga Beli)'
            ])
        	->add("selling_price", "number",[
        		'attr' => ['min'=>0,'readonly'=>true]
        	])
        	->add("description", "textarea");
    }
}

<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class OutForm extends Form
{
    public function buildForm()
    {
    	$listProducts = \App\Models\Products::where('id_client',\Auth::user()->id_client)
    						->pluck("name", "id")
    						->toArray();
    	$listOutlets = \App\Models\Outlets::where('id_client',\Auth::user()->id_client)
    						->pluck("name", "id")
    						->toArray();
        $this
            ->add("id_supplier", "select", [
                'attr'        => ['class' => 'form-control select2'],
                'choices'     =>  \App\Models\Suppliers::pluck("name", "id")->toArray(),
                'empty_value' => '- Pilih Suppliers -',
                'label'       => 'Suppliers'
            ])
            ->add("id_outlet", "select", [
                'attr'        => ['class' => 'form-control select2'],
                'choices'     => $listOutlets,
                'empty_value' => '- Pilih Outlet -',
                'label'       => 'Outlet'
            ])
            ->add("id_item", "select", [
                'attr'        => ['class' => 'form-control select2'],
                'choices'     =>  $listProducts,
                'empty_value' => '- Pilih Product -',
                'label'       => 'Product'
            ])
        	->add("total", "number",[
        		'attr' => ['min' => 0],
                'label' => 'Total Pengembalian'
        	])
        	->add("description", "textarea");
    }
}

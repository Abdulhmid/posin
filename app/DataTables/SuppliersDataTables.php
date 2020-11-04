<?php

namespace App\DataTables;

use App\Models\Suppliers;
use Yajra\Datatables\Services\DataTable;

class SuppliersDataTables extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', function ($row) {
                $column = "<a href=\"" . route('categories.edit', $row->id). "\" class=\"btn btn-success btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Edit\">
                    <i class=\"fa fa-pencil\"></i> Edit
                </a>
                <a href=\"" . route('categories.destroy', $row->id) . "\" class=\"btn btn-danger btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Delete\" onclick=\"swal_alert(this,null,'delete','" . csrf_token() . "'); return false;\">
                    <i class=\"fa fa-trash-o\"></i> Delete
                </a>";
                return $column;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Suppliers::query();

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->addAction(['width' => '10px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => [
                'title' => 'Nama',
                'width' => '45px'
            ],
            'telp' => [
                'title' => 'Telp',
                'width' => '45px'
            ],
            'city_id' => [
                'title' => 'Kota',
                'width' => '45px'
            ],
            'address' => [
                'title' => 'Alamat',
                'width' => '45px'
            ],
            'description' => [
                'title' => 'Keterangan',
                'width' => '45px'
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'suppliersdatatables_' . time();
    }
}

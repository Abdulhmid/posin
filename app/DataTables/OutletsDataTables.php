<?php

namespace App\DataTables;

use App\Models\Outlets;
use Yajra\Datatables\Services\DataTable;

class OutletsDataTables extends DataTable
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
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('action', function ($row) {
                $column = "<a href=\"" . route('outlets.edit', $row->id). "\" class=\"btn btn-success btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Edit\">
                    <i class=\"fa fa-pencil\"></i> Edit
                </a>
                <a href=\"" . route('outlets.destroy', $row->id) . "\" class=\"btn btn-danger btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Delete\" onclick=\"swal_alert(this,null,'delete','" . csrf_token() . "'); return false;\">
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
        $query = Outlets::query();

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
                    ->addAction(['width' => '80px'])
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
                'title' => 'Name',
                'width' => '5'
            ],
            'email' => [
                'title' => 'Email',
                'width' => '5'
            ],
            'handphone' => [
                'title' => 'Handphone',
                'width' => '5'
            ],
            'telp' => [
                'title' => 'Telp',
                'width' => '5'
            ],
            'address' => [
                'title' => 'Address',
                'width' => '25'
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
        return 'outletsdatatables_' . time();
    }
}

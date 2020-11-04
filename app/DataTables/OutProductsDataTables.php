<?php

namespace App\DataTables;

use App\Models\OutProducts;
use Yajra\Datatables\Services\DataTable;

class OutProductsDataTables extends DataTable
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
            ->editColumn('id_supplier', function ($row) {
                return $row->supplier->name;
            })
            ->editColumn('id_item', function ($row) {
                return $row->product->name;
            })
            ->editColumn('id_outlet', function ($row) {
                return $row->outlet->name;
            })
            ->editColumn('created_at', function ($row) {
                return \GlobalHelper::formatDate($row->created_at);
            })
            ->editColumn('updated_at', function ($row) {
                return \GlobalHelper::formatDate($row->updated_at);
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
        $query = OutProducts::with(['supplier','outlet','product'])
                    ->select('*');

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
            'id_supplier' => [
                'title' => 'Supplier',
                'width' => '21px'
            ],
            'id_item' => [
                'title' => 'Barang',
                'width' => '21px'
            ],
            'id_outlet' => [
                'title' => 'Outlet',
                'width' => '21px'
            ],
            'total' => [
                'title' => 'Barang Dikembalikan',
                'width' => '11px'
            ],
            'description' => [
                'title' => 'Keterangan',
                'width' => '21px'
            ],
            'created_at' => [
                'title' => 'Di Buat',
                'width' => '11px'
            ],
            'updated_at' => [
                'title' => 'Di Ubah',
                'width' => '11px'
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'categoriesdatatables_' . time();
    }
}

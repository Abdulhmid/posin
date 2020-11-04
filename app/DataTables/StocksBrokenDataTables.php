<?php

namespace App\DataTables;

use App\Models\Products_stocks_broken;
use App\Models\Outlets;
use Yajra\Datatables\Services\DataTable;

class StocksBrokenDataTables extends DataTable
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
            ->editColumn('id_item', function ($row) {
                return $row->product->name;
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
        $arrayOutlet = Outlets::where('id_client',\Auth::user()->id_client)->pluck('id')->toArray();
        $query = Products_stocks_broken::with(['product'])
                    ->whereIn('id_outlet',$arrayOutlet)
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
            'id_item' => [
                'title' => 'Nama',
                'width' => '45px'
            ],
            'stok' => [
                'title' => 'Total Stok',
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
        return 'categoriesdatatables_' . time();
    }
}

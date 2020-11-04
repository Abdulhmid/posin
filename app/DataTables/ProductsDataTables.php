<?php

namespace App\DataTables;

use App\Models\Products;
use App\Models\Products_price;
use Yajra\Datatables\Services\DataTable;

class ProductsDataTables extends DataTable
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
            ->editColumn('id_category', function ($row) {
                return $row->categories->name;
            })
            ->editColumn('id', function ($row) {
                $price = Products_price::where('id_item',$row->id)->first();
                return "Harga Beli = ".$price->purchase_price."<br/>".
                       "Harga Jual = ".$price->selling_price;
            })
            ->addColumn('action', function ($row) {
                $column = "<a href=\"" . route('products.edit', $row->id). "\" class=\"btn btn-success btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Edit\">
                    <i class=\"fa fa-pencil\"></i> Edit
                </a>
                <a href=\"" . route('products.destroy', $row->id) . "\" class=\"btn btn-danger btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Delete\" onclick=\"swal_alert(this,null,'delete','" . csrf_token() . "'); return false;\">
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
        $query = Products::with(['supplier','categories','pricelist'])
                    ->where('id_client',\Auth::user()->id_client)
                    ->select('id','id_client','id_supplier','id_category','name','description');

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
                'width' => '17px'
            ],
            'id_supplier' => [
                'title' => 'Supplier',
                'width' => '17px'
            ],
            'id_category' => [
                'title' => 'Kategori',
                'width' => '17px'
            ],
            'id' => [
                'title' => 'Price',
                'width' => '17px'
            ],
            'description' => [
                'title' => 'Keterangan',
                'width' => '17px'
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
        return 'productsdatatables_' . time();
    }
}

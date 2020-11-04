<?php

namespace App\DataTables;

use App\Models\Users;
use Yajra\Datatables\Services\DataTable;

class UsersDataTables extends DataTable
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
            ->editColumn('id_outlet', function ($row) {
                return isset($row->outlet->name)?$row->outlet->name:"-";
            })
            ->addColumn('action', function ($row) {
                $column = "<a href=\"" . route('users.edit', $row->id). "\" class=\"btn btn-success btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Edit\">
                    <i class=\"fa fa-pencil\"></i> Edit
                </a>
                <a href=\"" . route('users.destroy', $row->id) . "\" class=\"btn btn-danger btn-xs\" data-toggle=\"tooltip\" data-original-title=\"Delete\" onclick=\"swal_alert(this,null,'delete','" . csrf_token() . "'); return false;\">
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
        if (\Auth::user()->username=="superadmin") {
            $query = Users::with(['role_client','outlet'])->select('*');
        }else{
            $query = Users::with(['role_client','outlet'])
                        ->where('id_client',\Auth::user()->id_client)
                        ->select('*');
        }

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
            'username' => [
                'title' => 'Username',
                'width' => '5'
            ],
            'name' => [
                'title' => 'Name',
                'width' => '5'
            ],
            'email' => [
                'title' => 'Email',
                'width' => '5'
            ],
            'id_outlet' => [
                'title' => 'Outlets',
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
        return 'usersdatatables_' . time();
    }
}

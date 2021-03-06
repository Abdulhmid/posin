<?php

namespace App\Services;

use DB;
use Auth;
use Config;
use Exception;
use App\Models\Roles;
use App\Models\Roles_client;
use Illuminate\Support\Facades\Schema;

class RolesService
{
    public function __construct(
        Roles $model,
        Roles_client $model_client
    ) {
        $this->model = $model;
        $this->model_client = $model_client;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */


    /**
     * All clients
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Paginated clients
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function paginated()
    {
        return $this->model->paginate(env('paginate', 25));
    }

    /**
     * Find a role
     * @param  integer $id
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function find($id)
    {
        return $this->model->find($id);
    }


    /**
     * Search the clients
     * @param  string $input
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function search($input)
    {
        $query = $this->model->orderBy('name', 'desc');

        $columns = Schema::getColumnListing('clients');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input.'%');
        };

        return $query->paginate(env('paginate', 25));
    }

    /**
     * Find Role by name
     *
     * @param string $name
     *
     * @return \Illuminate\Support\Collection|null|static|Role
     */
    public function findByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Create a role
     *
     * @param  array $input
     * @return Role
     */
    public function create($input)
    {
        try {
            $row = $this->model->create($input);
            $this->createRole($row->id);
            return $row;
        } catch (Exception $e) {
            throw new Exception("Failed to create role", 1);
        }
    }

    private function createRole($id){
        $this->model_client->create([
            'id_role' => $id,
            'id_client' => \Auth::user()->id_client
        ]);
    }

    /**
     * Update a role
     *
     * @param  int $id
     * @param  array $input
     * @return boolean
     */
    public function update($id, $input)
    {

        $role = $this->model->find($id);
        $role->update($input);

        return $role;
    }

    /**
     * Destroy the role
     *
     * @param  int $id
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $result = $this->model->find($id)->delete();

            return $result;
        } catch (Exception $e) {
            throw new Exception("We were unable to delete this role", 1);
        }

        return $result;
    }
}

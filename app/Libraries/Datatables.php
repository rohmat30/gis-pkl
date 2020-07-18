<?php

namespace App\Libraries;

use Config\Database;
use Config\Services;

class Datatables
{
    private $model;
    private $request;
    private $response;

    private  $filters = array();

    private $page;

    // datatables
    private $addColumns = array();
    private $length;
    private $start;
    private $columns;
    private $order;
    private $search;

    public function __construct($model)
    {
        $this->request  = service('request');
        $this->response = service('response');

        // $modelname = $namespace."\"";
        $this->model = new $model;

        // config
        $this->length  = $this->request->getGetPost('length');
        $this->start   = $this->request->getGetPost('start');
        $this->columns = $this->request->getGetPost('columns');
        $this->order   = $this->request->getGetPost('order');
        $this->search  = $this->request->getGetPost('search');

        $this->page = ceil($this->start / $this->length) + 1;
    }

    public function select($select, $esc = NULL)
    {
        $this->model->select($select, $esc);
        return $this;
    }

    public function join($table, $cond, $type = '', $esc = NULL)
    {
        $this->model->join($table, $cond, $type, $esc);
        return $this;
    }

    public function groupBy($by, $esc = NULL)
    {
        $this->model->groupBy($by, $esc);
        return $this;
    }


    public function orderBy($orderBy, $direction = '', $esc = NULL)
    {
        $this->model->orderBy($orderBy, $direction, $esc);
        return $this;
    }

    public function addColumn($column, $content, $match_replacement = NULL)
    {
        // contoh penggunaan
        // $dt->addColumn('uri', site_url('/example/$1/edit'),'id');
        // atau
        // $dt->addColumn('uri', ['edit' => site_url('/example/$1/edit'),'delete' => site_url('/example/$1/delete')],'id');

        $this->addColumns[$column] = array('content' => $content, 'replacement' => $match_replacement);
        return $this;
    }

    public function generate()
    {
        $this->filtering();
        $this->ordering();

        $recordsTotal = $this->recordsTotal();
        $this->searching();


        $data = $this->output();
        $recordsFiltered = $this->model->pager->getDetails()['total'];


        $data = (object) array(
            'draw'            => $this->request->getGetPost('draw'),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        );

        $this->response->setHeader(csrf_header(), csrf_hash());
        return $this->response->setJSON($data);
    }

    private function output()
    {
        $result = $this->model->paginate($this->length, 'default', $this->page);
        $output = array_map(function ($data) {
            $tempAddColumns = (object) array();

            if (method_exists($data, 'jsonSerialize')) {
                $data = $data->jsonSerialize();
            }

            // generate tambah kolom
            array_map(function ($column, $key) use ($data, $tempAddColumns) {
                $replace = $column['replacement'];
                $content = $column['content'];
                $expr    = '/' . substr(str_repeat('(.+),', count(explode(',', $replace))), 0, -1) . '/';

                if (is_array($content)) {
                    $tempAddColumns->$key = array_map(function ($con) use ($data, $expr, $replace) {
                        $txt = preg_replace($expr, $con, $replace);
                        return (str_replace(array_keys((array) $data), array_values((array) $data), $txt));
                    }, $content);
                } else {
                    $txt = preg_replace($expr, $content, $replace);
                    // $data = (array) $data;
                    $tempAddColumns->$key = str_replace(array_keys((array) $data), array_values((array) $data), $txt);
                }

                return $tempAddColumns;
            }, $this->addColumns, array_keys($this->addColumns));

            // menggabungkan tambah kolom dengan data dari database per baris
            return (object) array_merge((array) $data, (array) $tempAddColumns);
        }, $result);


        return $output;
    }

    private function recordsTotal()
    {
        $clone = clone (!empty($this->model->builder) ? $this->model->builder : $this->model);
        if ($this->model->useSoftDeletes) {
            $clone->where($this->model->table . '.' . $this->model->deletedField, NULL);
        }
        $total = $clone->countAllResults();
        unset($clone);
        return $total;
    }

    private function filtering()
    {
        if (count($this->filters) > 0) {
            $this->model->groupStart();
            foreach ($this->filters as $key => $filter) {
                $method = $filter['method'];
                unset($filter['method']);
                call_user_func_array(array($this->model, $method), $filter);
            }
            $this->model->groupEnd();
        }
        return $this;
    }

    private function searching()
    {

        if (!empty($this->search['value'])) {
            // field dari datatables
            $columns = $this->columns;
            // field dari database
            $fields = $this->getFields();

            /**
             * mendaptakan semua key atau index
             * searchable = true
             */
            $filter_columns = array_keys(filter_var_array(array_column($columns, 'searchable'), FILTER_VALIDATE_BOOLEAN), true);

            // menghapus searchable = false dari field datatables
            $searchable = array_map(function ($data) use ($columns) {
                return $columns[$data];
            }, $filter_columns);

            // filter field dari sesuai yang ada di fields database
            $search_columns = array_intersect($fields, array_column($searchable, 'data'));

            if (count($search_columns) > 0) {
                $this->model->groupStart();
                $num = 0;
                foreach ($search_columns as $col) {
                    if ($num == 0) {
                        $this->model->like($col, $this->search['value']);
                    } else {
                        $this->model->orLike($col, $this->search['value']);
                    }
                    $num++;
                }
                $this->model->groupEnd();
            }
        }
        return $this;
    }


    private function ordering()
    {
        $fields = $this->getFields();

        // generate orderBy
        if (isset($this->order)) {
            foreach ($this->order as $key => $order) {
                $orderByCheck = $this->columns[$order['column']]['orderable'];
                $orderBy      = $this->columns[$order['column']]['data'];
                if ($orderByCheck && in_array($orderBy, $fields)) {
                    $direction = $order['dir'];
                    $this->model->orderBy($orderBy, $direction);
                }
            }
        }
        return $this;
    }

    private function getFields()
    {
        $clone = clone (!empty($this->model->builder) ? $this->model->builder : $this->model);
        $query = $clone->getCompiledSelect();

        $fields = $this->model->query($query)->getFieldNames();
        unset($clone);
        return $fields;
    }

    // magic method
    public function __call($method, $params)
    {
        $builder = (!empty($this->model->builder) ? $this->model->builder : $this->model);
        if (method_exists($builder, $method)) {
            $this->filters[] = array_merge($params, array('method' => $method));
            return $this;
        }
    }
}

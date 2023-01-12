<?php

class Datatables
{
    /**
     * DB.
     *
     * @var mixed
     */
    protected $db;

    /**
     * Input.
     *
     * @var mixed
     */
    protected $input;

    /**
     * Table Name.
     *
     * @var string
     */
    protected $table;

    /**
     * Columns.
     *
     * @var array
     */
    protected $columns;

    /**
     * Keyword.
     *
     * @var string
     */
    protected $keyword;

    /**
     * Join.
     *
     * @var array
     */
    protected $joins = [];

    /**
     * Where.
     *
     * @var array
     */
    protected $conditions = [];

    public function __construct()
    {
        $codeigniter = &get_instance();

        $this->input = $codeigniter->input;
        $this->db = $codeigniter->db;
    }

    /**
     * Set Table.
     *
     * @param string $table
     *
     * @return Datatables
     */
    public function table(string $table): Datatables
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Join Table.
     *
     * @param string  $table
     * @param string  $key
     * @param ?string $type
     *
     * @return Datatables
     */
    public function join(string $table, string $key, ?string $type = 'INNER'): Datatables
    {
        $this->joins[] = ['table' => $table, 'key' => $key, 'type' => $type];

        return $this;
    }

    /**
     * Where.
     *
     * @param string  $key
     * @param ?string $value
     *
     * @return Datatables
     */
    public function where(string $key, ?string $value): Datatables
    {
        $this->conditions[] = ['key' => $key, 'value' => $value];

        return $this;
    }

    /**
     * Draw.
     *
     * @return array
     */
    public function draw(): array
    {
        // Init Data
        $this->keyword = $this->input->post('search')['value'] ?? null;
        $this->columns = $this->input->post('columns') ?? [];

        return $this->format($this->result(), $this->count());
    }

    /**
     * Select.
     *
     * @return void
     */
    private function select(): void
    {
        $columns = [];

        foreach ($this->columns as $column) {
            $name = empty($column['name']) ? $column['data'] : $column['name'];
            $alias = $column['data'];

            $columns[] = "{$name} as {$alias}";
        }

        $this->db->select($columns);
    }

    /**
     * Filter.
     *
     * @return void
     */
    private function filter(): void
    {
        if ($this->keyword) {
            $this->db->group_start();

            $index = 1;
            foreach ($this->columns as $column) {
                if ($column['searchable'] === 'false') {
                    continue;
                }

                $search = empty($column['name']) ? $column['data'] : $column['name'];

                if ($index > 1) {
                    $this->db->or_like($search, $this->keyword);
                } else {
                    $this->db->like($search, $this->keyword);
                }

                $index++;
            }

            $this->db->group_end();
        }

        foreach ($this->conditions as $condition) {
            $this->db->where($condition['key'], $condition['value']);
        }
    }

    /**
     * Order Row.
     *
     * @return void
     */
    private function order(): void
    {
        $direction = $this->input->post('order')[0]['dir'];
        $index = $this->input->post('order')[0]['column'];
        $column = $this->input->post('columns')[$index]['data'];

        $this->db->order_by($column, $direction);
    }

    /**
     * Limit.
     *
     * @return void
     */
    private function limit(): void
    {
        $limit = $this->input->post('length', true);
        $start = $this->input->post('start', true);

        $this->db->limit($limit, $start);
    }

    private function joinTable(): void
    {
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['key'], $join['type']);
        }
    }

    /**
     * Format Data.
     *
     * @param array $rows
     *
     * @return array
     */
    private function format(array $rows, int $total): array
    {
        $option = [
            'draw'            => intval($this->input->post('draw') ?? 1),
            'recordsFiltered' => $total,
            'recordsTotal'    => $total,
            'data'            => $rows,
        ];

        return $option;
    }

    /**
     * Result Array.
     *
     * @return array
     */
    private function result(): array
    {
        $this->select();

        $this->filter();

        $this->joinTable();

        $this->limit();

        $this->order();

        return $this->db->get($this->table)->result();
    }

    /**
     * Count.
     *
     * @return int
     */
    private function count(): int
    {
        $this->filter();

        $this->joinTable();

        return $this->db->get($this->table)->num_rows();
    }
}

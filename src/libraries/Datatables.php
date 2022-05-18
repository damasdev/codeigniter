<?php
class Datatables
{
    /**
     * DB
     *
     * @var mixed
     */
    protected $db;

    /**
     * Input
     *
     * @var mixed
     */
    protected $input;

    /**
     * Table Name
     *
     * @var string
     */
    protected $table;

    /**
     * Columns
     *
     * @var array
     */
    protected $columns;

    /**
     * Keyword
     *
     * @var string
     */
    protected $keyword;

    public function __construct()
    {
        $codeigniter = &get_instance();

        $this->input = $codeigniter->input;
        $this->db = $codeigniter->db;
    }

    /**
     * Set Table
     *
     * @param  string $table
     * @return void
     */
    public function table(string $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Draw
     *
     * @return array
     */
    public function draw(): array
    {
        // Init Data
        $this->keyword = $this->input->post('search')['value'] ?? NULL;
        $this->columns = $this->input->post('columns') ?? [];

        return $this->format($this->result(), $this->count());
    }

    /**
     * Select
     *
     * @return void
     */
    private function select(): void
    {
        $columns = [];

        foreach ($this->columns as $column) {
            $columns[] = $column['data'];
        }

        $this->db->select($columns);
    }

    /**
     * Filter
     *
     * @return void
     */
    private function filter(): void
    {
        if ($this->keyword) {
            $this->db->group_start();

            $index = 1;
            foreach ($this->columns as $column) {
                if ($index > 1) {
                    $this->db->or_like($column['data'], $this->keyword);
                } else {
                    $this->db->like($column['data'], $this->keyword);
                }

                $index++;
            }

            $this->db->group_end();
        }
    }

    private function order()
    {
        $direction = $this->input->post('order')[0]['dir'];
        $index = $this->input->post('order')[0]['column'];
        $column = $this->input->post('columns')[$index]['data'];
        $this->db->order_by($column, $direction);
    }

    /**
     * Limit
     *
     * @return void
     */
    private function limit(): void
    {
        $limit = $this->input->post('length', true);
        $start = $this->input->post('start', true);

        $this->db->limit($limit, $start);
    }

    /**
     * Format Data
     *
     * @param  array $rows
     * @return array
     */
    private function format(array $rows, int $total): array
    {
        $option = [
            'draw' => intval($this->input->post('draw') ?? 1),
            'recordsFiltered' => $total,
            'recordsTotal' => $total,
            'data' => $rows,
        ];

        return $option;
    }

    /**
     * Result Array
     *
     * @return array
     */
    private function result(): array
    {
        $this->select();

        $this->filter();

        $this->limit();

        $this->order();

        return $this->db->get($this->table)->result();
    }

    /**
     * Count
     *
     * @return int
     */
    private function count(): int
    {
        $this->filter();

        return $this->db->get($this->table)->num_rows();
    }
}

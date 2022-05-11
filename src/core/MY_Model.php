<?php

/**
 * MY_Model
 */
class MY_Model extends CI_Model
{

    /**
     * Table Name
     *
     * @var string
     */
    protected $table;

    /**
     * Table Alias
     *
     * @var string
     */
    protected $alias;

    /**
     * All Result
     *
     * @param  array $conditions
     * @return ?array
     */
    protected function all(array $conditions = []): ?array
    {
        return $this->db->where($conditions)->get($this->table)->result();
    }

    /**
     * Find One
     *
     * @param  array $conditions
     * @return ?stdClass
     */
    protected function find(array $conditions = []): ?stdClass
    {
        return $this->db->where($conditions)->get($this->table)->row();
    }

    /**
     * Count Data
     *
     * @param  array $conditions
     * @return ?int
     */
    protected function count(array $conditions = []): ?int
    {
        return $this->db->where($conditions)->get($this->table)->num_rows();
    }

    /**
     * Insert Data
     *
     * @param  array $data
     * @return void
     */
    protected function insert(array $data): void
    {
        if (isBatch($data)) {
            $this->db->insert_batch($this->table, $data);
        } else {
            $this->db->insert($this->table, $data);
        }
    }

    /**
     * Update Data
     *
     * @param  array $data
     * @param  array $conditions
     * @return void
     */
    protected function update(array $data, array $conditions): void
    {
        $this->db->where($conditions)->update($this->table, $data);
    }

    /**
     * Delete Data
     *
     * @param  array $conditions
     * @return void
     */
    protected function delete(array $conditions): void
    {
        $this->db->where($conditions)->delete($this->table);
    }
}

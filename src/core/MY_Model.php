<?php

/**
 * MY_Model.
 */
class MY_Model extends CI_Model
{
    /**
     * Table Name.
     *
     * @var string
     */
    public $table;

    /**
     * All Result.
     *
     * @param array $conditions
     *
     * @return ?array
     */
    public function all(array $conditions = []): ?array
    {
        return $this->db->where($conditions)->get($this->table)->result();
    }

    /**
     * Find One.
     *
     * @param array $conditions
     *
     * @return ?stdClass
     */
    public function find(array $conditions = []): ?stdClass
    {
        return $this->db->where($conditions)->get($this->table)->row();
    }

    /**
     * Count Data.
     *
     * @param array $conditions
     *
     * @return ?int
     */
    public function count(array $conditions = []): ?int
    {
        return $this->db->where($conditions)->from($this->table)->count_all_results();
    }

    /**
     * Store Data.
     *
     * @param array $data
     *
     * @return void
     */
    public function insert(array $data): void
    {
        $this->db->insert($this->table, $data);
    }

    /**
     * Update Data.
     *
     * @param array $data
     * @param array $conditions
     *
     * @return void
     */
    public function update(array $data, array $conditions): void
    {
        $this->db->where($conditions)->update($this->table, $data);
    }

    /**
     * Destroy Data.
     *
     * @param array $conditions
     *
     * @return void
     */
    public function delete(array $conditions): void
    {
        $this->db->where($conditions)->delete($this->table);
    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FeatureModel extends CI_Model
{
	const TABLE_NAME = "features";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Insert Data
	 *
	 * @param  array $data
	 * @return void
	 */
	public function insert(array $data): void
	{
		$this->db->insert(self::TABLE_NAME, $data);
	}

	/**
	 * Update Data
	 *
	 * @param  int $id
	 * @param  array $data
	 * @return void
	 */
	public function update(int $id, array $data): void
	{
		$this->db->where('id', $id)->update(self::TABLE_NAME, $data);
	}

	/**
	 * Get All Features
	 *
	 * @return array
	 */
	public function all(): array
	{
		return $this->db->get(self::TABLE_NAME)->result();
	}

	/**
	 * Find By ID
	 *
	 * @param  int $id
	 * @return ?stdClass
	 */
	public function find(int $id): ?stdClass
	{
		return $this->db->where('id', $id)->get(self::TABLE_NAME)->row();
	}

	/**
	 * Delete Feature
	 *
	 * @param  int $id
	 * @return void
	 */
	public function delete(int $id): void
	{
		$this->db->where('id', $id)->delete(self::TABLE_NAME);
	}

	/**
	 * Get All Feature
	 *
	 * @param  int $role_id
	 * @return array
	 */
	public function role(int $role_id): array
	{
		$this->db->select([
			'features.id',
			'features.module',
			'features.class',
			'features.method',
		]);

		$this->db->join('features_acl', 'features.id = features_acl.feature_id');

		return $this->db->where('features_acl.role_id', $role_id)->get(self::TABLE_NAME)->result();
	}
}

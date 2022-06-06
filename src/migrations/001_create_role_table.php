<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_role_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'type' => [
                'type' => 'ENUM("admin","user")',
                'default' => 'user',
                'null' => FALSE
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roles', TRUE);

        $data = [
            [
                'id' => 1,
                'name' => 'Administrator',
                'code' => 'root',
                'type' => 'admin'
            ],
            [
                'id' => 2,
                'name' => 'User',
                'code' => 'user',
                'type' => 'user',
            ]
        ];

        $this->db->insert_batch('roles', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('roles', TRUE);
    }
}

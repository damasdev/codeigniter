<?php

class Migration_Create_role_table extends CI_Migration
{
    public function __construct()
    {
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50
            ]
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('code', true);
        $this->dbforge->create_table('roles', true);

        $data = [
            [
                'code' => 'root',
                'name' => 'Super Administrator'
            ],
            [
                'code' => 'admin',
                'name' => 'Administrator'
            ],
            [
                'code' => 'user',
                'name' => 'User'
            ],
        ];

        $this->db->insert_batch('roles', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('roles', true);
    }
}

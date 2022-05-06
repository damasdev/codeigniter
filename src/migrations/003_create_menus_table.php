<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_menus_table extends CI_Migration
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
            'parent' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => NULL
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => NULL
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => NULL
            ],
            'number' => [
                'type' => 'INT',
                'constraint' => 11
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('parent');
        $this->dbforge->create_table('menus', TRUE);

        $data = [
            [
                'id' => 1,
                'parent' => NULL,
                'name' => 'Home',
                'slug' => 'home',
                'icon' => 'ti ti-dashboard',
                'number' => 1
            ],
            [
                'id' => 2,
                'parent' => NULL,
                'name' => 'Setting',
                'slug' => NULL,
                'icon' => 'ti ti-adjustments',
                'number' => 2
            ],
            [
                'id' => 3,
                'parent' => 2,
                'name' => 'User',
                'slug' => 'user',
                'icon' => NULL,
                'number' => 1
            ],
            [
                'id' => 4,
                'parent' => 2,
                'name' => 'Role',
                'slug' => 'role',
                'icon' => NULL,
                'number' => 2
            ],
            [
                'id' => 5,
                'parent' => 2,
                'name' => 'Menu',
                'slug' => 'menu',
                'icon' => NULL,
                'number' => 3
            ]
        ];

        $this->db->insert_batch('menus', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('menus', TRUE);
    }
}

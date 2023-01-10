<?php

class Migration_Create_menu_table extends CI_Migration
{
    public function __construct()
    {

        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'parent' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => null
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => null
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => null
            ],
            'number' => [
                'type' => 'INT',
                'constraint' => 11
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('parent');
        $this->dbforge->create_table('menus', true);

        $data = [
            [
                'id' => 1,
                'parent' => null,
                'name' => 'Dashboard',
                'slug' => 'home',
                'icon' => 'ti ti-dashboard',
                'number' => 1
            ],
            [
                'id' => 2,
                'parent' => null,
                'name' => 'Settings',
                'slug' => null,
                'icon' => 'ti ti-adjustments',
                'number' => 2
            ],
            [
                'id' => 3,
                'parent' => 2,
                'name' => 'User',
                'slug' => 'user',
                'icon' => null,
                'number' => 2
            ],
            [
                'id' => 4,
                'parent' => 2,
                'name' => 'Role',
                'slug' => 'role',
                'icon' => null,
                'number' => 3
            ],
            [
                'id' => 5,
                'parent' => 2,
                'name' => 'Menu',
                'slug' => 'menu',
                'icon' => null,
                'number' => 4
            ],
            [
                'id' => 6,
                'parent' => 2,
                'name' => 'Feature',
                'slug' => 'feature',
                'icon' => null,
                'number' => 5
            ],
        ];

        $this->db->insert_batch('menus', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('menus', true);
    }
}

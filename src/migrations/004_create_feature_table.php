<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_feature_table extends CI_Migration
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
            'module' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => NULL
            ],
            'class' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'method' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('features', TRUE);

        $data = [
            // Feature Module
            [
                'module' => 'feature',
                'class' => 'feature',
                'method' => 'index',
                'description' => 'Feature'
            ],
            [
                'module' => 'feature',
                'class' => 'feature',
                'method' => 'store',
                'description' => 'Store Feature'
            ],
            [
                'module' => 'feature',
                'class' => 'feature',
                'method' => 'show',
                'description' => 'Show Feature'
            ],
            [
                'module' => 'feature',
                'class' => 'feature',
                'method' => 'edit',
                'description' => 'Edit Feature'
            ],
            [
                'module' => 'feature',
                'class' => 'feature',
                'method' => 'update',
                'description' => 'Update Feature'
            ],
            [
                'module' => 'feature',
                'class' => 'feature',
                'method' => 'destroy',
                'description' => 'Destroy Feature'
            ],

            // Menu Module
            [
                'module' => 'menu',
                'class' => 'menu',
                'method' => 'index',
                'description' => 'Menu'
            ],
            [
                'module' => 'menu',
                'class' => 'menu',
                'method' => 'store',
                'description' => 'Store Menu'
            ],
            [
                'module' => 'menu',
                'class' => 'menu',
                'method' => 'show',
                'description' => 'Show Menu'
            ],
            [
                'module' => 'menu',
                'class' => 'menu',
                'method' => 'edit',
                'description' => 'Edit Menu'
            ],
            [
                'module' => 'menu',
                'class' => 'menu',
                'method' => 'update',
                'description' => 'Update Menu'
            ],
            [
                'module' => 'menu',
                'class' => 'menu',
                'method' => 'destroy',
                'description' => 'Destroy Menu'
            ],

            // Role Module
            [
                'module' => 'role',
                'class' => 'role',
                'method' => 'index',
                'description' => 'Role'
            ],
            [
                'module' => 'role',
                'class' => 'role',
                'method' => 'store',
                'description' => 'Store Role'
            ],
            [
                'module' => 'role',
                'class' => 'role',
                'method' => 'show',
                'description' => 'Show Role'
            ],
            [
                'module' => 'role',
                'class' => 'role',
                'method' => 'edit',
                'description' => 'Edit Role'
            ],
            [
                'module' => 'role',
                'class' => 'role',
                'method' => 'update',
                'description' => 'Update Role'
            ],
            [
                'module' => 'role',
                'class' => 'role',
                'method' => 'destroy',
                'description' => 'Destroy Role'
            ],

            // User Module
            [
                'module' => 'user',
                'class' => 'user',
                'method' => 'index',
                'description' => 'User'
            ],
            [
                'module' => 'user',
                'class' => 'user',
                'method' => 'store',
                'description' => 'Store User'
            ],
            [
                'module' => 'user',
                'class' => 'user',
                'method' => 'show',
                'description' => 'Show User'
            ],
            [
                'module' => 'user',
                'class' => 'user',
                'method' => 'edit',
                'description' => 'Edit User'
            ],
            [
                'module' => 'user',
                'class' => 'user',
                'method' => 'update',
                'description' => 'Update User'
            ],
            [
                'module' => 'user',
                'class' => 'user',
                'method' => 'destroy',
                'description' => 'Destroy User'
            ],
        ];

        $this->db->insert_batch('features', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('features', TRUE);
    }
}

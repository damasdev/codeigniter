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
    }

    public function down()
    {
        $this->dbforge->drop_table('features', TRUE);
    }
}

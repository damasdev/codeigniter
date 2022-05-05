<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_table_user extends CI_Migration
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
                'constraint' => 100
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users', TRUE);

        // Dumping data for table 'users'
        $data = [
            'name' => 'Damas Amirul Karim',
            'password' => '$2y$08$200Z6ZZbp3RAEXoaWcMA6uJOFicwNZaqk4oDhqTUiFXFe63MG.Daa',
            'email' => 'damas@kodedasar.com',
        ];

        $this->db->insert('users', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}

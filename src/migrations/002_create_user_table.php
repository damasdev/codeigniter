<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_user_table extends CI_Migration
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
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('role_id');
        $this->dbforge->create_table('users', TRUE);

        // Dumping data for table 'users'
        $data = [
            'id' => 1,
            'name' => 'Damas Amirul Karim',
            'password' => password_hash('rahasia', PASSWORD_BCRYPT),
            'email' => 'damas@kodedasar.com',
            'role_id' => 1
        ];

        $this->db->insert('users', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}

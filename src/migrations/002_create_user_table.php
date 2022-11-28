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
        $this->dbforge->create_table('users', TRUE);

        $this->dbforge->add_column('users',[
            'CONSTRAINT fk_user_role_id FOREIGN KEY(role_id) REFERENCES roles(id) ON DELETE CASCADE',
        ]);

        // Dumping data for table 'users'
        $data = [
            'id' => 1,
            'name' => 'Damas Amirul Karim',
            'password' => password_hash('rahasia', PASSWORD_BCRYPT),
            'email' => 'codewithdamas@gmail.com',
            'role_id' => 1
        ];

        $this->db->insert('users', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}

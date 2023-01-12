<?php

class Migration_Create_user_table extends CI_Migration
{
    public function __construct()
    {
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('users', true);

        $this->dbforge->add_key('email, role');

        // Dumping data for table 'users'
        $data = [
            'id'       => 1,
            'name'     => 'Damas Amirul Karim',
            'password' => password_hash('rahasia', PASSWORD_BCRYPT),
            'email'    => 'codewithdamas@gmail.com',
            'role'     => 'root',
        ];

        $this->db->insert('users', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('users', true);
    }
}

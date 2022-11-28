<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_menu_acl extends CI_Migration
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
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('menus_acl', TRUE);

        $this->dbforge->add_column('menus_acl',[
            'CONSTRAINT fk_menu_acl_menu_id FOREIGN KEY(menu_id) REFERENCES menus(id)',
            'CONSTRAINT fk_menu_acl_role_id FOREIGN KEY(role_id) REFERENCES roles(id)',
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('menus_acl', TRUE);
    }
}

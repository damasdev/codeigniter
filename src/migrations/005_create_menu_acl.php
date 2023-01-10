<?php

class Migration_Create_menu_acl extends CI_Migration
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
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('menus_acl', true);

        $this->dbforge->add_column('menus_acl',[
            'CONSTRAINT fk_menu_acl_menu_id FOREIGN KEY(menu_id) REFERENCES menus(id)',
            'CONSTRAINT fk_menu_acl_role_id FOREIGN KEY(role_id) REFERENCES roles(id)',
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('menus_acl', true);
    }
}

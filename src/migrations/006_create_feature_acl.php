<?php

class Migration_Create_feature_acl extends CI_Migration
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
            'feature_id' => [
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
        $this->dbforge->create_table('features_acl', true);

        $this->dbforge->add_column('features_acl', [
            'CONSTRAINT fk_feature_acl_feature_id FOREIGN KEY(feature_id) REFERENCES features(id)',
            'CONSTRAINT fk_feature_acl_role_id FOREIGN KEY(role_id) REFERENCES roles(id)',
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('features_acl', true);
    }
}

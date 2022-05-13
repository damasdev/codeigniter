<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_feature_acl extends CI_Migration
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
            'feature_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('features_acl', TRUE);

        $this->dbforge->add_column('features_acl',[
            'CONSTRAINT fk_feature_acl_feature_id FOREIGN KEY(feature_id) REFERENCES features(id)',
            'CONSTRAINT fk_feature_acl_role_id FOREIGN KEY(role_id) REFERENCES roles(id)',
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('features_acl', TRUE);
    }
}

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
        $this->dbforge->add_key(['feature_id', 'role_id']);
        $this->dbforge->create_table('features_acl', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('features_acl', TRUE);
    }
}

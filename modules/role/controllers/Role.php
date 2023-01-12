<?php

class Role extends MY_Controller
{
    public function __construct()
    {
        $this->assertPrivilege("role.module");

        $this->load->model('Role_model', 'roleModel');
    }

    /**
     * Index
     *
     * @return void
     */
    public function index(): void
    {
        $data['title'] = 'Role';

        $this->render('role', $data);
    }

    /**
     * Store Role
     *
     * @return void
     */
    public function store(): void
    {
        try {
            $data = [
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code')
            ];

            if (!$this->form_validation->run('store_role')) {
                $errors = $this->form_validation->error_array();
                throw new Exception(current($errors));
            }

            $this->roleModel->insert($data);

            $this->jsonResponse([
                'status' => 'success',
                'message' => 'Data successfuly created'
            ], 200);
        } catch (\Throwable $th) {
            $this->jsonResponse([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Destroy Role
     *
     * @param  string $code
     * @return void
     */
    public function destroy(string $code): void
    {
        try {
            $role = $this->roleModel->find(['code' => $code]);
            if (!$role) {
                throw new Exception("Data not found");
            }

            if ($role->code === 'root') {
                throw new Exception("Role can't be deleted!");
            }

            $this->roleModel->delete(['code' => $code]);

            $this->jsonResponse([
                'status' => 'success',
                'message' => 'Your data has been deleted.'
            ], 200);
        } catch (\Throwable $th) {
            $this->jsonResponse([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Show Role
     *
     * @param  string $code
     * @return void
     */
    public function show(string $code): void
    {
        $role = $this->roleModel->find(['code' => $code]);

        if (!$role) {
            show_404();
        }

        $data['title'] = 'Show Role';
        $data['role'] = $role;

        $this->render('show-role', $data);
    }

    /**
     * Edit Role
     *
     * @param  string $code
     * @return void
     */
    public function edit(string $code): void
    {
        $role = $this->roleModel->find(['code' => $code]);

        if (!$role) {
            show_404();
        }

        $data['title'] = 'Edit Role';
        $data['role'] = $role;

        $this->render('edit-role', $data);
    }

    /**
     * Update Data
     *
     * @param  string $code
     * @return void
     */
    public function update(string $code): void
    {
        try {
            $data = [
                'name' => $this->input->post('name')
            ];

            if (!$this->form_validation->run('update_role')) {
                $errors = $this->form_validation->error_array();
                throw new Exception(current($errors));
            }

            $this->roleModel->update($data, [
                'code' => $code
            ]);

            $this->jsonResponse([
                'status' => 'success',
                'message' => 'Data successfuly updated'
            ], 200);
        } catch (\Throwable $th) {
            $this->jsonResponse([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Datatables
     *
     * @return void
     */
    public function datatables(): void
    {
        $this->load->library('datatables');
        $data = $this->datatables->table('roles')->draw();

        $this->jsonResponse($data);
    }
}

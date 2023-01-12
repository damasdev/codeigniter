<?php

class User extends MY_Controller
{
    public function __construct()
    {
        $this->assertPrivilege("user.module");

        $this->load->model("User_model", "userModel");
        $this->load->library("datatables");
    }

    /**
     * Index
     *
     * @return void
     */
    public function index(): void
    {
        $this->load->model("role/Role_model", "roleModel");

        $data["title"] = "User";
        $data["roles"] = $this->roleModel->all(["code NOT IN('root')" => null]);

        $this->render("user", $data);
    }

    /**
     * Store User
     *
     * @return void
     */
    public function store(): void
    {
        try {
            $data = [
                "name" => $this->input->post("name"),
                "email" => $this->input->post("email"),
                "password" => $this->input->post("password"),
                "role" => $this->input->post("role"),
            ];

            if (!$this->form_validation->run("user")) {
                $errors = $this->form_validation->error_array();
                throw new Exception(current($errors));
            }

            // Run Password Hash
            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

            $this->userModel->insert($data);

            $this->jsonResponse([
                "status" => "success",
                "message" => "Data successfuly created"
            ], 200);
        } catch (\Throwable $th) {
            $this->jsonResponse([
                "status" => "error",
                "message" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Destroy User
     *
     * @param  int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        try {
            $user = $this->userModel->findWithRole(["users.id" => $id]);
            if (!$user) {
                throw new Exception("Data not found");
            }

            $this->userModel->delete(["id" => $id]);

            $this->jsonResponse([
                "status" => "success",
                "message" => "Your data has been deleted."
            ], 200);
        } catch (\Throwable $th) {
            $this->jsonResponse([
                "status" => "error",
                "message" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Show User
     *
     * @param  int $id
     * @return void
     */
    public function show(int $id): void
    {
        $user = $this->userModel->find(["id" => $id]);

        if (!$user) {
            show_404();
        }

        $data["title"] = "Show User";
        $data["user"] = $user;

        $this->render("show-user", $data);
    }

    /**
     * Edit User
     *
     * @param  int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $this->load->model("role/Role_model", "roleModel");

        $user = $this->userModel->find(["id" => $id]);

        if (!$user) {
            show_404();
        }

        $data["title"] = "Edit Role";
        $data["roles"] = $this->roleModel->all(["code NOT IN('root')" => null]);
        $data["user"] = $user;

        $this->render("edit-user", $data);
    }

    /**
     * Update Data
     *
     * @param  int $id
     * @return void
     */
    public function update(int $id): void
    {
        try {
            $data = [
                "name" => $this->input->post("name"),
                "email" => $this->input->post("email"),
                "password" => $this->input->post("password"),
                "role" => $this->input->post("role"),
            ];

            if (!$this->form_validation->run("user")) {
                $errors = $this->form_validation->error_array();
                throw new Exception(current($errors));
            }

            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

            $this->userModel->update($data, ["id" => $id]);

            $this->jsonResponse([
                "status" => "success",
                "message" => "Data successfuly updated"
            ], 200);
        } catch (\Throwable $th) {
            $this->jsonResponse([
                "status" => "error",
                "message" => $th->getMessage()
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
        $data = $this->datatables->table("users")
            ->join("roles", "roles.code = users.role")
            ->where("roles.code NOT IN('root')", null)
            ->draw();

        $this->jsonResponse($data);
    }
}

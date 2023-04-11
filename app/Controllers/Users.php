<?php

namespace App\Controllers;

class Users extends BaseController
{


    /**
     * Show users page
     *
     * @return string
     * @since 0.0.1
     * @author Mehmet
     */
    public function index(): string
    {

        $this->data['breadcrumb'] = [
            'Home' => site_url('/'),
            'Users' => site_url('/users')
        ];

        $this->data['buttons'] = [
            [
                'action' => 'users.getUserForm(0)',
                'class' => 'primary',
                'text' => 'New User',
            ],
            [
                'link' => site_url('/roles'),
                'class' => 'info',
                'text' => 'Roles',
            ]
        ];

        $data = array_merge($this->data, [
            'title' => 'Users Page',
            'page_icon' => 'fal fa-users',
            'page_description' => 'List of users',
            'page_right_header' => 'something about users to write on right side',
        ]);
        return view('users/users', $data);
    }

    /**
     * Get users for datatable
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @since 0.0.1
     * @author mehmet
     */
    public function getUsers(): \CodeIgniter\HTTP\ResponseInterface
    {
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $search = $this->request->getVar('search');
        $users_role = $this->request->getVar('user_role');
        $users_status = $this->request->getVar('user_status');

        // TODO Mehmet: add ordering conditions

        $count = $this->userModel->getTotalUsers($users_status, $users_role, $search['value']);
        $users = $this->userModel->getUsers($users_status, $users_role, $start, $length, $search['value']);

        $data = array();
        if ($users) {
            foreach ($users as $user) {
                $buttons = '';
                // current user should not be able to delete himself
                if($this->user['id_user'] != $user['id_user'] && -1 != $user['status']){
                    $buttons .= '<button onclick="users.deleteUser(\'' . $user['user_ref'] . '\')" class="mr-2 btn btn-outline-danger btn-icon waves-effect waves-themed"><i class="fal fa-times"></i></a>';
                }
                $buttons .= '<button onclick="users.getUserForm(\'' . $user['user_ref'] . '\')" class="mr-2 btn btn-outline-warning btn-icon waves-effect waves-themed"><i class="fal fa-pencil"></i></a>';

                switch ($user['status']) {
                    case -1:
                        $status = '<span class="badge border border-danger text-danger">Deleted</span>';
                        break;
                    case 0:
                        $status = '<span class="badge border border-secondary text-secondary">Disabled</span>';
                        break;
                    case 1:
                        $status = '<span class="badge border border-success text-success">Active</span>';
                        break;
                    default:
                        $status = '<span class="badge border border-dark text-dark">Undefined Status</span>';
                }

                $data[] = [
                    $user['user_ref'],
                    $user['first_name'] . ' ' . $user['last_name'],
                    $user['username'],
                    $user['email'],
                    $user['mobile'],
                    $user['role_name'],
                    $status,
                    date('d/m/Y H:i:s', strtotime($user['created_at'])),
                    $buttons
                ];
            }
        }
        $result = array(
            "draw" => (int)$_REQUEST['draw'],
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );
        return $this->response->setJson($result);
    }


    /**
     * Return roles as a json object for datatable filter
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @since 0.0.1
     * @author mehmet
     */
    public function getRolesJson(): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->response->setJson($this->userModel->getUserRole());

    }

    /**
     * Get user form modal body
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @since 0.0.1
     * @author mehmet
     */
    public function getUserForm(): \CodeIgniter\HTTP\ResponseInterface
    {
        $user_ref = $this->request->getVar('user_ref');
        $user = null;
        $form_title = 'New User';
        $form_title_2 = '';
        if ($user_ref) {
            $user = $this->userModel->getUser(user_ref: $user_ref);
            if (!$user) {
                return $this->response->setJson(['result' => false, 'title' => 'Not Found', 'message' => 'Invalid User']);
            }
            $form_title = 'Update User';
            $form_title_2 = $user['first_name'] . ' ' . $user['last_name'];
        }
        $roles = $this->userModel->getUserRole();
        $view = \Config\Services::renderer();
        $html = $view->renderString(view('users/user_form', ['user' => $user, 'roles' => $roles]));
        return $this->response->setJson(['result' => true, 'html' => $html, 'form_title' => $form_title, 'form_title_2' => $form_title_2]);
    }

    /**
     * Create or update user
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @since 0.0.1
     * @author mehmet
     */
    public function processUser(): \CodeIgniter\HTTP\ResponseInterface
    {
        $user_ref = $this->request->getVar('user_ref');
        $data = [
            'first_name' => ucfirst(trim(strtolower($this->request->getVar('first_name')))),
            'last_name' => ucfirst(trim(strtolower($this->request->getVar('last_name')))),
            'email' => trim(strtolower($this->request->getVar('email'))),
            'username' => trim($this->request->getVar('username')),
            'mobile' => trim($this->request->getVar('mobile')),
            'password' => $this->request->getVar('password'),
            'password_confirm' => $this->request->getVar('password_confirm'),
            'id_role' => (int)$this->request->getVar('id_role'),
            'status' => $this->request->getVar('status') === 'on' ? 1 : 0,
        ];

        $rules = [
            'first_name' => [
                'label' => 'First Name',
                'rules' => 'trim|required|min_length[1]|max_length[32]|alpha_space',
            ],
            'last_name' => [
                'label' => 'Last Name',
                'rules' => 'trim|required|min_length[1]|max_length[32]|alpha_space',
            ],
            'mobile' => [
                'label' => 'Mobile',
                'rules' => 'trim|required|regex_match[/^(07\d{9})$/]',
                'errors' => array(
                    'regex_match' => 'Mobile is not in the correct format. Please make sure it is 07123456789 format',
                ),
            ],
            'id_role' => [
                'label' => 'Role',
                'rules' => 'trim|required|is_not_unique[user_roles.id_role]',

            ],

            'username' => [
                'label' => 'Username',
                'rules' => 'trim|required|min_length[1]|max_length[16]|is_unique[users.username]',

            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'trim|required|min_length[1]|max_length[32]|valid_email|is_unique[users.email]',

            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'trim|required|min_length[6]|max_length[25]|matches[password_confirm]',

            ],
        ];

        // validation on update
        if ($user_ref != '0') {
            $user = $this->userModel->getUser(user_ref: $user_ref);
            if (!$user) {
                return $this->response->setJson(['result' => false, 'title' => 'Not Found', 'message' => 'Invalid User']);
            }
            // in case of update we should skip unique username and password for current user
            $rules['username']['rules'] = 'trim|required|min_length[1]|max_length[16]|is_unique[users.username,id_user,' . $user['id_user'] . ']';
            $rules['email']['rules'] = 'trim|required|min_length[1]|max_length[32]|valid_email|is_unique[users.email,id_user,' . $user['id_user'] . ']';

            // if user not update password skip it from validation
            if ($data['password'] == '' && $data['password_confirm'] == '') {
                unset($rules['password']);
                unset($data['password']);
            }

            //  if user already been deleted and new status not active then leave it as deleted
            if($user['status'] == -1 && $data['status'] == 0){
                unset($data['status']);
            }

        }

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $error = !empty($errors) ? array_shift($errors) : 'Undefined error occurred';
            return $this->response->setJson(['result' => false, 'title' => 'Validation Error', 'message' => $error]);
        }

        // password confirm field is not a db field
        unset($data['password_confirm']);
        if ($user_ref != '0') {
            $this->userModel->updateUser($user['id_user'], $data);
            $message = 'User has been updated';
        } else {
            // create password hash and ref for new user
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['user_ref'] = $this->generateUserRef();
            $data['created_by'] = $this->user['id_user'];
            $this->userModel->addUser($data);
            $message = 'User has been created';
        }
        return $this->response->setJson(['result' => true, 'title' => 'Success', 'message' => $message]);
    }


    /**
     * Soft delete user
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @since 0.0.1
     * @author Mehmet
     */
    public function deleteUser(): \CodeIgniter\HTTP\ResponseInterface
    {
        $user_ref = $this->request->getVar('user_ref');

        if (!$user_ref) {
            return $this->response->setJson(['result' => false, 'title' => 'Not Found', 'message' => 'User not found']);
        }

        $user = $this->userModel->getUser(user_ref: $user_ref);
        if (!$user) {
            return $this->response->setJson(['result' => false, 'title' => 'Not Found', 'message' => 'User not found']);
        }
        $deleteUser = $this->userModel->deleteUser($user['id_user']);
        if ($deleteUser) {
            return $this->response->setJson(['result' => true, 'title' => 'Success', 'message' => 'User deleted']);
        } else {
            return $this->response->setJson(['result' => false, 'title' => 'Error', 'message' => 'User could not be deleted']);
        }
    }


    /**
     * Generate 8 character uniquer user reference
     *
     * @return string
     * @author Mehmet
     * @since 0.0.1
     */
    public function generateUserRef(): string
    {
        helper('text');
        $reference = random_string('alnum', 8);
        if ($this->userModel->isReferenceExist($reference)) {
            return $this->generateUserRef();
        }
        return strtoupper($reference);
    }

}

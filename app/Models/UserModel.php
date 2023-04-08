<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

/**
 * @author mehmet
 * @since 0.0.1
 */
class UserModel extends Model
{

    /**
     * Get total users for datatable
     *
     * @param int|string $status
     * @param string|int $role
     * @param string|false $search
     * @return int
     * @author mehmet
     * @since 0.0.1
     */
    public function getTotalUsers(int|string $status = 1, string|int $role = 'all', string|false $search = false): int
    {
        $query = $this->db->table('users u')
            ->select("u.*, r.role_name, CONCAT_WS(u2.first_name, ' ', u2.last_name) as creator")
            ->join('user_roles r', 'u.id_role = r.id_role')
            ->join(' users u2', 'u.created_by = u2.id_user');

        if ($status != 'all') {
            $query->where('u.status', (int)$status);
        }
        if ($role != 'all') {
            $query->where('u.id_role', (int)$role);
        }
        if ($search) {
            $query->groupStart();
            $query->like('u.id_user', $search);
            $query->orLike('u.user_ref', $search);
            $query->orLike('u.first_name', $search);
            $query->orLike('u.last_name', $search);
            $query->orLike(new rawSQL("CONCAT(u.first_name, ' ', u.last_name)"), $search);
            $query->orLike(new rawSQL("CONCAT(u.first_name, ' ', u.last_name)"), str_replace(' ', '', $search));
            $query->orLike('u.username', $search);
            $query->orLike('u.email', $search);
            $query->orLike('u.mobile', $search);
            $query->orLike('r.role_name', $search);
            $query->groupEnd();
        }
        return (int)$query->countAllResults();
    }


    /**
     * Get users
     *
     * @param int|string $status
     * @param string|int $role
     * @param int|false $start
     * @param int|false $length
     * @param string|false $search
     * @return array
     * @author mehmet
     * @since 0.0.1
     */
    public function getUsers(int|string $status = 1, string|int $role = 'all', int|false $start = false, int|false $length = false, string|false $search = false): array
    {

        $query = $this->db->table('users u')
            ->select("u.*, r.role_name, CONCAT_WS(u2.first_name, ' ', u2.last_name) as creator")
            ->join('user_roles r', 'u.id_role = r.id_role')
            ->join(' users u2', 'u.created_by = u2.id_user');

        if ($status != 'all') {
            $query->where('u.status', (int)$status);
        }
        if ($role != 'all') {
            $query->where('u.id_role', (int)$role);
        }
        if ($search) {
            $query->groupStart();
            $query->like('u.id_user', $search);
            $query->orLike('u.user_ref', $search);
            $query->orLike('u.first_name', $search);
            $query->orLike('u.last_name', $search);
            $query->orLike(new rawSQL("CONCAT(u.first_name, ' ', u.last_name)"), $search);
            $query->orLike(new rawSQL("CONCAT(u.first_name, ' ', u.last_name)"), str_replace(' ', '', $search));
            $query->orLike('u.username', $search);
            $query->orLike('u.email', $search);
            $query->orLike('u.mobile', $search);
            $query->orLike('r.role_name', $search);
            $query->groupEnd();
        }
        $query->orderBy('u.id_user', 'DESC');
        $query->limit($length, $start);
        return $query->get()->getResultArray();
    }


    /**
     * Get user
     *
     * @param string|false $username
     * @param int|false $id_user
     * @param string|false $user_ref
     * @return array|null
     * @author mehmet
     * @since 0.0.1
     */
    public function getUser(string|false $username = false, int|false $id_user = false, string|false $user_ref = false): array|null
    {

        $query = $this->db->table('users u')
            ->select("u.*, r.role_name, CONCAT_WS(u2.first_name, ' ', u2.last_name) as creator")
            ->join('user_roles r', 'u.id_role = r.id_role')
            ->join(' users u2', 'u.created_by = u2.id_user');

        if ($username) {
            $query->where(['u.username' => $username]);
            return $query->get()->getRowArray();
        }
        if ($id_user) {
            $query->where(['u.id_user' => $id_user]);
            return $query->get()->getRowArray();
        }
        if ($user_ref) {
            $query->where(['u.user_ref' => $user_ref]);
            return $query->get()->getRowArray();
        }
        return null;
    }


    /**
     * Get all roles or single role by id
     *
     * @param int|false $id_role
     * @return array
     * @author mehmet
     * @since 0.0.1
     */
    public function getUserRole(int|false $id_role = false): array
    {
        $query = $this->db->table('user_roles')
            ->where(['status' => 1]);
        if ($id_role !== false) {
            $query->where(['id_role' => $id_role]);
        }
        return $query->get()->getResultArray();
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return int
     * @author mehmet
     * @since 0.0.1
     */
    public function addUser(array $data): int
    {
        return $this->db->table('users')->insert($data) ? $this->db->insertID() : 0;
    }

    /**
     * Update user
     *
     * @param int $id_user
     * @param array $data
     * @return bool
     * @since 0.0.1
     * @author mehmet
     */
    public function updateUser(int $id_user, array $data): bool
    {
        return $this->db->table('users')->update($data, ['id_user' => $id_user]);
    }

    /**
     * Soft delete user
     *
     * @param int $id_user
     * @return bool
     * @author mehmet
     * @since 0.0.1
     */
    public function deleteUser(int $id_user): bool
    {
        return $this->db->table('users')->update(['status' => -1], ['id_user' => $id_user]);
    }

    /**
     * Check if user ref unique
     *
     * @param string $user_ref
     * @return bool
     * @author mehmet
     * @since 0.0.1
     */
    public function isReferenceExist(string $user_ref): bool
    {
        $count = $this->db->table('users')
            ->where(['users.user_ref' => $user_ref])
            ->countAllResults();
        return $count > 0;
    }


}

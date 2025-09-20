<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model {
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['first_name', 'last_name', 'email'];
    protected $validationRules = [
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name'  => 'required|min_length[2]|max_length[100]',
        'email'      => 'required|valid_email|max_length[150]'
    ];

    public function __construct() {
        parent::__construct();
    }

    // Paginated list with optional search
    public function getPaginated($q = '', $recordsPerPage = 5, $page = 1) {
        $query = $this->db->table($this->table);

        if (!empty($q)) {
            $query->like('first_name', $q)
                  ->or_like('last_name', $q)
                  ->or_like('email', $q);
        }

        // Count total rows without resetting query
        $totalRows = $query->count_all_results(false);

        // Fetch paginated results
        $records = $query->limit($recordsPerPage, ($page - 1) * $recordsPerPage)
                         ->get()
                         ->getResultArray();

        return [
            'records' => $records,
            'total_rows' => $totalRows
        ];
    }

    // Soft delete support
    public function restorePage($q = '', $recordsPerPage = 5, $page = 1) {
        $query = $this->db->table($this->table)->where('deleted_at IS NOT NULL', null, false);

        if (!empty($q)) {
            $query->like('first_name', $q)
                  ->or_like('last_name', $q)
                  ->or_like('email', $q);
        }

        $totalRows = $query->count_all_results(false);

        $records = $query->limit($recordsPerPage, ($page - 1) * $recordsPerPage)
                         ->get()
                         ->getResultArray();

        return [
            'records' => $records,
            'total_rows' => $totalRows
        ];
    }

    public function softDelete($id) {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function restore($id) {
        return $this->update($id, ['deleted_at' => null]);
    }
}

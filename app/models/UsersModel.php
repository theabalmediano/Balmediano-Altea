<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'id';
    protected $allowed_fields = ['fname', 'lname', 'email'];
    protected $validation_rules = [
        'fname' => 'required|min_length[2]|max_length[100]',
        'lname' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[150]'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /** Pagination + Search for active users **/
    public function page($q = '', $records_per_page = null, $page = null)
    {
        $query = $this->db->table($this->table)->where('deleted_at IS NULL');

        if (!empty($q)) {
            $query->group_start()
                  ->like('fname', '%'.$q.'%')
                  ->or_like('lname', '%'.$q.'%')
                  ->or_like('email', '%'.$q.'%')
                  ->group_end();
        }

        // count
        $countQuery = clone $query;
        $data['total_rows'] = $countQuery->select_count('*', 'count')->get()['count'];

        // records
        $data['records'] = $query->pagination($records_per_page, $page)->get_all();
        return $data;
    }

    /** Soft delete (requires a deleted_at column in DB) **/
    public function soft_delete($id)
    {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->update(['deleted_at' => date('Y-m-d H:i:s')]);
    }

    /** List of soft deleted users **/
    public function restore_page($q = '', $records_per_page = null, $page = null)
    {
        $query = $this->db->table($this->table)->where('deleted_at IS NOT NULL');

        if (!empty($q)) {
            $query->group_start()
                  ->like('fname', '%'.$q.'%')
                  ->or_like('lname', '%'.$q.'%')
                  ->or_like('email', '%'.$q.'%')
                  ->group_end();
        }

        $countQuery = clone $query;
        $data['total_rows'] = $countQuery->select_count('*', 'count')->get()['count'];
        $data['records'] = $query->pagination($records_per_page, $page)->get_all();
        return $data;
    }

    /** Restore a soft-deleted user **/
    public function restore($id)
    {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->update(['deleted_at' => null]);
    }
}

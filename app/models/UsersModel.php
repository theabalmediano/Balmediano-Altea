<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: UsersModel
 */
class UsersModel extends Model {

    /**
     * Table associated with the model.
     * @var string
     */
    protected $table = 'students';

    /**
     * Primary key of the table.
     * @var string
     */
    protected $primary_key = 'id';

    /**
     * Allowed fields for insert/update
     */
    protected $allowed_fields = ['first_name', 'last_name', 'email'];

    /**
     * Validation rules
     */
    protected $validation_rules = [
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name'  => 'max_length[100]',
        'email'      => 'required|valid_email|max_length[150]'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get paginated records with optional search query
     * 
     * @param string|null $q Search query (searches first_name, last_name, email)
     * @param int|null $records_per_page Number of records per page
     * @param int|null $page Current page number (starts from 1)
     * 
     * @return array ['total_rows' => int, 'records' => array]
     */
    public function page($q = '', $records_per_page = null, $page = null)
    {
        if (is_null($page)) {
            // No pagination — return all records and total count
            return [
                'total_rows' => $this->db->table($this->table)->count_all(),
                'records'    => $this->db->table($this->table)->get_all()
            ];
        } else {
            $query = $this->db->table($this->table);

            if (!empty($q)) {
                $q = trim($q);
                // Group the OR LIKE conditions for search
                $query->like('id', $q)
                      ->or_like('first_name', $q)
                      ->or_like('last_name', $q)
                      ->or_like('email', $q);
            }

            // count total rows
            $countQuery = clone $query;
            $data['total_rows'] = $countQuery->select_count('*', 'count')->get()['count'];

            // fetch paginated records
            $data['records'] = $query->pagination($records_per_page, $page)->get_all();

            return $data;
            
        }
    }

}

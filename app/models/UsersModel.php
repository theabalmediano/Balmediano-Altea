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
                // Group the OR LIKE conditions for search
                $query->group_start()
                      ->like('first_name', $q)
                      ->or_like('last_name', $q)
                      ->or_like('email', $q)
                      ->group_end();
            }

            // Clone query for count
            $countQuery = clone $query;
            $countQuery->select('COUNT(*) as count');
            $countResult = $countQuery->get();
            $total_rows = isset($countResult[0]['count']) ? (int)$countResult[0]['count'] : 0;

            // Calculate offset for limit
            $offset = ($page - 1) * $records_per_page;

            // Get paginated records
            $records = $query
                ->limit($records_per_page, $offset)
                ->get_all();

            return [
                'total_rows' => $total_rows,
                'records' => $records
            ];
        }
    }

    /**
     * Get all records from the table
     */
    public function get_all()
    {
        return $this->db->table($this->table)->get_all();
    }
}

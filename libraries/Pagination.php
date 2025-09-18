<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Pagination {
    protected $total_rows;
    protected $per_page;
    protected $current_page;
    protected $base_url;
    protected $options = [];

    public function set_options(array $options) {
        $this->options = $options;
    }

    public function initialize($total_rows, $per_page, $current_page, $base_url) {
        $this->total_rows = $total_rows;
        $this->per_page = $per_page;
        $this->current_page = $current_page;
        $this->base_url = $base_url;
    }

    public function paginate() {
        $total_pages = ceil($this->total_rows / $this->per_page);
        if ($total_pages <= 1) return '';

        $first_link = $this->options['first_link'] ?? 'First';
        $last_link  = $this->options['last_link'] ?? 'Last';
        $next_link  = $this->options['next_link'] ?? 'Next';
        $prev_link  = $this->options['prev_link'] ?? 'Prev';
        $delimiter  = $this->options['page_delimiter'] ?? '?page=';

        $html = '';

        // First
        if ($this->current_page > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="'.$this->base_url.$delimiter.'1">'.$first_link.'</a></li>';
        }

        // Prev
        if ($this->current_page > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="'.$this->base_url.$delimiter.($this->current_page-1).'">'.$prev_link.'</a></li>';
        }

        // Page numbers
        for ($i=1; $i<=$total_pages; $i++) {
            if ($i == $this->current_page) {
                $html .= '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="'.$this->base_url.$delimiter.$i.'">'.$i.'</a></li>';
            }
        }

        // Next
        if ($this->current_page < $total_pages) {
            $html .= '<li class="page-item"><a class="page-link" href="'.$this->base_url.$delimiter.($this->current_page+1).'">'.$next_link.'</a></li>';
        }

        // Last
        if ($this->current_page < $total_pages) {
            $html .= '<li class="page-item"><a class="page-link" href="'.$this->base_url.$delimiter.$total_pages.'">'.$last_link.'</a></li>';
        }

        return $html;
    }
}

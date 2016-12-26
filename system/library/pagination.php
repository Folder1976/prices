<?php
class Pagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 5;
	public $url = '';
	public $text_first = 'Начало';
	public $text_last = 'Последняя';
	public $text_next = 'Дальше';
	public $text_prev = 'Назад';

	public function render() {
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}

		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);

		$this->url = str_replace('&sort=', '', $this->url);
		$this->url = str_replace('%7Bpage%7D', '{page}', $this->url);

		if(isset($_GET['price_from'])){
			$this->url .= '&price_from='.(int)$_GET['price_from'];
		}
		if(isset($_GET['price_to'])){
			$this->url .= '&price_to='.(int)$_GET['price_to'];
		}
		//$this->url = $this->url.'?page={page}';
		
		if(strpos($_SERVER['REQUEST_URI'],'/admin/') !== false){
			$output = '<ul class="pagination">';
		}else{
			$output = '<ul class="clearfix">';
		}

		
		if(strpos($_SERVER['REQUEST_URI'],'/admin/') !== false){
			if ($page > 1) {
				$output .= '<li><a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a></li>';
				$output .= '<li><a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li>';
			}	
		}else{
			if ($page > 1) {
				$output .= '<li><div class="links" data-link="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</div></li>';
				$output .= '<li><div class="links" data-link="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</div></li>';
			}	
		}
		

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= '<li class="active"><span>' . $i . '</span></li>';
				} else {
					if(strpos($_SERVER['REQUEST_URI'],'/admin/') !== false){
						$output .= '<li><a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a></li>';
					}else{
						$output .= '<li><div class="links" data-link="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</div></li>';
					}
				}
			}
		}

		if ($page < $num_pages) {
			
			if(strpos($_SERVER['REQUEST_URI'],'/admin/') !== false){
				$output .= '<li><a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a></li>';
				$output .= '<li><a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a></li>';
			}else{
				$output .= '<li><div class="links" data-link="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</div></li>';
				$output .= '<li><div class="links" data-link="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</div></li>';
			}
		}

		$output .= '</ul>';

		if ($num_pages > 1) {
			return $output;
		} else {
			return '';
		}
	}
}
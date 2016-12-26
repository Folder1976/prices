<?php
class ModelLocalisationContent extends Model {
	public function getContent($content_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "content WHERE content_id = '" . (int)$content_id . "'
								   AND language_id = '" . (int)$this->config->get('config_language_id'). "' LIMIT 1");

		return $query->row;
	}

	public function getContents($code) {
		$content_data = $this->cache->get('content.'.$code);

		if (!$content_data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "content
									  WHERE code = '" . $code . "' AND language_id = '" . (int)$this->config->get('config_language_id'). "'
									  ORDER BY value ASC";
			$query = $this->db->query($sql);

			$content_data = $query->rows;

			$this->cache->set('content.'.$code, $content_data);
		}

		return $content_data;
	}
}
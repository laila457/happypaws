public function save_penitipan($data) {
    return $this->db->insert('penitipan', $data);
}

public function get_penitipan($id) {
    return $this->db->where('id', $id)->get('penitipan')->row();
}
<?php
class Article_model extends CI_Model
{
  public function getAllArticle()
  {
    return $this->db
      ->order_by('updated_at', 'desc')
      ->get('articles')
      ->result_array();
  }
  public function getArticle($limit, $start, $keyword = NULL)
  {
    // select('*')->from('articles')
    return $this->db
      ->like('title', $keyword)
      ->join('users', 'users.id = articles.user_id')
      ->order_by('updated_at', 'desc')
      ->get('articles', $limit, $start)
      ->result_array();
  }
  public function getUserArticle($users_id, $limit, $start, $keyword = NULL)
  {
    return $this->db
      ->where('user_id', $users_id)
      ->like('title', $keyword)
      ->order_by('updated_at', 'desc')
      ->get('articles', $limit, $start)
      ->result_array();
  }
  public function countArticle($keyword = null)
  {
    return $this->db
      ->like('title', $keyword)
      ->from('articles')
      ->count_all_results();
  }
  public function countUserArticle($users_id, $keyword = null)
  {

    return $this->db
      ->like('title', $keyword)
      ->where('user_id', $users_id)
      ->from('articles')
      ->count_all_results();
  }
  public function countAllArticle()
  {
    return $this->db->get('articles')->num_rows();
  }

  public function getArticleBySlug($slug)
  {
    return $this->db
      ->where('slug', $slug)
      ->join('users', 'users.id = articles.user_id')
      ->get('articles')
      ->result_array();
  }
  public function createArticle()
  {
    $slug = url_title(htmlspecialchars($this->input->post('title')), 'dash', TRUE);
    $data = [
      'user_id' => htmlspecialchars($this->input->post('user_id')),
      'title' => htmlspecialchars($this->input->post('title')),
      'slug' => $slug,
      'body' => htmlspecialchars($this->input->post('body')),
      'created_at' => time(),
      'updated_at' => time()
    ];
    $this->db->insert('articles', $data);
  }
  public function updateArticle($slug)
  {
    $slug2 = url_title(htmlspecialchars($this->input->post('title')), 'dash', TRUE);
    $data = array(
      'title' =>  htmlspecialchars($this->input->post('title')),
      'slug' => $slug2,
      'body' => htmlspecialchars($this->input->post('body')),
      'updated_at' => time(),
    );
    $this->db
      ->where('slug', $slug)
      ->update('articles', $data);
  }
  public function deleteArticle($slug)
  {
    $this->db
      ->delete('articles', array('slug' => $slug));
  }
}

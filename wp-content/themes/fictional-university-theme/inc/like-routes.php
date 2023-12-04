<?php 

add_action("rest_api_init", "universityLikeRoutes");

function universityLikeRoutes() {
  register_rest_route('university/v1', 'manageLike', [
    'methods' => 'POST',
    'callback' => 'createLike'
  ]);
  
  register_rest_route('university/v1', 'manageLike', [
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ]);  
}

function createLike($data) {
  if(is_user_logged_in()) {
    $profId = sanitize_text_field($data['professorId']);
    $existQuery = new WP_Query([
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => [
        'key' => 'liked_professor_id',
        'compare' => '=',
        'value' => $profId
      ]
    ]);

    if($existQuery->found_posts() == 0 AND get_post_type($profId) == 'professor'){
      return wp_insert_post([
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'Liked Professor',
        'meta_input' => [
          'liked_professor_id' => $profId,
        ]
      ]);
    } else {
      die("Invalid professor ID.");
    }
  } else {
    die("Permission denied. Only logged in users can create a like.");
  }
}

function deleteLike($data) {
  $likeId = sanitize_text_field($data["like"]);
  
  if(get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
    wp_delete_post($likeId, true);
  } else {
    die("Permission denied. You can't delete the entry.");
  }
}  

?>
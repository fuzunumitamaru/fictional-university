<?php 

add_action("rest_api_init", "universityRegisterSearch");

function universityRegisterSearch() : void {
  register_rest_route("university/v1", "search", [
    "methods" => WP_REST_SERVER::READABLE,
    "callback" => "universitySearchResults",
  ]);
}

function universitySearchResults($data) {
  
  $mainQuery = new WP_Query([
    "post_type" =>  ["post", "page", "professor", "event", "program", "campus"],
    "s" => sanitize_text_field($data['term'])
  ]);
  
  $results = [
    "generalInfo" => [],
    "professors" => [],
    "programs" => [],
    "events" => [],
    "campuses" => [],
  ];
  while( $mainQuery->have_posts() ) {
    $mainQuery->the_post();
    
    if(get_post_type() == "post" || get_post_type() == "page"){
      $results['generalInfo'][] = [
        "id"=> get_the_id(),
        "postType" => get_post_type(),
        "title"=> get_the_title(),
        "permalink"=> get_permalink(),
        "authorName"=> get_the_author(),
      ];
    }
    
    if(get_post_type() == "professor"){
      $results['professors'][] = [
        "id"=> get_the_id(),
        "postType" => get_post_type(),
        "title"=> get_the_title(),
        "permalink"=> get_permalink(),
        "image" => get_the_post_thumbnail_url(0, 'professorLandscape'),
      ];
    }
    
    if(get_post_type() == "program"){
      $relatedCampuses = get_field('related_campus');
      
      if($relatedCampuses){
        foreach($relatedCampuses as $campus){
          $results['campuses'][] = [
            "id"=> get_the_id($campus),
            "postType" => get_post_type($campus),
            "title"=> get_the_title($campus),
            "permalink"=> get_permalink($campus),
          ];
        }
      }
      
      $results['programs'][] = [
        "id"=> get_the_id(),
        "postType" => get_post_type(),
        "title"=> get_the_title(),
        "permalink"=> get_permalink(),
      ];
    }    

    if(get_post_type() == "event"){
      $eventDate = new DateTime(get_field('event_date'));
      $description =  (has_excerpt()) ? get_the_excerpt() : wp_trim_words(get_the_content(), 18);   
              
      $results['events'][] = [
        "id"=> get_the_id(),
        "postType" => get_post_type(),
        "title"=> get_the_title(),
        "permalink"=> get_permalink(),
        "month" => $eventDate->format('M'),
        "day" => $eventDate->format('d'),
        "description" => $description
      ];
    } 
    
    if(get_post_type() == "campus"){
      $results['campuses'][] = [
        "id"=> get_the_id(),
        "postType" => get_post_type(),
        "title"=> get_the_title(),
        "permalink"=> get_permalink(),
      ];
    } 
  }
  
  $programsMetaQuery[] = ["relation" => "OR"];
  if($results['programs']){
    foreach($results['programs'] as $program){
      $programsMetaQuery[] = [
        "key" => "related_programs",
        "compare" => "LIKE",
        "value"=> '"'.$program['id'].'"'
      ];    
    }
    
    $programRelationshipQuery = new WP_Query([
      "post_type" => ["professor", "event"],
      "meta_query"=> $programsMetaQuery
    ]);
    while($programRelationshipQuery->have_posts()){
      $programRelationshipQuery->the_post();
      
      if(get_post_type() == "professor"){
        $results['professors'][] = [
          "id"=> get_the_id(),
          "postType" => get_post_type(),
          "title"=> get_the_title(),
          "permalink"=> get_permalink(),
          "image" => get_the_post_thumbnail_url(0, 'professorLandscape'),
        ];
      }
      
      if(get_post_type() == "event"){
        $eventDate = new DateTime(get_field('event_date'));
        $description =  (has_excerpt()) ? get_the_excerpt() : wp_trim_words(get_the_content(), 18);   
                
        $results['events'][] = [
          "id"=> get_the_id(),
          "postType" => get_post_type(),
          "title"=> get_the_title(),
          "permalink"=> get_permalink(),
          "month" => $eventDate->format('M'),
          "day" => $eventDate->format('d'),
          "description" => $description
        ];
      }      
    }  
    
  }
  $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
  $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
  
  return $results;
  
}

?>
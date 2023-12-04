<form method="GET" action="<?= esc_url(site_url("/")) ?>" class="search-form">
  <label for="s" class="headline headline--medium">Perform a New Search:</label>
  <div class="search-form-row">
    <input type="search" id="s" name="s" class="s" placeholder="What are you looking for?">
    <input type="submit" value="Search" class="search-submit">
  </div>  
</form>

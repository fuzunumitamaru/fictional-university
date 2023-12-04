import axios from "axios";

class Search {
    // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML()
    this.openButton = document.querySelectorAll(".js-search-trigger")
    this.closeButton = document.querySelector(".search-overlay__close")
    this.searchOverlay = document.querySelector(".search-overlay")
    this.searchField = document.querySelector("#search-term")
    this.prevSearch;
    this.resultsDiv = document.querySelector("#search-overlay__results")
    this.isOverlayOpen = false;
    this.typingTimer;
    this.isLoading = false
    this.events();
  }
  
  // 2. events
  events(){
    this.openButton.forEach(el => {
      el.addEventListener("click", e => {
        e.preventDefault()
        this.openOverlay()
      })
    });
    
    this.closeButton.addEventListener("click", () => this.closeOverlay())
    document.addEventListener("keydown", e => this.keyPressDispatcher(e))
    this.searchField.addEventListener("keyup", () => this.typingLogic())
  }
  
  
  openOverlay(){
    this.searchOverlay.classList.add("search-overlay--active")
    document.body.classList.add("body-no-scroll")
    this.searchField.value = ""
    setTimeout(() => this.searchField.focus(), 301);
    this.isOverlayOpen = true;
  }
  
  closeOverlay(){
    this.searchOverlay.classList.remove("search-overlay--active")
    document.body.classList.remove("body-no-scroll")
    this.isOverlayOpen = false;
  }
  
  keyPressDispatcher(e){
    if(e.keyCode==83 && !this.isOverlayOpen && document.activeElement.tagName != "INPUT" && document.activeElement.tagName != "TEXTAREA"){
      this.openOverlay()
    }
    if(e.keyCode==27 && this.isOverlayOpen){
      this.closeOverlay()
    }
  }
  
  typingLogic(){
    if(this.searchField.value != this.prevSearch){
      clearTimeout(this.typingTimer)
      
      if(this.searchField.value){
        if(!this.isLoading){
          this.resultsDiv.innerHTML = `<div class="spinner-loader"></div>` 
          this.isLoading = true
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750)
      } 
      else {
        this.resultsDiv.innerHTML = ''
        this.isLoading = false
      }      
      
      this.prevSearch = this.searchField.value
    }
  }

  addSearchHTML(){
    document.body.insertAdjacentHTML(
      "beforeend",
      `<div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>
        
        <div class="container">
          <div id="search-overlay__results"></div>
        </div>
      </div>    
    `);
  }

  async getResults() {
    try {
      const response = await axios.get(universityData.root_url + "/wp-json/university/v1/search?term=" + this.searchField.value)
      const results = response.data
      this.resultsDiv.innerHTML = `
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
            ${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.postType == 'post' ? `by ${item.authorName}` : ''} </li>`).join('')}
            ${results.generalInfo.length ? '</ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No Programs matches that search. <a href="${universityData.root_url}/programs">View all Programs</a></p>`}
            ${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
            ${results.programs.length ? '</ul>' : ''}                
            
            <h2 class="search-overlay__section-title">Professors</h2>
            ${results.professors.length ? '<ul class="professor-cards">' : `<p>No Professors matches that search. </p>`}
            ${results.professors.map(item => `
              <li class="professor-card__list-item">
                <a class="professor-card" href="${item.permalink}">
                  <img class="professor-card__image" src="${item.image}">
                  <span class="professor-card__name">${item.title}</span>
                </a>
              </li>
            `).join('')}
            ${results.professors.length ? '</ul>' : ''}                
            
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No Campuses matches that search. <a href="${universityData.root_url}/campuses">View all Campuses</a></p>`}
            ${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
            ${results.campuses.length ? '</ul>' : ''}                

            <h2 class="search-overlay__section-title">Events</h2>
            ${results.events.length ? '' : `<p>No Events matches that search. <a href="${universityData.root_url}/events">View all Events</a></p>`}
            ${results.events.map(item => `
              <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                  <span class="event-summary__month">${item.month}</span>
                  <span class="event-summary__day">${item.day}</span>  
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                  <p>${item.description} <a href="${item.permalink}" class="nu gray">Learn more</a></p>
                </div>
              </div>                
            `).join('')}
            
          </div>              
        </div>
      `
    } catch (e) {
      
    }
  }
  
}

export default Search;
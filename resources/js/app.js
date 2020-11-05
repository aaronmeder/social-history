require('./bootstrap');
const Isotope = require('isotope-layout');

// Always say Hi
console.log("Nice to see you here my friend 👋🏻");

// element argument can be a selector string
//   for an individual element
window.isotope = new Isotope( '.media-grid', {
  // options
  itemSelector: '.media-single',
  layoutMode: 'fitRows'
});


const filters = document.querySelectorAll('.media-filter');
filters.forEach( (filter) => {
    filter.addEventListener('click', filterMedia );
});

function filterMedia() {
    console.log("filter cliked");
    if(window.isotope) {
        const thisFilter = this.dataset.filter;
        console.log(`filtering for ${thisFilter}...`);
        window.isotope.arrange({filter: "." + thisFilter})
    }
}

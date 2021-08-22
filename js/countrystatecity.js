// API https://github.com/dr5hn/countries-states-cities-database
var headers = new Headers();

headers.append("X-CSCAPI-KEY", "ZEg0SWJNY05Hd3l3bWNEVXAxa2hiNU1OTFQ1b0MzQWtXVWh3cFhkUQ==");

var requestOptions = {
  method: 'GET',
  headers: headers,
  redirect: 'follow'
};

// STORING COUNTRIES / STATES / CITIES INSIDE SELECT DOM

// Get all countries
async function fetchCountries() {
  try {
    const res = await fetch("https://api.countrystatecity.in/v1/countries", requestOptions);
    const countries = await res.json();
    return countries;
  } catch(err) {
    console.log(err);
  }
}

// Get all states
async function fetchStates(ciso2) {
  try {
    const res = await fetch(`https://api.countrystatecity.in/v1/countries/${ciso2}/states`, requestOptions);
    const states = await res.json();
    return states;
  } catch(err) {
    console.log(err);
  }
}

// Get all cities
async function fetchCities(ciso2, siso2) {
  try {
    const res = await fetch(`https://api.countrystatecity.in/v1/countries/${ciso2}/states/${siso2}/cities`, requestOptions);
    
    const cities = await res.json();
    return cities;
  } catch(err) {
    console.log(err);
  }
}

// Get countries and store them into dropdown
async function renderCountriesAndStore() {
  const countries = await fetchCountries();
  var dropdown = document.getElementById("country");
  for (var key in countries) {
    if (countries.hasOwnProperty(key)) {
      var c = document.createElement("option");
      c.value = countries[key].iso2;
      c.innerHTML = countries[key].name;
      dropdown.appendChild(c);
      // console.log(countries[key].name);
    }
  }
}

// get states and store them into dropdown
async function renderStatesAndStore(ciso2) {
  const states = await fetchStates(ciso2);
  var dropdown = document.getElementById("state");
  for (var key in states) {
    if (states.hasOwnProperty(key)) {
      var c = document.createElement("option");
      c.value = states[key].iso2;
      c.innerText = states[key].name;
      dropdown.appendChild(c);
      // console.log(states[key].name);
    }
  }
}

// get cities and store them into datalist
async function renderCitiesAndStore(ciso2,siso2) {
  const cities = await fetchCities(ciso2,siso2);
  var dropdown = document.getElementById("city");
  for (var key in cities) {
    if (cities.hasOwnProperty(key)) {
      var c = document.createElement("option");
      c.value = cities[key].name;
      // c.innerHTML = cities[key].name;
      dropdown.appendChild(c);
      // console.log(cities[key].name);
    }
  }
}

function getState() {
  document.getElementById("state").innerHTML = "<option value=''>-</option>";
  document.getElementById("city").innerHTML = "<option value=''></option>";
  document.getElementById("city-choice").value = "";
  renderStatesAndStore(document.getElementById("country").value);
}

function getCity() {
  document.getElementById("city").innerHTML = "<option value=''></option>";
  document.getElementById("city-choice").value = "";
  renderCitiesAndStore(document.getElementById("country").value,document.getElementById("state").value);
}

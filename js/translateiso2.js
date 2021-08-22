// API https://github.com/dr5hn/countries-states-cities-database
var headers = new Headers();

headers.append("X-CSCAPI-KEY", "ZEg0SWJNY05Hd3l3bWNEVXAxa2hiNU1OTFQ1b0MzQWtXVWh3cFhkUQ==");

var requestOptions = {
  method: 'GET',
  headers: headers,
  redirect: 'follow'
};

// using iso2 to get details about a single country or state

// get a specific country detail
async function getCountryDetails(ciso2) {
    try {
      const res = await fetch(`https://api.countrystatecity.in/v1/countries/${ciso2}`, requestOptions);
      const country = await res.json();
      return country;
    } catch(err) {
      console.log(err);
    }
  }
  
  
  // get a specific state detail
  async function getStateDetails(ciso2,siso2) {
    try {
      const res = await fetch(`https://api.countrystatecity.in/v1/countries/${ciso2}/states/${siso2}`, requestOptions);
      const state = await res.json();
      return state;
    } catch(err) {
      console.log(err);
    }
  }
  
  async function translateiso2ToNames() {
    const location = document.getElementById("location");
    const cusfix = location.className.split(" % "); // save classes
    const locationSplit = cusfix[0].split("|");
    const ciso2 = locationSplit[0];
    const siso2 = locationSplit[1];
    const city = locationSplit[2];
    const country = await getCountryDetails(ciso2);
    const state = await getStateDetails(ciso2,siso2);
    
    if (state["name"] != undefined) {
        if (city !=  undefined) {
            location.innerHTML = location.innerHTML + city + ", " + state["name"] + ", " + country["name"];
        } else {
            location.innerHTML = location.innerHTML + state["name"] + ", " + country["name"];
        }
    } else {
        location.innerHTML = location.innerHTML + country["name"];
    }
    const loader = document.getElementById("loader");
    const showWhenReady = document.getElementById("showWhenReady");
    loader.className = "d-none";
    showWhenReady.className = "";
  }

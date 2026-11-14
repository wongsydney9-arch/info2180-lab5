document.addEventListener("DOMContentLoaded", () =>{
    const lookup = document.getElementById("lookup");
    const cityLookup = document.getElementById("city");
    lookup.addEventListener("click", countrySearch);
    cityLookup.addEventListener("click", citySearch);
})

function countrySearch(){
    const input = document.getElementById("country").value.trim();
    const result = document.getElementById("result");
    fetch('world.php?country=' + encodeURIComponent(input))
    .then(response => response.text())
    .then(data => {
        result.innerHTML = data;
    })
    .catch(error =>{
        result.textContent = 'An error has occured.';
        console.error(error);
    });
}

function citySearch(){
    const input = document.getElementById("country").value.trim();
    const result = document.getElementById("result");
    fetch('world.php?country=' + encodeURIComponent(input) + '&lookup=cities')
    .then(response => response.text())
    .then(data => {
        result.innerHTML = data;
    })
    .catch(error =>{
        result.textContent = 'An error has occured.';
        console.error(error);
    });
}
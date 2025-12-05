window.addEventListener('load', function() {

    const lookupBtn = document.getElementById('lookup');
    const lookupCitiesBtn = document.getElementById('lookup-cities'); 
    const input = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    
    // COUNTRY LOOKUP 
    
    lookupBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const country = input.value.trim();
        const url = 'world.php?country=' + encodeURIComponent(country);

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    resultDiv.innerHTML = xhr.responseText;
                } else {
                    resultDiv.innerHTML = "Error retrieving data.";
                }
            }
        };

        xhr.open('GET', url, true);
        xhr.send();
    });


    // CITIES LOOKUP
   
    lookupCitiesBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const country = input.value.trim();
        const url = 'world.php?country=' + encodeURIComponent(country) + '&lookup=cities';

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    resultDiv.innerHTML = xhr.responseText;
                } else {
                    resultDiv.innerHTML = "Error retrieving city data.";
                }
            }
        };

        xhr.open('GET', url, true);
        xhr.send();
    });

});

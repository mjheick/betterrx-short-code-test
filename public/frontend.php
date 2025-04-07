<?php

?><!doctype html>
<html lang="en">
    <head>
        <title>Weird Static Frontend for <?php echo env('APP_NAME'); ?></title>
    </head>
    <script>
/* More vanilla than Mr. Ice #dances */
function search() {
    let ele_srchby = document.getElementById('search-by');
    let by = ele_srchby.options[ele_srchby.selectedIndex].value;
    let ele_query = document.getElementById('search-query');
    let query = ele_query.value;
    if (query.length == 0) {
        alert('going to need a query. i\'ll be nice and move the cursor for you to where you can type things in...');
        ele_query.focus();
        return;
    }
    console.log('searching...');
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log('got...');
            let dataz = xhr.responseText;
            try {
                let json_databases = JSON.parse(dataz);
            } catch (SyntaxError) {
                console.log('errored...');
                return;
            }
            if ("error" in json_databases) {
                alert('I gots an error. It is [' + json_databases.error + ']');
            }
            if ("results" in json_databases) {
                plot_results(json_databases);
            }
        }
    };
    xhr.open('GET', '/search/' + by + '/' + query + '/0', true);
    xhr.send();
}
function plop_results(some_json_data) {
    console.log(some_json_data);
}
    </script>
    <body>
        <div><h1><?php echo env("APP_NAME"); ?></h1></div>
        <div>
            Search by: <select id="search-by">
                <option value="first_name">first name</option>
                <option value="last_name">last name</option>
                <option value="number">npi number</option>
                <option value="taxonomy_description">taxonomy description</option>
                <option value="city">city</option>
                <option value="state">state</option>
                <option value="postal_code">zip</option>
            </select> | Query: <input id="search-query" type="text" placeholder="Query-dilla..." /> | <button id="search-button">Search</button>
        </div>
        <div id="search-results"></div>
    </body>
    <script>
/* only one hooks like in police academy */
window.addEventListener("load", (event) => {
	const btn = document.getElementById('search-button');
	btn.addEventListener('click', search);
});
    </script>
</html>
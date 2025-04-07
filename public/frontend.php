<?php

?><!doctype html>
<html lang="en">
    <head>
        <title>Weird Static Frontend for <?php echo env('APP_NAME'); ?></title>
    </head>
    <style>
tr, td {
    border: 1px dotted black;
    padding: 2px;
}
#search-results {
    margin-top: 8px;
}
    </style>
    <script>
var queried_page = 0;
var modal_data = {};
/* More vanilla than Mr. Ice #dances */
function search() {
    let ele_srchby = document.getElementById('search-by');
    let by = ele_srchby.options[ele_srchby.selectedIndex].value;
    let ele_query = document.getElementById('search-query');
    let query = ele_query.value;
    if (query.length == 0) {
        alert('going to need a query cap\'n. i\'ll be nice and move the cursor for you to where you can type things in...');
        ele_query.focus();
        return;
    }
    console.log('searching...');
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log('got...');
            const dataz = xhr.responseText;
            try {
                json_databases = JSON.parse(dataz);
            } catch (SyntaxError) {
                console.log('errored...');
                return;
            }
            if ("error" in json_databases) {
                alert('I gots an error. It is [' + json_databases.error + ']');
            }
            if ("results" in json_databases) {
                display_results(json_databases);
            }
        }
    };
    xhr.open('GET', '/search/' + by + '/' + query + '/' + queried_page, true);
    xhr.send();
}

function display_results(j) {
    var results = document.getElementById('search-results');
    results.innerHTML = '';
    var b = ''; /* Our buffer */
    /* Don't like tables but gonna use that oldness like it's 1994 */
    if (j.result_count == 0) {
        results.innerHTML = 'no results found. please hang up and try again. if you need help dial 0 for an operator.';
        return;
    }
    modal_data = j.results;
    for (let i = 0; i < j.results.length; i++) {
        let r = j.results[i];
        b += '<tr onclick="modal_dump(' + i + ');">';
        b += '<td>' + r.number + '</td>'; /* npi number */
        b += '<td>' + (r.basic.first_name ? r.basic.first_name : '') + '</td>'; /* first_name */
        b += '<td>' + (r.basic.last_name ? r.basic.last_name : '') + '</td>'; /* last_name */
        b += '<td>' + (r.addresses[0].city ? r.addresses[0].city : '') + '</td>'; /* city */
        b += '<td>' + (r.addresses[0].state ? r.addresses[0].state : '') + '</td>'; /* state */
        b += '<td>' + (r.addresses[0].postal_code ? r.addresses[0].postal_code : '') + '</td>'; /* zip */
        if (r.taxonomies.length > 0) {
            b += '<td>' + r.taxonomies[0].desc + '</td>'; /* zip */
        } else {
            b += '<td></td>';
        }
        b += '</tr>';
        b += '<tr><td colspan="7" id="openable_' + i + '" style="display:none;"><a href="#" onclick="document.getElementById(\'openable_' + i + '\').style.display = \'none\';">[close]</a><br /><pre>' + mydump(r, 0) + '</pre></td></tr>'; /* Open to dump data */
    }
    results.innerHTML = '<table>' + '<tr> <th>NPI Number</th> <th>First Name</th> <th>Last Name</th> <th>City</th> <th>State</th> <th>Postal</th> <th>Taxonomy Description</th> </tr>' + b + '</table>';
    if (queried_page > 0) {
        results.innerHTML = results.innerHTML + '<a href="#" onclick="previous_page();">[previous]</a>';
    }
    results.innerHTML = results.innerHTML + '<a href="#" onclick="next_page();">[next]</a>';
}

/* Simple page navigation. #yolo */
function previous_page() {
    queried_page--;
    search();
}
function next_page() {
    queried_page++;
    search();
}

function modal_dump(i) {
    /* cheesy way to display information. It didn't say "make it look nice and pretty", it said "Additional information can be formatted manually". What better way... */
    document.getElementById('openable_' + i).style.display = 'table-cell';
}

function mydump(arr, level) {
    var dumped_text = "";
    if(!level) level = 0;

    var level_padding = "";
    for(var j=0;j<level+1;j++) level_padding += "    ";

    if(typeof(arr) == 'object') {  
        for(var item in arr) {
            var value = arr[item];

            if(typeof(value) == 'object') { 
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += mydump(value,level+1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { 
        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
    }
    return dumped_text;
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
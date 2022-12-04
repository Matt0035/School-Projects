let addOrUpdate; // need this because the same panel is used for adds and updates

window.onload = function () {

    // add event handlers for buttons
    document.querySelector("#GetButton").addEventListener("click", getAllItems);
    document.querySelector("#DeleteButton").addEventListener("click", deleteItem);
    document.querySelector("#AddButton").addEventListener("click", addItem);
    document.querySelector("#UpdateButton").addEventListener("click", updateItem);
    document.querySelector("#DoneButton").addEventListener("click", processForm);
    document.querySelector("#CancelButton").addEventListener("click", cancelAddUpdate);

    // add event handler for selections on the table
    document.querySelector("table").addEventListener("click", handleRowClick);
    hideUpdatePanel();
};

// "Get Data" button
function getAllItems() {
    // let url = "api/getAllItems.php";
    let url = "playerStatsService/items"; // REST-style: URL refers to an entity or collection, not an action
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0) {
                alert("oh no... see console for error");
                console.log(resp);
            } else {
                buildTable(xmlhttp.responseText);
                clearSelections();
                resetUpdatePanel();
                hideUpdatePanel();
            }
        }
    };
    xmlhttp.open("GET", url, true); // HTTP verb says what action to take; URL says which item(s) to act upon
    xmlhttp.send();

    // disable Delete and Update buttons
    document.querySelector("#DeleteButton").setAttribute("disabled", "disabled");
    document.querySelector("#UpdateButton").setAttribute("disabled", "disabled");
}

// "Delete" button
function deleteItem() {
    let id = document.querySelector(".highlighted").querySelector("th").innerHTML;
    //let url = "api/deleteItem.php";
    let url = "playerStatsService/items/" + id; // entity, not action
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            if (resp.search("ERROR") >= 0 || resp != 1) {
                alert("could not complete request");
                console.log(resp);
            } else {
                getAllItems();
            }
        }
    };
    xmlhttp.open("DELETE", url, true); // "DELETE" is the action, "url" is the entity
    xmlhttp.send();
}

// "Add" button
function addItem() {
    // Show panel, panel handler takes care of the rest
    addOrUpdate = "add";
    resetUpdatePanel();
    showUpdatePanel();
}

// "Update" button
function updateItem() {
    addOrUpdate = "update";
    resetUpdatePanel();
    populateUpdatePanelWithSelectedItem();
    showUpdatePanel();
}

// "Done" button (on the input panel)
function processForm() {
    let seasonID = document.querySelector("#SeasonIDInput").value;
    let seasonStart = document.querySelector("#seasonDateStart").value;
    let seasonEnd = document.querySelector("#seasonDateEnd").value;
    let team = document.querySelector("#teamInput").value;
    let gamesPlayed = document.querySelector("#gamesPlayedInput").value;
    let ppg = document.querySelector("#ppgInput").value;
    let rpg = document.querySelector("#rpgInput").value;
    let apg = document.querySelector("#apgInput").value;
    let totalMins = document.querySelector("#totalMinsInput").value;
    let totalPoints = document.querySelector("#totalPointsInput").value;
    

    let obj = {
        "seasonID": seasonID,
        "seasonStart": seasonStart,
        "seasonEnd": seasonEnd,
        "team": team,
        "gamesPlayed": gamesPlayed,
        "ppg": ppg,
        "rpg": rpg,
        "apg": apg,
        "totalMins": apg,
        "totalPoints": totalPoints
    };

    console.log(obj);
    let url = "playerStatsService/items/" + seasonID;
    let method = (addOrUpdate === "add") ? "POST" : "PUT";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            if (resp.search("ERROR") >= 0 || resp != 1) {
                alert("could not complete request");
            
            } else {
                getAllItems();
            }
        }
    };
    xmlhttp.open(method, url, true); // method is either POST or PUT
    xmlhttp.send(JSON.stringify(obj));
}

// "Cancel" button (on the input panel)
function cancelAddUpdate() {
    hideUpdatePanel();
}

function clearSelections() {
    let trs = document.querySelectorAll("tr");
    for (let i = 0; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");
    }
}

function handleRowClick(e) {
    //add style to parent of clicked cell
    clearSelections();
    e.target.parentElement.classList.add("highlighted");

    // enable Delete and Update buttons
    document.querySelector("#DeleteButton").removeAttribute("disabled");
    document.querySelector("#UpdateButton").removeAttribute("disabled");
}

function showUpdatePanel() {
    document.getElementById("AddUpdatePanel").classList.remove("hidden");
}

function hideUpdatePanel() {
    document.getElementById("AddUpdatePanel").classList.add("hidden");
}

function resetUpdatePanel() {
    document.querySelector("#SeasonIDInput").value = "";
    document.querySelector("#seasonDateStart").value = "";
    document.querySelector("#seasonDateEnd").value = 0;
    document.querySelector("#teamInput").value = "";
    document.querySelector("#gamesPlayedInput").value = 0;
    document.querySelector("#ppgInput").checked.value = 0.0;
    document.querySelector("#rpgInput").checked.value = 0.0;
    document.querySelector("#apgInput").checked.value = 0.0;
    document.querySelector("#totalMinsInput").value = 0;
    document.querySelector("#totalPointsInput").value = 0;
}

function populateUpdatePanelWithSelectedItem() {
    let tds = document.querySelector(".highlighted").querySelectorAll("td");
    let ths = document.querySelector(".highlighted").querySelectorAll("th");
    let dates = tds[0].innerHTML.split("-");
    let startDate = dates[0];
    let endDate = dates[1];
    
    document.querySelector("#SeasonIDInput").value = ths[0].innerHTML;
    document.querySelector("#seasonDateStart").value = startDate;
    document.querySelector("#seasonDateEnd").value = endDate;
    document.querySelector("#teamInput").value = tds[1].innerHTML;
    document.querySelector("#gamesPlayedInput").value = tds[2].innerHTML;
    document.querySelector("#ppgInput").value = tds[3].innerHTML;
    document.querySelector("#rpgInput").value = tds[4].innerHTML;
    document.querySelector("#apgInput").value = tds[5].innerHTML;
    document.querySelector("#totalMinsInput").value = tds[6].innerHTML;
    document.querySelector("#totalPointsInput").value = tds[7].innerHTML;
}

function buildTable(text) {
    let data = JSON.parse(text);
    let theTable = document.querySelector("table");
    let html = theTable.querySelector("tr").innerHTML;
        for (let i = 0; i < data.length; i++) {
            let temp = data[i];
            html += "<tr>";
            html += "<th scope='row'>" + temp.seasonID + "</th>";
            html += "<td>" + temp.seasonStart + "-" + temp.seasonEnd + "</td>";
            html += "<td>" + temp.team + "</td>";
            html += "<td>" + temp.gamesPlayed + "</td>";
            html += "<td>" + temp.ppg + "</td>";
            html += "<td>" + temp.rpg + "</td>";
            html += "<td>" + temp.apg + "</td>";
            html += "<td>" + temp.totalMins + "</td>";
            html += "<td>" + temp.totalPoints + "</td>";
            html += "</tr>";
        }
    theTable.innerHTML = html;
}

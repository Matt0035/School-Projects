<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>Morton A7 REST</title>
        <link rel="stylesheet" href="dbDemoStyles.css">
        <script src="dbDemoMain.js"></script>
    </head>
    <body>
        <h1>Lebron Season Stats</h1>

        <button id="GetButton">Get Data</button>
        <br>
        <button id="AddButton">Add</button>
        <button id="DeleteButton" disabled>Delete</button>
        <button id="UpdateButton" disabled>Update</button>

        <div id="AddUpdatePanel">
            <div>
                <div class="formLabel">Season ID</div><input id="SeasonIDInput" type="numeric" required>
            </div>
            
            <div>
                <div class="formLabel">Season Started</div><input id="seasonDateStart" type="text" required> 
            </div>
            
            <div>
                <div class="formLabel">Season Ended</div><input id="seasonDateEnd" type="text" required>
            </div>
            
            <div>
                <div class="formLabel">Team</div><input id="teamInput" type="text" required>
            </div>
            
            <div>
                <div class="formLabel">Games Played</div><input id="gamesPlayedInput" type="numeric" required>
            </div>
            
            <div>
                <div class="formLabel">PPG</div><input id="ppgInput" type="numeric" required>
            </div>
            
            <div>
                <div class="formLabel">RPG</div><input id="rpgInput" type="numeric" required>
            </div>
            <div>
                <div class="formLabel">APG</div><input id="apgInput" type="numeric" required>
            </div>
            <div>
                <div class="formLabel">Total Minutes</div><input id="totalMinsInput" type="numeric" required>
            </div>
            <div>
                <div class="formLabel">Total Points</div><input id="totalPointsInput" type="numeric" required>
            </div>
            <div>
                <button id="DoneButton">Done</button>
                <button id="CancelButton">Cancel</button>
            </div>
        </div>
        
            <table class="table table-hover">
            <tr>
                <th scope="col">Year</th>
                <th scope="col">Season</th>
                <th scope="col">Team</th>
                <th scope="col">GP</th>
                <th scope="col">PPG</th>
                <th scope="col">APG</th> 
                <th scope="col">RPG</th> 
                <th scope="col">MIN</th>
                <th scope="col">PTS</th>
            </tr>
        </table>

    </body>
</html>

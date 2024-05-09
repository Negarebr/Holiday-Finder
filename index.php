<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holidays Finder</title>

    <style>

        .main
        {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form{
            background-color: darkgrey;
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
        }
        .form{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        input{
            border-radius: 5px;
            border: none;
            padding: 5px;
        }
        .btn{
            cursor: pointer;
        }
        h1{
            margin-top: 10px;
        }
        .resault{
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
        }
        .holiday{
            border: 1px solid black;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            background-color: lightgrey;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 50%;
        }


    </style>

</head>
<body>
    <div class="main">
        <form action="index.php" method="get">
            <h1>Holidays Finder</h1>
            <div class="form">
                Country Code:<br> <input type="text" name="country" class="text" required>
                <br><br>
                Year:<br> <input type="text" name="year" class="text" required>
                <br><br>
                <input class="btn" type="submit" name="submit" value="Search!">
            </div>
        </form>    
    </div>
    <div class="resault">
    <?php
        if (isset($_GET['country']) && isset($_GET['year'])) {
            $country = $_GET['country'];
            $year = $_GET['year'];
            $json_data = file_get_contents('https://calendarific.com/api/v2/holidays?api_key=PIqeAd8KWiTnpG9VVfzI3U5VcGPFf0vm&country=' . $country . '&year=' . $year);


            $data = json_decode($json_data, true);

            if ($data['meta']['code'] == 200) {
                if(isset($data['response']['holidays'])) {
                    $holidays = $data['response']['holidays'];

                    foreach ($holidays as $holiday) {
                        echo '<div class="holiday">';
                        echo '<p><strong>Name:</strong> ' . $holiday['name'] . '</p>';
                        echo '<p><strong>Description:</strong> ' . $holiday['description'] . '</p>';
                        echo '<p><strong>Country:</strong> ' . $holiday['country']['name'] . '</p>';
                        echo '<p><strong>Date:</strong> ' . $holiday['date']['iso'] . '</p>';
                        echo '<p><strong>Type:</strong> ' . implode(', ', $holiday['type']) . '</p>';
                        echo '<p><strong>URL:</strong> <a href="' . $holiday['canonical_url'] . '" target="_blank">' . $holiday['canonical_url'] . '</a></p>';
                        echo '</div>';
                    }
                }
                else {
                    echo '<script>alert("No holidays found for the specified country and year.");</script>';
                }
            }
            else {
                echo '<script>alert("An error occurred: " + ' . $data['meta']['error_message'] . ');</script>';
            }
        }
    ?>
    </div>
</body>
</html>
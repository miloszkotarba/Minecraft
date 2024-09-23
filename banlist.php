<?php
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.mcstatus.io/v2/status/java/minecraft.kotika.pl",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "CURL Error #:" . $err;
}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style.css"/>
    <title>BANLIST Minecraft - Informatykersi</title>
    <style>
        body {
            background: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="menu">
        <nav>
            <ul>
                <li class="players">
                    <?php
                    $data = json_decode($response, true);
                    $online = $data['online'];
                    if (!empty($online)) {
                        echo '<div class="circle"></div>';
                        $players_online = $data['players']['online'];
                        $players_max = $data['players']['max'];
                        echo "Gracze online: ";
                        echo "<b>" . $players_online . "/" . $players_max . "</b>";
                    } else {
                        echo '<div class="circle red"></div>';
                        echo "Serwer offline.";
                    }
                    ?>
                </li>
                <div style="display: flex; gap: 1.5rem">
                    <a href="#">
                        <li class="shop">SKLEP</li>
                    </a>
                    <a href="index.php">
                        <li class="shop home">STRONA GŁÓWNA</li>
                    </a>
                </div>
            </ul>
        </nav>
    </div>
    <div class="content">
        <h2 style="text-align: center; margin-bottom: 3.2rem; font-weight: 600; font-size: 3rem">BanLista</h2>
        <div class="banlist">
            <table>
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Gracz</th>
                    <th>Powód</th>
                    <th>Typ blokady</th>
                    <th>Wygasa</th>
                    <th>Administrator</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once 'dbconnect.php';
                $pol = new mysqli($db_host,$db_user,$db_password,$db_name);
                if($pol -> connect_errno != 0) {
                    echo "Błąd połączenia z bazą danych!";
                    echo $pol -> connect_error;
                    exit();
                }
                else {
                    $query = "SELECT * FROM bans ORDER BY time DESC";
                    $final = $pol -> query($query);
                    $num_rows = $final -> num_rows;
                    while($row = $final -> fetch_array()) {
                        $expires = $row['expires'] / 1000;
                        $expires = date('Y-m-d H:i:s',$expires);
                        echo <<< END
                        <tr>
                    <td>2023-09-15 12:13</td>
                    <td class="user">
                    END;
                        echo '<div class="avatar"><img src="https://mc-heads.net/avatar/'.$row['name'].'/50/nohelm" alt=".'.$row['name'].'">
                        </div>
                        <div class="username">'.$row['name'].'</div>
                    </td>
                    <td>'.$row['reason'].'</td>
                    <td><span class="temp">Tymczasowy</span></td>
                    <td>'.$expires.'</td>
                    <td class="user">
                        <div class="avatar"><img src="https://mc-heads.net/avatar/'.$row['banner'].'/50/nohelm"
                                                 alt="'.$row['banner'].'"></div>
                        <div class="username">'.$row['banner'].'</div>
                    </td>
                </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

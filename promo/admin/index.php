<?php

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ( $contentType === "application/json" ) :

    $file = 'guestlist.json';
    $backup = 'backup.json';
    $jsonString = file_get_contents($file);
    $jsonData = json_decode($jsonString, true);

    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    $jsonData[] = $decoded;

    $jsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
    $fp = fopen($file, 'w');
    fwrite($fp, $jsonString);
    fclose($fp);

    $backup_fp = fopen($backup, 'w');
    fwrite($backup_fp, $jsonString);
    fclose($backup_fp);

    $htmlBody = '<html><head>';
    $htmlBody .= '<style>
        @media (prefers-color-scheme: dark) {
            body {
                background: #000!important;
                color: #fff!important;
            }
        }
    </style>';
    $htmlBody .= '</head><body style="background:#000!important;color:#fff!important;text-align:center;padding:3rem 1rem;">';
    $htmlBody .= '<h2 style="font-size:1.75rem;line-height:1.25em;text-transform:uppercase;letter-spacing:0.0125em;font-weight:bold;">'.$decoded['name'].'</h2>';
    $htmlBody .= '<p style="font-size:1.75rem;line-height:1.25em;text-transform:uppercase;letter-spacing:0.0125em;font-weight:bold;">Welcome to the Premiere of<br/>Mankovsky Gallery Popup Space<br/><br/>Saturday 4th of March<br/>15:00 – 18:00<br/><br/><a href="https://goo.gl/maps/W48d49cqeZ28qnPe7" style="text-decoration:none;color:inherit;" target="_blank">Vallgatan 15<br/>Göteborg</a></p>';
    $htmlBody .= '<p style="font-size:1rem;line-height:1.25em;text-transform:uppercase;letter-spacing:0.0125em;font-weight:bold;">Jonatan Erlandsson<br/>Gallery Director<br/><a href="mailto:jonatan@mankovskygallery.com" style="text-decoration:none;color:inherit;">jonatan@mankovskygallery.com</a></p>';
    $htmlBody .= '</body></html>';
    $data = array(
        'From' => 'rsvp@mankovskygallery.com',
        'To' => $decoded['email'],
        'Subject' => 'Mankovsky Gallery Pop-up Space',
        'TextBody' => $decoded['name'].', we look forward to seeing you. Saturday 4th of March, 15:00-18:00, Vallgatan 15, Göteborg. Jonatan Erlandsson, jonatan@mankovskygallery.com',
        'HtmlBody' => $htmlBody,
        'MessageStream' => 'outbound',
    );
    $post_data = json_encode($data);
    debug_to_console($data);

    $crl = curl_init('https://api.postmarkapp.com/email');
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLINFO_HEADER_OUT, true);
    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    
    curl_setopt($crl, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json',
        'X-Postmark-Server-Token: e174f893-50d5-4292-a65c-e63f24e47ba1'
    ));
    
    $result = curl_exec($crl);
    
    if ($result === false) {
        $result_noti = 0; die();
    } else {
        $result_noti = 1; die();
    }

    curl_close($crl);

    header("Content-Type: application/json");
    print json_encode($decoded);
    exit();

else :
    
    session_start();

    if (!empty($_POST)) :

        if ($_POST['pass'] == 'mankovsky2025') :

            $_SESSION['access'] = '1';

        endif;

        header("Refresh: 0;");
        die;

    elseif (!$_SESSION['access']) :

        print '<form style="margin:2em 1em;display:flex;flex-flow:row;gap:0.5em;" method="POST" action="">';
        print '<input type="password" name="pass" placeholder="Enter password" />';
        print '<input type="submit" value="Log in" />';
        print '</form>';
        die();

    else :

        $guestlist = 'guestlist.json';
        $guestlistStr = file_get_contents($guestlist);
        $guestlistData = json_decode($guestlistStr, true);
        ?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Manovsky - Guestlist</title>
            <style>
                body {
                    font-family: sans-serif;
                }

                table {
                    border: 1px solid #ddd;
                    width: 100%;
                }

                th {
                    background-color: #f6f6f6;
                    text-align: left;
                    font-weight: normal;
                    border: 1px solid #ddd;
                }

                td {
                    border: 1px solid #ddd;
                }
            </style>
        </head>

        <body>

            <?php
            $total = 0;
            foreach ($guestlistData as $row) :
                if ( $row['name'] != '' )
                    $total++;
                if ( $row['friend1_name'] != '' )
                    $total++;
                if ( $row['friend2_name'] != '' )
                    $total++;
                if ( $row['friend3_name'] != '' )
                    $total++;
            endforeach;
            ?>

            <h2>Manovsky - Guestlist</h2>

            <p>Registered guests: <?php print $total; ?></p>

            <table cellspacing="0" cellpadding="10">
                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Phone</th>
                    <th>Friends name</th>
                    <th>Friends name</th>
                    <th>Friends name</th>
                </tr>
                <?php foreach ($guestlistData as $row) :
                    print '<tr>';
                    print '<td>' . $row['name'] . '</td>';
                    print '<td>' . $row['email'] . '</td>';
                    print '<td>' . $row['phone'] . '</td>';
                    print '<td>' . $row['friend1_name'] . '</td>';
                    print '<td>' . $row['friend2_name'] . '</td>';
                    print '<td>' . $row['friend3_name'] . '</td>';
                    print '</tr>';
                endforeach; ?>
            </table>

        </body>

        </html>

    <?php endif;

endif;
?>
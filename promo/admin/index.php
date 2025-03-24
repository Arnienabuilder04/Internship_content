<?php

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

<?php endif; ?>
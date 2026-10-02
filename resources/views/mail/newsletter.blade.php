
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    font-family: Arial, Helvetica, sans-serif;
    color: #333333;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background-color: #f4f4f4; padding: 40px 15px;">

    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="600" cellpadding="0" cellspacing="0" border="0"
                   style="
                       max-width: 600px;
                       width: 100%;
                       background-color: #ffffff;
                       border-radius: 10px;
                       overflow: hidden;
                       box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                   ">

                <!-- Header -->
                <tr>
                    <td style="
                        background-color: #e63946;
                        padding: 30px;
                        text-align: center;
                    ">

                        <h1 style="
                            margin: 0;
                            color: #ffffff;
                            font-size: 26px;
                            font-weight: 700;
                        ">
                            {{ $title }}
                        </h1>

                        <p style="
                            margin: 8px 0 0;
                            color: #ffffff;
                            font-size: 14px;
                        ">
                            Les dernières nouvelles de notre restaurant
                        </p>

                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding: 35px 30px;">

                        <p style="
                            margin: 0 0 25px;
                            font-size: 16px;
                            line-height: 1.6;
                        ">
                            Bonjour,
                        </p>

                        <p style="
                            margin: 0 0 25px;
                            font-size: 15px;
                            line-height: 1.6;
                            color: #555555;
                        ">
                            Nous sommes heureux de partager avec vous
                            nos dernières actualités, nouveautés et offres.
                        </p>

                        <!-- Newsletter Content -->
                        <div style="
                            background-color: #f8f9fa;
                            border-left: 4px solid #e63946;
                            padding: 20px;
                            border-radius: 5px;
                            margin-top: 20px;
                        ">

                            <h3 style="
                                margin: 0 0 10px;
                                font-size: 18px;
                                color: #333333;
                            ">
                                {{ $title }}
                            </h3>

                            <p style="
                                margin: 0;
                                font-size: 15px;
                                line-height: 1.7;
                                color: #555555;
                                white-space: pre-line;
                            ">
                                {{ $mailContent }}
                            </p>

                        </div>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="
                        background-color: #f8f9fa;
                        padding: 20px 30px;
                        text-align: center;
                        border-top: 1px solid #eeeeee;
                    ">

                        <p style="
                            margin: 0;
                            font-size: 13px;
                            color: #888888;
                        ">
                            Vous recevez cet email car vous êtes inscrit
                            à la newsletter de notre restaurant.
                        </p>

                        <p style="
                            margin: 8px 0 0;
                            font-size: 12px;
                            color: #aaaaaa;
                        ">
                            © {{ date('Y') }} Restaurant
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>


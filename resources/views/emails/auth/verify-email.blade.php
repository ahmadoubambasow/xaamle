<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Vérification de votre adresse e-mail</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f5f7fa;
    font-family: Arial, Helvetica, sans-serif;
    color: #1f2937;
">

<table width="100%"
       cellpadding="0"
       cellspacing="0"
       border="0"
       style="background-color: #f5f7fa; padding: 40px 15px;">

    <tr>
        <td align="center">

            <!-- Conteneur principal -->
            <table width="100%"
                   cellpadding="0"
                   cellspacing="0"
                   border="0"
                   style="
                       max-width: 600px;
                       background-color: #ffffff;
                       border-radius: 12px;
                       overflow: hidden;
                   ">

                <!-- Header -->
                <tr>
                    <td align="center"
                        style="
                            padding: 32px 30px;
                            background-color: #111827;
                        ">

                        <div style="
                            font-size: 30px;
                            font-weight: bold;
                            color: #ffffff;
                            letter-spacing: -0.5px;
                        ">
                            Xaamlé
                        </div>

                        <div style="
                            margin-top: 8px;
                            font-size: 14px;
                            color: #d1d5db;
                        ">
                            Le savoir se partage.
                        </div>

                    </td>
                </tr>

                <!-- Contenu -->
                <tr>
                    <td style="padding: 40px 35px;">

                        <h1 style="
                            margin: 0 0 20px;
                            font-size: 25px;
                            line-height: 1.3;
                            color: #111827;
                        ">
                            Bienvenue sur Xaamlé 👋
                        </h1>

                        <p style="
                            margin: 0 0 16px;
                            font-size: 16px;
                            line-height: 1.7;
                            color: #4b5563;
                        ">
                            Bonjour {{ $user->name }},
                        </p>

                        <p style="
                            margin: 0 0 16px;
                            font-size: 16px;
                            line-height: 1.7;
                            color: #4b5563;
                        ">
                            Merci d'avoir rejoint
                            <strong style="color: #111827;">
                                Xaamlé
                            </strong>,
                            la plateforme où chacun peut partager
                            ce qu'il sait, découvrir de nouvelles
                            connaissances et échanger avec une communauté.
                        </p>

                        <p style="
                            margin: 0 0 30px;
                            font-size: 16px;
                            line-height: 1.7;
                            color: #4b5563;
                        ">
                            Pour commencer à utiliser votre compte,
                            veuillez confirmer votre adresse e-mail.
                        </p>

                        <!-- Bouton -->
                        <table width="100%"
                               cellpadding="0"
                               cellspacing="0"
                               border="0">

                            <tr>
                                <td align="center">

                                    <a href="{{ $verificationUrl }}"
                                       style="
                                           display: inline-block;
                                           padding: 14px 28px;
                                           background-color: #111827;
                                           color: #ffffff;
                                           text-decoration: none;
                                           border-radius: 8px;
                                           font-size: 16px;
                                           font-weight: bold;
                                       ">
                                        Vérifier mon adresse e-mail
                                    </a>

                                </td>
                            </tr>

                        </table>

                        <p style="
                            margin: 30px 0 0;
                            font-size: 14px;
                            line-height: 1.6;
                            color: #6b7280;
                        ">
                            Ce lien de vérification est valable pendant
                            <strong>60 minutes</strong>.
                        </p>

                        <p style="
                            margin: 16px 0 0;
                            font-size: 14px;
                            line-height: 1.6;
                            color: #6b7280;
                        ">
                            Si vous n'êtes pas à l'origine de cette
                            inscription, vous pouvez simplement ignorer
                            cet e-mail.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="
                        padding: 25px 35px;
                        background-color: #f9fafb;
                        border-top: 1px solid #e5e7eb;
                    ">

                        <p style="
                            margin: 0;
                            text-align: center;
                            font-size: 13px;
                            line-height: 1.6;
                            color: #6b7280;
                        ">
                            À bientôt sur
                            <strong>Xaamlé</strong>.
                        </p>

                        <p style="
                            margin: 6px 0 0;
                            text-align: center;
                            font-size: 13px;
                            color: #9ca3af;
                        ">
                            Le savoir se partage.
                        </p>

                    </td>
                </tr>

            </table>

            <!-- Copyright -->
            <p style="
                margin: 20px 0 0;
                font-size: 12px;
                color: #9ca3af;
                text-align: center;
            ">
                © {{ date('Y') }} Xaamlé. Tous droits réservés.
            </p>

        </td>
    </tr>

</table>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Certification Equipe</title>
    <style>
        body {
            font-family: 'Impact', fantasy;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .certification {
            width: 600px;
            height: 500px;
            margin: 3rem auto auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        .header > h1{
            font-size: 2.5rem;
            color: goldenrod;
        }

        .header > p{
            font-size: 1rem;
            color: goldenrod;
        }


        hr{
            width: 10rem;
            height: .1rem;
            background-color: rgb(181,80,66);
        }

        .header {
            text-align: center;
        }

        .sous-header{
            text-align: center;
        }

        .logo {
            max-width: 100%;
            width: 8rem;
            height: 8rem;
        }

        .content {
            margin-top: 20px;
        }

        .content > p{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-style: italic;
            font-weight: bold;
        }

        .signature{
            margin-left: 1rem;
            width: 2.5rem;
            height: 2.5rem;
        }

        .content .left{
            float: left;
        }

        .content .left > p{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-style: italic;
            font-weight: bold;
        }

        .content .right{
            float: right;
        }

        .content .right > p{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-style: italic;
            font-weight: bold;
        }

        .signature strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="certification">
    <div class="header">
        <img src="https://t3.ftcdn.net/jpg/00/40/13/28/360_F_40132874_dYfZg6sp28usisQi9XWouH9uky8deUz7.webp" alt="Logo de l'Organisation" class="logo">
        <h1>RUNNING CHAMPION</h1>
        <p>TEAM {{ $equipe->nomequipe }}</p>
    </div>
   <hr>
    <div class="sous-header">
        <p>TRACK & FIELD CERTIFICATE</p>
    </div>
    <div class="content">
        <p>
            Has successfully,accomplish the track & field match from team company.
            We truly apprciate,the hard work, persistence and Teamwork, leads to ultimate victory.
        </p>
        <div class="left">
            <p>
                Total Point Team: {{ $equipe->total_point_obtenu }}
            </p>
            <hr>
{{--            <p>--}}
{{--                Total Time Team: {{ $equipe->total_temps_passe }}--}}
{{--            </p>--}}
        </div>
        <div class="right">
            <p>
                Signature
            </p>
            <img src="https://www.shutterstock.com/image-vector/handwritten-signature-signed-papers-documents-260nw-2248268539.jpg" class="signature">
        </div>
    </div>
</div>
</body>
</html>

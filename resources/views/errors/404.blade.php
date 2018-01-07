<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootflat-Admin Template</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="css/sites.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <![endif]-->
    <script type="text/javascript" src="dist/js/site.min.js"></script>
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #303641;
            color: #C1C3C6;

        }

        .err-msg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

        }

        .err-msg > h1 {
            font-size: 100px;
        }
    </style>
</head>
<body>
<div class="container">
    @if(config('app.debug'))
        {{ $exception->getMessage() }}

        <table>
            @foreach($exception->getTrace() as $position => $e)
            <tr><td>{{ $position }}</td><td>{{ $e['file'] }} </td></tr>

            @endforeach
        </table>

    @endif

    <div class="err-msg">
        <h1>404 :(</h1>
    </div>
</div>
<div class="clearfix"></div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title> OoDoO | Support</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="#">
        <link rel="apple-touch-icon" href="#">
        <link rel="apple-touch-icon" sizes="72x72" href="#">
        <link rel="apple-touch-icon" sizes="114x114" href="#">
  <script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>

  <!-- CodeMirror -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.css" />

  <!-- Firepad -->
  <link rel="stylesheet" href="https://cdn.firebase.com/libs/firepad/1.2.0/firepad.css" />
  <script src="https://cdn.firebase.com/libs/firepad/1.2.0/firepad.min.js"></script>        
        <!--Loading bootstrap css-->
<!--     	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
        <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300"> -->
        @include('support.partials.css_assets')
        @include('support.partials.js_assets')
    </head>

    <body>
        @include('support.layouts.navbar')
        @include('support.layouts.sidebar')
    </body>
</html>
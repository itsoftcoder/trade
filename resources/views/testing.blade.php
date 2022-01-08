<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing</title>
</head>
<body>
    <h1>this is testing perpose</h1>
    <p>Testing</p>
    @include('includes.number-to-word')
    <?php 
    
    $obj = new NumberToWords();

    echo $obj->convert(586.56, "SAR");
    
    ?>
</body>
</html>
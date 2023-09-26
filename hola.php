<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>
        <?php
        $y = [
            'a' => [
                4,
                3,
                2,
            ],
            'b' => [
                2,
                5,
            ],
        ];
        echo $y['b'][1];
        ?>
    </p>
</body>
</html>

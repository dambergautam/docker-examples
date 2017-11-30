<html>
    <head>
        <title>My product list</title>
    </head>

    <body>
        <h1>Product List</h1>
        <ul>
        <?php 
            $json = file_get_contents('http://product-service');
            $items = json_decode($json)->product;

            foreach ($items as $item) {
                echo "<li>".$item."</li>";
            }
        ?>
        </ul>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .recipe {
            
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Recepty</h1>

    <?php
    require_once("SmartCookClient.php");

    $request_data = [
        "attributes" => ["id", "name", "author"],
        "filter" => []
    ];

    try {
        $data = (new SmartCookClient)
            ->setRequestData($request_data)
            ->sendRequest("recipes")
            ->getResponseData();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    foreach ($data["data"] as $key => $value) {
        echo "<li class='recipe ".str_replace(" ","_",$value["author"])."'>".$value["name"]." (ID=".$value["id"].")</li>";
    }
    ?>
    <script>
        const recipes = Array.from(document.getElementsByClassName("recipe"))
        let authors = []

        recipes.forEach((recipe) => {
            let auth = recipe.classList.item(1)
            if (authors.includes(auth)) {
                document.getElementById(auth).appendChild(recipe)
            } else {
                authors.push(auth)

                let spa = document.createElement("span")

                let heade = document.createElement("h2")
                heade.innerHTML = auth.replace("_", " ")

                let lis = document.createElement("ul")
                lis.setAttribute("id", auth)

                spa.appendChild(heade)
                spa.appendChild(lis)
                lis.appendChild(recipe)
                document.body.appendChild(spa)
            }
        })
    </script>
</body>
</html>

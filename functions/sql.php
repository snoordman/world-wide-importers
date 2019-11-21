<?php
    function createConn(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $port = 3306;
        $databasename = "wideworldimporters";

        $conn = new mysqli($servername, $username, $password, $databasename, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    // PRODUCTS //
    function getProducts($amountResults = 10){
        $conn = createConn();

        $query = $conn->prepare( "
            SELECT  si.StockItemId, si.StockItemName, si.RecommendedRetailPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
        ");

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductById($id){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  si.StockItemId, si.StockItemName, si.RecommendedRetailPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
            WHERE   si.StockItemId = ? 
        ");

        $query->bind_param("i", $id);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_assoc();
        }else{
            return "Geen resultaten";
        }
    }

    function getPhotosProduct($stockItemId){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT Photo
            FROM stockItemPhotos sp
            JOIN photos p ON sp.PhotoId = p.PhotoId
            WHERE sp.StockItemId = ?
        ");

        $query->bind_param("i", $stockItemId);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductBySearch($search){
        $conn = createConn();

        $search = "%".$search."%";

        $query = $conn->prepare( "
            SELECT  StockItemId, StockItemName
            FROM    stockitems
            WHERE   StockItemId = ?
            OR      StockItemName LIKE ?
            OR      SearchDetails LIKE ? 
        ");

        $query->bind_param("iss", $search, $search, $search);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductByFilter($stockGroupId, $price = null){
        $conn = createConn();
        $clause = implode(',', array_fill(0, count($stockGroupId), '?'));
        $types = str_repeat('i', count($stockGroupId));
        $filters = [];
        if($stockGroupId !== null){
            $filters = $stockGroupId;
        }
        if($price !== null){
            array_push($filters, $price);
        }

        $categoriesFilter = "";
        if($stockGroupId !== null){
            $categoriesFilter = "
                WHERE si.StockItemId IN (
                SELECT StockItemId
                FROM stockitemstockgroups
                WHERE StockGroupId IN ($clause) 
            )
            ";
        }

        $priceFilter = "";
        if($price !== null){
            if($stockGroupId == null){
                $priceFilter = "
                    WHERE RecommendedRetailPrice <= ? 
                ";
            }else{
                $priceFilter = " 
                    AND RecommendedRetailPrice <= ?
                ";
            }
            $types = $types . "s";
        }

        $query = $conn->prepare("
            SELECT si.StockItemId, si.StockItemName
            FROM stockitems AS si
            $categoriesFilter
            $priceFilter
        ");

        $query->bind_param($types, ...$filters);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }
    // PRODUCTS //

    // CATEGORIES //
    function getCategories(){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT stockGroupId, StockGroupName
            FROM stockgroups
        ");
        $query->execute();
        $categories = $query->get_result();

        $conn->close();

        if($categories->num_rows > 0){
            return $categories->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }
    // CATEGORIES //

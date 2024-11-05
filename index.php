<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text=danger text-center">Work of Tracker</h1>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Ism</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name">
            </div>
            <div class="mb-3">
                <label for="arrived_at" class="form-label">Kelgan vaqt</label>
                <input type="datetime-local" class="form-control" id="arrived_at" name="arrived_at">
            </div>
            <div class="mb-3">
                <label for="leaved_at" class="form-label">Ketgan vaqt</label>
                <input type="datetime-local" class="form-control" id="leaved_at" name="leaved_at">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <?php
        $dsn = 'mysql:host=127.0.0.1;dbname=work_of_tracker';
        $pdo = new PDO($dsn, 'root', '5555');
        
        $stmt = $pdo->query("SELECT * FROM work_time");
        foreach($stmt as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['arrived_at'] . "</td>";
            echo "<td>" . $row['leaved_at'] . "</td>";
            echo "</tr>";

        }

    ?>
  </tbody>
</table>        
    </div>
    
    <?php
    
    $dsn = 'mysql:host=127.0.0.1;dbname=work_of_tracker';
    $pdo = new PDO($dsn, 'root', '5555');


    if (isset($_POST['name']) && isset($_POST['arrived_at']) && isset($_POST['leaved_at'])) {
        if(!empty($_POST['name']) && !empty($_POST['arrived_at']) && !empty($_POST['leaved_at'])) {
        
        $name = $_POST['name'];
        $arrived_at = $_POST['arrived_at'];
        $leaved_at = $_POST['leaved_at'];

        $query = "INSERT INTO work_time (name,arrived_at,leaved_at, required_of )
            VALUES (:name, :arrived_at, :leaved_at, :required_of )";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam('arrived_at', $arrived_at);
        $stmt->bindParam('leaved_at', $leaved_at);
        $stmt->bindParam(':required_of', $total);
        $stmt->execute();
    
        }
    }

    ?>

</body>
</html>
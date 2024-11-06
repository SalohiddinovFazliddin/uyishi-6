<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-info-subtle">
    
    <div class="container bg-info-subtle">
        <h1 class="text=danger text-center">Work of Tracker</h1>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Ism</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" placeholder="Ismingizni kiriting">
            </div>
            <div class="mb-3">
                <label for="arrived_at" class="form-label">Kelgan vaqt</label>
                <input type="datetime-local" class="form-control" id="arrived_at" name="arrived_at">
            </div>
            <div class="mb-3">
                <label for="leaved_at" class="form-label">Ketgan vaqt</label>
                <input type="datetime-local" class="form-control" id="leaved_at" name="leaved_at">
            </div>
            <button type="submit" class="btn btn-warning">Submit</button>
        </form>
        <table class="table table-sumbtle table-sumbtle">
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
        require 'DB.php';

        $db = new DB();
        
        $pdo = $db->pdo;
    
        const REQUIRED_WORK_HOUR_DAILY = 8;
    // foreach ($records as $record) {
    //     echo "<tr>
    //         <td>{$record['id']}</td>
    //         <td>{$record['name']}</td>
    //         <td>{$record['arrived_at']}</td>
    //         <td>{$record['leaved_at']}</td>
    //         <td>" . gmdate('H:i', $record['required_of'])
    // }
        
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
    
    if (isset($_POST['name']) && isset($_POST['arrived_at']) && isset($_POST['leaved_at'])) {
        if (!empty($_POST['name']) && !empty($_POST['arrived_at']) && !empty($_POST['leaved_at'])){
            $name = $_POST['name'];
            $arrived_at = new DateTime($_POST['arrived_at']);
            $leaved_at = new DateTime($_POST['leaved_at']);

            $diff = $arrived_at->diff($leaved_at);
            $hour = $diff->h;
            $minute = $diff->i;
            $second = $diff->s;
            $total = ((REQUIRED_WORK_HOUR_DAILY * 3600) - ($hour * 3600) + ($minute * 60));

            $query = "INSERT INTO work_time (name,arrived_at,leaved_at)
                VALUES (:name, :arrived_at, :leaved_at)";
            $stmt = $pdo->prepare($query);
    
            $stmt->bindParam(':name', $name);
            $stmt->bindValue('arrived_at', $arrived_at->format('Y-m-d H:i'));
            $stmt->bindValue('leaved_at', $leaved_at->format('Y-m-d H:i'));
            $stmt->execute();
            header('Location: index.php');
            return;
        }
    
    }
    ?>

</body>
</html>

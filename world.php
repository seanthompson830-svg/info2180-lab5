<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
$lookup  = filter_input(INPUT_GET, 'lookup', FILTER_SANITIZE_STRING);

if ($lookup === 'cities') {
    // Lookup cities
    $sql = "SELECT cities.name AS city, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table>
        <thead>
            <tr>
                <th>City</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= htmlspecialchars($row['district']) ?></td>
                    <td><?= htmlspecialchars($row['population']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
} else {
    // Lookup countries
    if (!$country) {
        $stmt = $conn->query("SELECT * FROM countries");
    } else {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <ul>
        <?php foreach ($results as $row): ?>
            <li><?= htmlspecialchars($row['name']) ?> — Ruled by <?= htmlspecialchars($row['head_of_state']) ?></li>
        <?php endforeach; ?>
    </ul>

    <?php
}
?>
